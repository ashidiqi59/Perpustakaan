<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the loans for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Loan::with('user', 'book')->orderBy('loan_date', 'desc');

        // Filter by search (nama atau NPM user)
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('npm', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Update status for overdue loans - menggunakan UPDATE query langsung agar lebih efisien
        Loan::where('status', Loan::STATUS_PEMINJAMAN)
            ->where('due_date', '<', now()->toDateString())
            ->whereNull('return_date')
            ->update(['status' => Loan::STATUS_TERLAMBAT]);

        $loans = $query->paginate(10);

        return view('admin.loans.index', compact('loans'));
    }

    /**
     * Display user's loans
     */
    public function myLoans()
    {
        // Update status for overdue loans - menggunakan UPDATE query langsung agar lebih efisien
        Loan::where('user_id', Auth::id())
            ->where('status', Loan::STATUS_PEMINJAMAN)
            ->where('due_date', '<', now()->toDateString())
            ->whereNull('return_date')
            ->update(['status' => Loan::STATUS_TERLAMBAT]);

        $user = Auth::user();
        $loans = Loan::where('user_id', $user->id)
            ->with('book')
            ->orderBy('loan_date', 'desc')
            ->paginate(10);

        return view('my-loans', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function adminCreate()
    {
        $users = User::where('role', 'pengunjung')->get();
        $books = Book::where('stock', '>', 0)->get();

        return view('admin.loans.create', compact('users', 'books'));
    }

    /**
     * Store a newly created loan in database.
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'notes' => 'nullable|string',
        ]);

        // Check if book stock is available
        $book = Book::find($validated['book_id']);
        if ($book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia']);
        }

        // Create the loan
        Loan::create($validated);

        // Reduce book stock
        $book->decrement('stock');

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    /**
     * User borrow a book
     */
    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today',
        ]);

        // Check if book stock is available
        $book = Book::find($validated['book_id']);
        if ($book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Maaf, stok buku tidak tersedia']);
        }

        // Check if user already has this book borrowed
        $existingLoan = Loan::where('user_id', Auth::id())
            ->where('book_id', $validated['book_id'])
            ->whereIn('status', ['peminjaman', 'terlambat'])
            ->first();

        if ($existingLoan) {
            return back()->withErrors(['book_id' => 'Anda sudah meminjam buku ini']);
        }

        // Create the loan
        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
            'loan_date' => now()->toDateString(),
            'due_date' => $validated['due_date'],
            'status' => Loan::STATUS_PEMINJAMAN,
        ]);

        // Reduce book stock
        $book->decrement('stock');

        return redirect()->route('my-loans')
            ->with('success', 'Peminjaman berhasil! Silakan ambil buku di perpustakaan.');
    }

    /**
     * Display the specified loan.
     */
    public function adminShow(Loan $loan)
    {
        $loan->load('user', 'book');
        return view('admin.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function adminEdit(Loan $loan)
    {
        $loan->load('user', 'book');
        $users = User::where('role', 'pengunjung')->get();
        $books = Book::get();

        return view('admin.loans.edit', compact('loan', 'users', 'books'));
    }

    /**
     * Update the specified loan in database.
     */
    public function adminUpdate(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'notes' => 'nullable|string',
        ]);

        $oldBook = $loan->book_id;
        $oldStatus = $loan->status;

        // Determine status based on return_date and due_date
        $status = $loan->status; // keep existing status by default
        if ($validated['return_date']) {
            // If return_date is set, compare with due_date
            $returnDate = \Carbon\Carbon::parse($validated['return_date']);
            $dueDate = \Carbon\Carbon::parse($validated['due_date']);
            $status = $returnDate->isAfter($dueDate) ? Loan::STATUS_TERLAMBAT : Loan::STATUS_DIKEMBALIKAN;
        } else {
            // If return_date is null, check if overdue
            $dueDate = \Carbon\Carbon::parse($validated['due_date']);
            if ($dueDate->isBefore(now())) {
                $status = Loan::STATUS_TERLAMBAT;
            } else {
                $status = Loan::STATUS_PEMINJAMAN;
            }
        }

        $validated['status'] = $status;
        $loan->update($validated);

        // Handle stock if book changed
        if ($loan->book_id !== $oldBook) {
            $oldBookObj = Book::find($oldBook);
            $newBookObj = $loan->book;

            $oldBookObj->increment('stock');
            $newBookObj->decrement('stock');
        }

        // Increment stock if returned (was not returned before)
        if (in_array($oldStatus, [Loan::STATUS_PEMINJAMAN, Loan::STATUS_TERLAMBAT]) && 
            in_array($status, [Loan::STATUS_DIKEMBALIKAN, Loan::STATUS_TERLAMBAT])) {
            $loan->book->increment('stock');
        }

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil diperbarui');
    }

    /**
     * Remove the specified loan from database.
     */
    public function adminDestroy(Loan $loan)
    {
        // Restore stock if loan was not returned
        if ($loan->status !== Loan::STATUS_DIKEMBALIKAN) {
            $loan->book->increment('stock');
        }

        $loan->delete();

        return redirect()->route('admin.loans.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }

    /**
     * Mark a loan as returned
     */
    public function return(Loan $loan)
    {
        $returnDate = now()->toDateString();
        $dueDate = \Carbon\Carbon::parse($loan->due_date)->toDateString();
        
        // Determine status: terlambat if return date is after due date
        $status = $returnDate > $dueDate ? Loan::STATUS_TERLAMBAT : Loan::STATUS_DIKEMBALIKAN;

        $loan->update([
            'return_date' => $returnDate,
            'status' => $status,
        ]);

        // Restore book stock
        $loan->book->increment('stock');

        return redirect()->route('admin.loans.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }
}
