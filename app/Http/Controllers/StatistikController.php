<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ── Ringkasan Umum ──────────────────────────────────────────
        $totalBooks      = Book::count();
        $totalStock      = Book::sum('stock');
        $totalUsers      = User::where('role', 'user')->count();
        $totalLoans      = Loan::count();
        $activeLoans     = Loan::whereIn('status', ['peminjaman', 'menunggu_konfirmasi', 'menunggu_pengembalian'])->count();
        $overdueLoans    = Loan::where('status', 'terlambat')
                               ->orWhere(function($q) use ($now) {
                                   $q->whereIn('status', ['peminjaman', 'menunggu_pengembalian'])
                                     ->where('due_date', '<', $now);
                               })->count();
        $returnedLoans   = Loan::where('status', 'dikembalikan')->count();
        $totalAttendance = DB::table('attendance_logs')->count();
        $lowStockCount   = Book::where('stock', '<=', 3)->where('stock', '>', 0)->count();
        $outOfStockCount = Book::where('stock', 0)->count();

        // ── Tren Peminjaman 12 Bulan Terakhir ──────────────────────
        $loanTrend = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $count = Loan::whereYear('created_at', $month->year)
                         ->whereMonth('created_at', $month->month)
                         ->count();
            $loanTrend->push([
                'label' => $month->format('M Y'),
                'count' => $count,
            ]);
        }

        // ── Tren Pengunjung (attendance) 12 Bulan Terakhir ─────────
        $attendanceTrend = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $count = DB::table('attendance_logs')
                       ->whereYear('created_at', $month->year)
                       ->whereMonth('created_at', $month->month)
                       ->count();
            $attendanceTrend->push([
                'label' => $month->format('M Y'),
                'count' => $count,
            ]);
        }

        // ── Pengguna Baru per Bulan (12 Bulan) ─────────────────────
        $userTrend = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $count = User::whereYear('created_at', $month->year)
                         ->whereMonth('created_at', $month->month)
                         ->where('role', 'user')
                         ->count();
            $userTrend->push([
                'label' => $month->format('M Y'),
                'count' => $count,
            ]);
        }

        // ── Top 10 Buku Paling Sering Dipinjam ─────────────────────
        $topBooks = DB::table('loans')
            ->join('books', 'loans.book_id', '=', 'books.id')
            ->selectRaw('books.id, books.title, books.author, books.image, COUNT(*) as total_loans')
            ->groupBy('books.id', 'books.title', 'books.author', 'books.image')
            ->orderByDesc('total_loans')
            ->limit(10)
            ->get();

        // ── Distribusi Status Peminjaman ────────────────────────────
        $loanStatusData = Loan::selectRaw('status, COUNT(*) as cnt')
            ->groupBy('status')
            ->pluck('cnt', 'status');

        // ── Distribusi Kategori Buku ────────────────────────────────
        $categoryStats = Book::selectRaw('category, COUNT(*) as total_titles, SUM(stock) as total_stock')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderByDesc('total_titles')
            ->get();

        // ── Kondisi Stok ────────────────────────────────────────────
        $safeStockCount = Book::where('stock', '>', 3)->count();
        $stockStatus = [
            'Stok Aman'   => $safeStockCount,
            'Stok Rendah' => $lowStockCount,
            'Stok Habis'  => $outOfStockCount,
        ];

        // ── Role Distribusi User ────────────────────────────────────
        $userRoles = User::selectRaw('role, COUNT(*) as cnt')
            ->groupBy('role')
            ->pluck('cnt', 'role');

        return view('admin.statistik', compact(
            'totalBooks', 'totalStock', 'totalUsers', 'totalLoans',
            'activeLoans', 'overdueLoans', 'returnedLoans', 'totalAttendance',
            'lowStockCount', 'outOfStockCount',
            'loanTrend', 'attendanceTrend', 'userTrend',
            'topBooks', 'loanStatusData', 'categoryStats',
            'stockStatus', 'userRoles'
        ));
    }
}
