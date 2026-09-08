<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    /**
     * Dashboard scanner petugas
     */
    public function dashboard()
    {
        // Get recent scan activity (last 20 scans)
        $recentScans = Loan::with('user', 'book')
            ->where(function ($q) {
                $q->whereNotNull('loan_barcode_scanned_at')
                  ->orWhereNotNull('return_barcode_scanned_at');
            })
            ->orderByRaw('GREATEST(
                COALESCE(loan_barcode_scanned_at, "1970-01-01"),
                COALESCE(return_barcode_scanned_at, "1970-01-01")
            ) DESC')
            ->limit(20)
            ->get();

        // Today's scan stats
        $todayLoanScans   = Loan::whereDate('loan_barcode_scanned_at', today())->count();
        $todayReturnScans = Loan::whereDate('return_barcode_scanned_at', today())->count();
        $pendingLoans     = Loan::where('status', Loan::STATUS_MENUNGGU_KONFIRMASI)->count();
        $pendingReturns   = Loan::where('status', Loan::STATUS_MENUNGGU_PENGEMBALIAN)->count();

        return view('petugas.dashboard', compact(
            'recentScans',
            'todayLoanScans',
            'todayReturnScans',
            'pendingLoans',
            'pendingReturns'
        ));
    }

    /**
     * Process scan of loan barcode (PINJAM).
     * Called when petugas scans the loan barcode → confirms the loan is active.
     */
    public function scanLoan(Request $request)
    {
        $token = $request->input('token') ?? $request->route('token');

        if (!$token) {
            return $this->scanResponse($request, false, 'Token barcode tidak ditemukan.');
        }

        // Find loan by token
        $loan = Loan::where('loan_barcode', $token)->with('user', 'book')->first();

        if (!$loan) {
            return $this->scanResponse($request, false, 'Barcode tidak dikenali. Token tidak valid.');
        }

        // Check status
        if ($loan->status !== Loan::STATUS_MENUNGGU_KONFIRMASI) {
            $message = match($loan->status) {
                Loan::STATUS_PEMINJAMAN            => 'Barcode ini sudah pernah di-scan. Buku sedang dipinjam.',
                Loan::STATUS_EXPIRED               => 'Barcode ini sudah hangus/expired.',
                Loan::STATUS_DIKEMBALIKAN          => 'Buku ini sudah dikembalikan.',
                Loan::STATUS_MENUNGGU_PENGEMBALIAN => 'Buku ini sedang dalam proses pengembalian.',
                default                             => 'Status peminjaman tidak valid untuk scan ini.',
            };
            return $this->scanResponse($request, false, $message, $loan);
        }

        // Check if barcode is still valid (not expired)
        if (!$loan->isLoanBarcodeValid()) {
            return $this->scanResponse($request, false, 'Barcode sudah expired (kadaluarsa). Minta pengunjung untuk mengajukan ulang.', $loan);
        }

        // Mark as scanned and activate the loan
        $loan->update([
            'status'                   => Loan::STATUS_PEMINJAMAN,
            'loan_barcode_scanned_at'  => now(),
        ]);

        $loan->refresh();

        $message = "✅ Berhasil! Buku \"{$loan->book->title}\" siap diserahkan kepada {$loan->user->name}.";
        return $this->scanResponse($request, true, $message, $loan);
    }

    /**
     * Process scan of return barcode (KEMBALI).
     * Called when petugas scans the return barcode → confirms book is returned.
     */
    public function scanReturn(Request $request)
    {
        $token = $request->input('token') ?? $request->route('token');

        if (!$token) {
            return $this->scanResponse($request, false, 'Token barcode tidak ditemukan.');
        }

        // Find loan by return token
        $loan = Loan::where('return_barcode', $token)->with('user', 'book')->first();

        if (!$loan) {
            return $this->scanResponse($request, false, 'Barcode tidak dikenali. Token tidak valid.');
        }

        // Check status
        if ($loan->status !== Loan::STATUS_MENUNGGU_PENGEMBALIAN) {
            $message = match($loan->status) {
                Loan::STATUS_DIKEMBALIKAN => 'Buku ini sudah dikembalikan sebelumnya.',
                Loan::STATUS_PEMINJAMAN   => 'Pengunjung belum meminta pengembalian.',
                Loan::STATUS_TERLAMBAT    => 'Pengunjung belum meminta pengembalian (terlambat).',
                default                   => 'Status tidak valid untuk scan pengembalian ini.',
            };
            return $this->scanResponse($request, false, $message, $loan);
        }

        // Check if return barcode is still valid
        if (!$loan->isReturnBarcodeValid()) {
            // Revert status back to peminjaman/terlambat
            $revertStatus = $loan->due_date->isBefore(today())
                ? Loan::STATUS_TERLAMBAT
                : Loan::STATUS_PEMINJAMAN;

            $loan->update([
                'status'                    => $revertStatus,
                'return_barcode'            => null,
                'return_barcode_expires_at' => null,
            ]);

            return $this->scanResponse($request, false, 'Barcode pengembalian sudah expired. Minta pengunjung untuk generate ulang.', $loan);
        }

        // Process the return: restore stock, update status
        $loan->book->increment('stock');

        $loan->update([
            'status'                    => Loan::STATUS_DIKEMBALIKAN,
            'return_date'               => now()->toDateString(),
            'return_barcode_scanned_at' => now(),
        ]);

        $loan->refresh();

        $message = "✅ Buku \"{$loan->book->title}\" berhasil dikembalikan dari {$loan->user->name}. Stok buku +1.";
        return $this->scanResponse($request, true, $message, $loan);
    }

    /**
     * API endpoint for scanning via camera (returns JSON for AJAX).
     */
    public function apiScan(Request $request)
    {
        $token = $request->input('token');
        $type  = $request->input('type', 'auto'); // 'loan', 'return', or 'auto'

        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token kosong.']);
        }

        // Auto-detect type from token prefix
        if ($type === 'auto') {
            if (str_starts_with($token, 'PINJAM-')) {
                $type = 'loan';
            } elseif (str_starts_with($token, 'KEMBALI-')) {
                $type = 'return';
            } else {
                return response()->json(['success' => false, 'message' => 'Format barcode tidak dikenali.']);
            }
        }

        if ($type === 'loan') {
            $request->merge(['token' => $token]);
            $result = $this->processScanLoan($token);
        } else {
            $result = $this->processScanReturn($token);
        }

        return response()->json($result);
    }

    /**
     * Internal: process loan scan, return array result.
     */
    private function processScanLoan(string $token): array
    {
        $loan = Loan::where('loan_barcode', $token)->with('user', 'book')->first();

        if (!$loan) {
            return ['success' => false, 'message' => 'Barcode tidak dikenali.'];
        }

        if ($loan->status !== Loan::STATUS_MENUNGGU_KONFIRMASI) {
            return ['success' => false, 'message' => 'Barcode sudah digunakan atau tidak valid.', 'loan' => $this->loanData($loan)];
        }

        if (!$loan->isLoanBarcodeValid()) {
            return ['success' => false, 'message' => 'Barcode sudah expired.', 'loan' => $this->loanData($loan)];
        }

        $loan->update([
            'status'                  => Loan::STATUS_PEMINJAMAN,
            'loan_barcode_scanned_at' => now(),
        ]);

        $loan->refresh();

        return [
            'success' => true,
            'type'    => 'loan',
            'message' => "Berhasil! Buku \"{$loan->book->title}\" untuk {$loan->user->name}.",
            'loan'    => $this->loanData($loan),
        ];
    }

    /**
     * Internal: process return scan, return array result.
     */
    private function processScanReturn(string $token): array
    {
        $loan = Loan::where('return_barcode', $token)->with('user', 'book')->first();

        if (!$loan) {
            return ['success' => false, 'message' => 'Barcode pengembalian tidak dikenali.'];
        }

        if ($loan->status !== Loan::STATUS_MENUNGGU_PENGEMBALIAN) {
            return ['success' => false, 'message' => 'Status tidak valid untuk pengembalian.', 'loan' => $this->loanData($loan)];
        }

        if (!$loan->isReturnBarcodeValid()) {
            return ['success' => false, 'message' => 'Barcode pengembalian sudah expired.', 'loan' => $this->loanData($loan)];
        }

        $loan->book->increment('stock');
        $loan->update([
            'status'                    => Loan::STATUS_DIKEMBALIKAN,
            'return_date'               => now()->toDateString(),
            'return_barcode_scanned_at' => now(),
        ]);

        $loan->refresh();

        return [
            'success' => true,
            'type'    => 'return',
            'message' => "Buku \"{$loan->book->title}\" dari {$loan->user->name} berhasil dikembalikan.",
            'loan'    => $this->loanData($loan),
        ];
    }

    /**
     * Helper: format loan data for API response
     */
    private function loanData(Loan $loan): array
    {
        return [
            'id'        => $loan->id,
            'book'      => $loan->book?->title,
            'user'      => $loan->user?->name,
            'npm'       => $loan->user?->npm,
            'due_date'  => $loan->due_date?->format('d/m/Y'),
            'status'    => $loan->status,
        ];
    }

    /**
     * Helper: return appropriate response (redirect or JSON)
     */
    private function scanResponse(Request $request, bool $success, string $message, ?Loan $loan = null)
    {
        if ($request->expectsJson()) {
            $data = ['success' => $success, 'message' => $message];
            if ($loan) {
                $data['loan'] = $this->loanData($loan);
            }
            return response()->json($data);
        }

        $sessionKey = $success ? 'scan_success' : 'scan_error';
        return redirect()->route('petugas.dashboard')->with($sessionKey, $message);
    }
}
