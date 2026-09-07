<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FeaturedBookController extends Controller
{
    /**
     * Tampilkan halaman kelola buku beranda.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', 'all'); // 'all', 'featured', 'not_featured'

        $query = Book::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('shelf_number', 'like', "%{$search}%");
            });
        }

        if ($status === 'featured') {
            $query->where('is_featured', true);
        } elseif ($status === 'not_featured') {
            $query->where('is_featured', false);
        }

        // Urutkan buku featured terlebih dahulu, lalu id
        $books = $query->orderByDesc('is_featured')
                       ->orderBy('id', 'asc')
                       ->get();

        $totalBooks = Book::count();
        $featuredCount = Book::where('is_featured', true)->count();
        $missingBackCoverCount = Book::where('is_featured', true)->whereNull('back_image')->count();

        return view('admin.featured-books.index', compact(
            'books',
            'search',
            'status',
            'totalBooks',
            'featuredCount',
            'missingBackCoverCount'
        ));
    }

    /**
     * Update status featured dan/atau upload cover belakang buku.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'is_featured' => 'nullable|boolean',
            'back_image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $willBeFeatured = $request->boolean('is_featured');
        $hasUploadedBackImage = $request->hasFile('back_image');
        $hasExistingBackImage = !empty($book->back_image) && file_exists(public_path($book->back_image));

        // Syarat wajib: Jika ingin menampilkan di beranda, harus ada cover belakang
        if ($willBeFeatured && !$hasUploadedBackImage && !$hasExistingBackImage) {
            return redirect()->back()
                ->with('error', "Gagal menampilkan \"{$book->title}\" di beranda: Foto cover belakang wajib diunggah terlebih dahulu!")
                ->with('open_modal_book_id', $book->id);
        }

        // Upload back image jika ada file baru
        if ($hasUploadedBackImage) {
            // Hapus gambar lama jika ada
            if ($book->back_image && file_exists(public_path($book->back_image))) {
                @unlink(public_path($book->back_image));
            }

            $file = $request->file('back_image');
            $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = 'back_' . time() . '_' . $safeName . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/books'), $filename);

            $book->back_image = 'images/books/' . $filename;
        }

        $book->is_featured = $willBeFeatured;
        $book->save();

        $statusMsg = $willBeFeatured ? 'ditampilkan di beranda' : 'dihapus dari tampilan beranda';
        return redirect()->back()->with('success', "Buku \"{$book->title}\" berhasil {$statusMsg}!");
    }

    /**
     * API JSON untuk buku yang tampil di beranda (rak 3D & hero section).
     */
    public function apiFeatured()
    {
        $books = Book::where('is_featured', true)
                     ->orderBy('id', 'asc')
                     ->get()
                     ->map(function ($book) {
                         return [
                             'id'             => $book->id,
                             'title'          => $book->title,
                             'author'         => $book->author,
                             'publisher'      => $book->publisher,
                             'isbn'           => $book->isbn,
                             'category'       => $book->category,
                             'shelf_number'   => $book->shelf_number,
                             'image'          => $book->image ? asset($book->image) : null,
                             'back_image'     => $book->back_image ? asset($book->back_image) : null,
                             'description'    => $book->description,
                             'published_date' => $book->published_date ? (is_string($book->published_date) ? $book->published_date : $book->published_date->format('Y-m-d')) : null,
                         ];
                     });

        return response()->json([
            'status' => 'success',
            'count'  => $books->count(),
            'data'   => $books,
        ]);
    }
}
