<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with real-time data.
     */
    public function index()
    {
        // Get counts for stat cards
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $activeLoans = Loan::where('status', Loan::STATUS_PEMINJAMAN)->count();
        $overdueLoans = Loan::where('status', Loan::STATUS_TERLAMBAT)->count();

        // Get recent loans (latest 5)
        $recentLoans = Loan::with(['user', 'book'])
            ->orderBy('loan_date', 'desc')
            ->take(5)
            ->get();

        // Get overdue loans (5 loans) - yang berstatus terlambat
        $overdueLoansList = Loan::with(['user', 'book'])
            ->where('status', Loan::STATUS_TERLAMBAT)
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Get currently borrowed books (5 loans) - yang berstatus peminjaman
        $borrowedBooks = Loan::with(['user', 'book'])
            ->where('status', Loan::STATUS_PEMINJAMAN)
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        // Get returned/completed loans (5 loans)
        $returnedBooks = Loan::with(['user', 'book'])
            ->where('status', Loan::STATUS_DIKEMBALIKAN)
            ->orderBy('return_date', 'desc')
            ->take(5)
            ->get();

        return view('admin', compact(
            'totalBooks',
            'totalUsers',
            'activeLoans',
            'overdueLoans',
            'recentLoans',
            'overdueLoansList',
            'borrowedBooks',
            'returnedBooks'
        ));
    }
}

