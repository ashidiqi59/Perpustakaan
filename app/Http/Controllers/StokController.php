<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    /**
     * Dashboard Petugas Stok Buku
     */
    public function dashboard()
    {
        $totalBooks      = Book::count();
        $totalStock      = Book::sum('stock');
        $lowStockBooks   = Book::where('stock', '<=', 3)->where('stock', '>', 0)->orderBy('stock')->get();
        $outOfStockBooks = Book::where('stock', 0)->get();
        $lowStockCount   = $lowStockBooks->count();
        $outOfStockCount = $outOfStockBooks->count();
        $recentBooks     = Book::latest()->limit(8)->get();
        $categories      = Book::select('category')->distinct()->pluck('category')->filter()->values();

        // Distribusi stok per kategori
        $categoryStats = Book::selectRaw('category, COUNT(*) as total_titles, SUM(stock) as total_stock')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderBy('total_stock', 'desc')
            ->get();

        return view('stok.dashboard', compact(
            'totalBooks',
            'totalStock',
            'lowStockBooks',
            'outOfStockBooks',
            'lowStockCount',
            'outOfStockCount',
            'recentBooks',
            'categories',
            'categoryStats'
        ));
    }

    /**
     * Daftar semua buku (dengan search & filter kategori)
     */
    public function index(Request $request)
    {
        $search   = $request->search ?? '';
        $category = $request->category ?? '';
        $filter   = $request->filter ?? ''; // 'low', 'out'

        $query = Book::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title',  'like', "%{$search}%")
                  ->orWhere('author',    'like', "%{$search}%")
                  ->orWhere('isbn',      'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($filter === 'low') {
            $query->where('stock', '<=', 3)->where('stock', '>', 0);
        } elseif ($filter === 'out') {
            $query->where('stock', 0);
        }

        $books      = $query->latest()->paginate(15)->withQueryString();
        $categories = Book::select('category')->distinct()->pluck('category')->filter()->values();

        $lowStockCount   = Book::where('stock', '<=', 3)->where('stock', '>', 0)->count();
        $outOfStockCount = Book::where('stock', 0)->count();

        return view('admin.books.index', compact(
            'books',
            'categories',
            'search',
            'category',
            'filter',
            'lowStockCount',
            'outOfStockCount'
        ) + ['routePrefix' => 'stok']);
    }

    /**
     * Form tambah buku baru
     */
    public function create()
    {
        $categories = Book::select('category')->distinct()->pluck('category')->filter()->values();
        return view('admin.books.form', [
            'book'        => new Book(),
            'action'      => 'create',
            'categories'  => $categories,
            'routePrefix' => 'stok',
        ]);
    }

    /**
     * Detail buku (show) — redirect ke edit untuk simplicity
     */
    public function show(Book $book)
    {
        $categories = Book::select('category')->distinct()->pluck('category')->filter()->values();
        return view('admin.books.form', [
            'book'        => $book,
            'action'      => 'edit',
            'categories'  => $categories,
            'routePrefix' => 'stok',
        ]);
    }

    /**
     * Simpan buku baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn'           => 'required|unique:books,isbn',
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'publisher'      => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'back_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'shelf_number'   => 'nullable|string|max:50',
            'category'       => 'nullable|string|max:100',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'language'       => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
            $data['image'] = 'images/books/' . $imageName;
        }

        if ($request->hasFile('back_image')) {
            $backImage     = $request->file('back_image');
            $backImageName = 'back_' . time() . '_' . $backImage->getClientOriginalName();
            $backImage->move(public_path('images/books'), $backImageName);
            $data['back_image'] = 'images/books/' . $backImageName;
        }

        Book::create($data);

        return redirect()->route('stok.books.index')
            ->with('success', 'Buku berhasil ditambahkan ke koleksi perpustakaan!');
    }

    /**
     * Form edit buku
     */
    public function edit(Book $book)
    {
        $categories = Book::select('category')->distinct()->pluck('category')->filter()->values();
        return view('admin.books.form', [
            'book'        => $book,
            'action'      => 'edit',
            'categories'  => $categories,
            'routePrefix' => 'stok',
        ]);
    }

    /**
     * Update data buku
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'isbn'           => 'required|unique:books,isbn,' . $book->id,
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'publisher'      => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'back_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'shelf_number'   => 'nullable|string|max:50',
            'category'       => 'nullable|string|max:100',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'language'       => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            if ($book->image && file_exists(public_path($book->image))) {
                @unlink(public_path($book->image));
            }
            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
            $data['image'] = 'images/books/' . $imageName;
        }

        if ($request->hasFile('back_image')) {
            if ($book->back_image && file_exists(public_path($book->back_image))) {
                @unlink(public_path($book->back_image));
            }
            $backImage     = $request->file('back_image');
            $backImageName = 'back_' . time() . '_' . $backImage->getClientOriginalName();
            $backImage->move(public_path('images/books'), $backImageName);
            $data['back_image'] = 'images/books/' . $backImageName;
        }

        $book->update($data);

        return redirect()->route('stok.books.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Hapus buku
     */
    public function destroy(Book $book)
    {
        // Cek apakah buku sedang dipinjam
        $activeLoans = Loan::where('book_id', $book->id)
            ->whereIn('status', ['peminjaman', 'menunggu_konfirmasi', 'menunggu_pengembalian', 'terlambat'])
            ->count();

        if ($activeLoans > 0) {
            return redirect()->route('stok.books.index')
                ->with('error', "Buku \"{$book->title}\" tidak dapat dihapus karena masih ada {$activeLoans} peminjaman aktif.");
        }

        if ($book->image && file_exists(public_path($book->image))) {
            @unlink(public_path($book->image));
        }
        if ($book->back_image && file_exists(public_path($book->back_image))) {
            @unlink(public_path($book->back_image));
        }

        $book->delete();

        return redirect()->route('stok.books.index')
            ->with('success', 'Buku berhasil dihapus dari koleksi.');
    }

    /**
     * Adjust stok buku (tambah atau kurangi) langsung dari daftar buku
     */
    public function adjustStock(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:increment,decrement,set',
            'amount' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $action = $request->action;
        $amount = (int) $request->amount;

        match ($action) {
            'increment' => $book->increment('stock', $amount),
            'decrement' => $book->update(['stock' => max(0, $book->stock - $amount)]),
            'set'       => $book->update(['stock' => $amount]),
        };

        $book->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Stok buku \"{$book->title}\" berhasil diperbarui menjadi {$book->stock}.",
                'stock'   => $book->stock,
            ]);
        }

        return back()->with('success', "Stok buku \"{$book->title}\" berhasil diperbarui menjadi {$book->stock}.");
    }
}
