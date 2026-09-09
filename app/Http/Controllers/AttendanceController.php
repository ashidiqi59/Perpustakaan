<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\MemberBarcode;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Generate (or retrieve) the member barcode for the authenticated user.
     * Called via POST /member-barcode/generate
     */
    public function generateBarcode(Request $request)
    {
        $user = $request->user();

        if (!$user->isPengunjung()) {
            return back()->with('error', 'Hanya anggota perpustakaan yang dapat memiliki kartu anggota.');
        }

        MemberBarcode::getOrCreateForUser($user);

        return back()->with('success', 'Kartu anggota digital berhasil dibuat!');
    }

    /**
     * Halaman riwayat kunjungan milik user yang sedang login.
     * Called via GET /my-attendance
     */
    public function userHistory(Request $request)
    {
        $user = $request->user();

        $memberBarcode = $user->isPengunjung()
            ? MemberBarcode::getOrCreateForUser($user)
            : null;

        $logs = AttendanceLog::where('user_id', $user->id)
            ->orderBy('scanned_at', 'desc')
            ->paginate(20);

        $totalAll   = AttendanceLog::where('user_id', $user->id)->count();
        $totalWeek  = AttendanceLog::where('user_id', $user->id)->thisWeek()->count();
        $totalMonth = AttendanceLog::where('user_id', $user->id)
            ->whereMonth('scan_date', now()->month)
            ->whereYear('scan_date', now()->year)
            ->count();

        return view('my-attendance', compact('user', 'memberBarcode', 'logs', 'totalAll', 'totalWeek', 'totalMonth'));
    }

    /**
     * API endpoint: scan member barcode → catat presensi.
     * Returns JSON for AJAX from petugas dashboard.
     */
    public function apiScan(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Kode barcode tidak boleh kosong.']);
        }

        // Harus dimulai dengan prefix MEMBER-
        if (!str_starts_with($code, 'MEMBER-')) {
            return response()->json(['success' => false, 'message' => 'Format barcode tidak valid. Gunakan barcode kartu anggota.']);
        }

        // Cari barcode
        $memberBarcode = MemberBarcode::with('user')->where('barcode_code', $code)->first();

        if (!$memberBarcode) {
            return response()->json(['success' => false, 'message' => 'Barcode anggota tidak ditemukan. Kode tidak terdaftar.']);
        }

        $user = $memberBarcode->user;

        // Cek apakah sudah check-in hari ini
        if (AttendanceLog::hasCheckedInToday($user->id)) {
            $todayLog = AttendanceLog::where('user_id', $user->id)
                ->whereDate('scan_date', today())
                ->first();

            return response()->json([
                'success'    => false,
                'already_in' => true,
                'message'    => "⚠️ {$user->name} sudah check-in hari ini pada " . $todayLog->scanned_at->format('H:i') . " WIB. Silakan datang kembali besok.",
                'user'       => $this->userData($user, $todayLog),
            ]);
        }

        // Catat kehadiran
        $log = AttendanceLog::create([
            'user_id'    => $user->id,
            'scan_date'  => today()->toDateString(),
            'scanned_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "✅ Check-in berhasil! Selamat datang, {$user->name}.",
            'user'    => $this->userData($user, $log),
        ]);
    }

    /**
     * Halaman riwayat presensi lengkap (untuk petugas/admin).
     */
    public function history(Request $request)
    {
        $date  = $request->input('date', today()->toDateString());
        $name  = $request->input('name', '');

        $query = AttendanceLog::with('user')
            ->whereDate('scan_date', $date)
            ->orderBy('scanned_at', 'desc');

        if ($name) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$name}%"));
        }

        $logs       = $query->paginate(20)->withQueryString();
        $totalToday = AttendanceLog::whereDate('scan_date', today())->count();
        $totalWeek  = AttendanceLog::thisWeek()->count();
        $totalMonth = AttendanceLog::whereMonth('scan_date', now()->month)
            ->whereYear('scan_date', now()->year)
            ->count();

        return view('admin.attendance.index', compact('logs', 'date', 'name', 'totalToday', 'totalWeek', 'totalMonth'));
    }

    /**
     * Helper: format user data for JSON response
     */
    private function userData(User $user, ?AttendanceLog $log = null): array
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'npm'        => $user->npm,
            'prodi'      => $user->prodi,
            'avatar'     => $user->getAvatarUrl(),
            'scanned_at' => $log?->scanned_at?->format('H:i') . ' WIB',
            'scan_date'  => $log?->scan_date?->translatedFormat('l, d F Y'),
        ];
    }
}
