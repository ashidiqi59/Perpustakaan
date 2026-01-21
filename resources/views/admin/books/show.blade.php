@extends('layouts.admin')

@section('title', 'Detail Buku')
@section('subtitle', 'Informasi lengkap buku')

@section('header-actions')
    <a href="{{ route('admin.books.edit', $book->id) }}" class="px-4 py-2 bg-amber-500 text-slate-900 rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2">
        <i class="fas fa-edit"></i>
        Edit
    </a>
    <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
@endsection

@section('content')
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-3">
                            <!-- LEFT - BOOK COVER -->
                            <div class="bg-slate-100 p-8 flex items-center justify-center bg-white">
                                <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" 
                                    alt="{{ $book->title }}" 
                                    class="w-64 h-80 object-cover rounded-lg shadow-lg">
                            </div>

                            <!-- RIGHT - BOOK INFO -->
                            <div class="lg:col-span-2 p-8">
                                <!-- Title & Status -->
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h1 class="text-2xl font-bold text-slate-800 mb-2">{{ $book->title }}</h1>
                                        <p class="text-slate-500">ISBN: {{ $book->isbn }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="px-3 py-1 {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-sm font-medium">
                                            {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                            {{ $book->category ?: 'Umum' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Book Details Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-user text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Penulis</p>
                                                <p class="font-medium text-slate-800">{{ $book->author ?: 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-building text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Penerbit</p>
                                                <p class="font-medium text-slate-800">{{ $book->publisher ?: 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-language text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Bahasa</p>
                                                <p class="font-medium text-slate-800">{{ $book->language ?: 'Tidak ditentukan' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-layer-group text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Kategori</p>
                                                <p class="font-medium text-slate-800">{{ $book->category ?: 'Umum' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-map-marker-alt text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Nomor Rak</p>
                                                <p class="font-medium text-slate-800">{{ $book->shelf_number ?: 'Tidak ada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-calendar text-slate-500"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Tanggal Terbit</p>
                                                <p class="font-medium text-slate-800">{{ $book->published_date ? \Carbon\Carbon::parse($book->published_date)->format('d F Y') : 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Info -->
                                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 {{ $book->stock > 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                                <i class="fas fa-book text-lg {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500">Stok Tersedia</p>
                                                <p class="text-2xl font-bold text-slate-800">{{ $book->stock }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-slate-500">Total Buku</p>
                                            <p class="text-2xl font-bold text-slate-800">{{ $book->stock }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($book->description)
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 mb-3">Deskripsi</h3>
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <p class="text-slate-600 leading-relaxed">{{ $book->description }}</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Meta Info -->
                                <div class="mt-6 pt-6 border-t border-slate-200">
                                    <div class="flex items-center justify-between text-sm text-slate-500">
                                        <div class="flex items-center gap-4">
                                            @if($book->created_at)
                                                <span>
                                                    <i class="fas fa-plus-circle mr-1"></i>
                                                    Dibuat: {{ $book->created_at->format('d/m/Y H:i') }}
                                                </span>
                                            @endif
                                            @if($book->updated_at && $book->updated_at != $book->created_at)
                                                <span>
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Diperbarui: {{ $book->updated_at->format('d/m/Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-3">
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors flex items-center gap-2"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash"></i>
                                Hapus Buku
                            </button>
                        </form>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="px-4 py-2 bg-amber-500 text-slate-900 rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            Edit Buku
                        </a>
                        <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-list"></i>
                            Lihat Semua
                        </a>
                    </div>
@endsection

