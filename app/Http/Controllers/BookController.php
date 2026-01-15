<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource (for admin).
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $category = $request->category ?? '';

        $query = Book::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $books = $query->latest()->paginate(10);
        $categories = Book::select('category')->distinct()->pluck('category')->filter();

        return view('admin.books.index', compact('books', 'categories', 'search', 'category'));
    }

    /**
     * Display all books for visitors (public home page).
     */
    public function publicIndex(Request $request)
    {
        $search = $request->search ?? '';
        $category = $request->category ?? '';

        $query = Book::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $books = $query->latest()->paginate(12);
        $categories = Book::select('category')->distinct()->pluck('category')->filter();
        $popularBooks = Book::orderBy('stock', 'desc')->take(5)->get();

        // Get 3 random featured books with images for hero section
        $featuredBooks = Book::whereNotNull('image')->inRandomOrder()->take(3)->get();
        // If not enough books with images, fill with any books
        if ($featuredBooks->count() < 3) {
            $featuredBooks = Book::inRandomOrder()->take(3)->get();
        }

        return view('home', compact('books', 'categories', 'search', 'category', 'popularBooks', 'featuredBooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.form', [
            'book' => new Book(),
            'action' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|unique:books,isbn',
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shelf_number' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
            $data['image'] = 'images/books/' . $imageName;
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource (for admin).
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Display the specified resource for visitors (public).
     */
    public function publicShow(Book $book)
    {
        $userHasActiveLoan = null;

        if (Auth::check()) {
            $userHasActiveLoan = Loan::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->whereIn('status', ['peminjaman', 'terlambat'])
                ->exists();
        }

        return view('books.show', compact('book', 'userHasActiveLoan'));
    }

    /**
     * Display all books collection for visitors (public).
     */
    public function collection(Request $request)
    {
        $search = $request->search ?? '';
        $category = $request->category ?? '';

        $query = Book::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        $books = $query->latest()->paginate(12);
        $categories = Book::select('category')->distinct()->pluck('category')->filter();

        return view('books.collection', compact('books', 'categories', 'search', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin.books.form', [
            'book' => $book,
            'action' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'isbn' => 'required|unique:books,isbn,' . $book->id,
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shelf_number' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'language' => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image && file_exists(public_path($book->image))) {
                unlink(public_path($book->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
            $data['image'] = 'images/books/' . $imageName;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete image if exists
        if ($book->image && file_exists(public_path($book->image))) {
            unlink(public_path($book->image));
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}

