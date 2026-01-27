@extends('layouts.admin')

@section('title', 'Detail Buku')
@section('subtitle', 'Informasi lengkap buku')

@section('header-actions')
    <a href="{{ route('admin.books.edit', $book->id) }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-amber-500 text-slate-900 text-xs sm:text-sm rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-edit"></i>
        <span class="hidden sm:inline">Edit</span>
    </a>
    <a href="{{ route('admin.books.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Mobile: Stacked, Desktop: Side by side -->
                        <div class="grid grid-cols-1 lg:grid-cols-3">
                            <!-- LEFT - BOOK COVER -->
                            <div class="bg-slate-100 p-4 sm:p-8 flex items-center justify-center bg-white lg:order-1">
                                <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" 
                                    alt="{{ $book->title }}" 
                                    class="w-40 h-52 sm:w-48 sm:h-64 lg:w-56 lg:h-72 object-cover rounded-lg shadow-lg">
                            </div>

                            <!-- RIGHT - BOOK INFO -->
                            <div class="lg:col-span-2 p-4 sm:p-6 lg:p-8 lg:order-2">
                                <!-- Title & Status -->
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4 sm:mb-6">
                                    <div class="min-w-0">
                                        <h1 class="text-lg sm:text-2xl font-bold text-slate-800 mb-1">{{ $book->title }}</h1>
                                        <p class="text-sm text-slate-500">ISBN: {{ $book->isbn }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2 shrink-0">
                                        <span class="px-2 py-1 {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-xs sm:text-sm font-medium">
                                            {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-medium">
                                            {{ $book->category ?: 'Umum' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Book Details Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 sm:mb-6">
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-user text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Penulis</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $book->author ?: 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-building text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Penerbit</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $book->publisher ?: 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-language text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Bahasa</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base">{{ $book->language ?: 'Tidak ditentukan' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-layer-group text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Kategori</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base">{{ $book->category ?: 'Umum' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-map-marker-alt text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Nomor Rak</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base">{{ $book->shelf_number ?: 'Tidak ada' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                                <i class="fas fa-calendar text-slate-500 text-sm sm:text-base"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs sm:text-sm text-slate-500">Tanggal Terbit</p>
                                                <p class="font-medium text-slate-800 text-sm sm:text-base">{{ $book->published_date ? \Carbon\Carbon::parse($book->published_date)->format('d F Y') : 'Tidak diketahui' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Info -->
                                <div class="bg-slate-50 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 {{ $book->stock > 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center shrink-0">
                                                <i class="fas fa-book text-lg {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs sm:text-sm text-slate-500">Stok Tersedia</p>
                                                <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $book->stock }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <p class="text-xs sm:text-sm text-slate-500">Total Buku</p>
                                            <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $book->stock }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                @if($book->description)
                                <div class="mb-4 sm:mb-6">
                                    <h3 class="text-sm sm:text-lg font-semibold text-slate-800 mb-2 sm:mb-3">Deskripsi</h3>
                                    <div class="bg-slate-50 p-3 sm:p-4 rounded-lg">
                                        <p class="text-slate-600 leading-relaxed text-sm">{{ $book->description }}</p>
                                    </div>
                                </div>
                                @endif

                                <!-- Meta Info -->
                                <div class="pt-4 sm:pt-6 border-t border-slate-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs sm:text-sm text-slate-500 gap-2">
                                        <div class="flex flex-wrap items-center gap-2 sm:gap-4">
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
                    <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3">
                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="px-3 py-2 sm:px-4 sm:py-2 bg-red-500 text-white text-xs sm:text-sm rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center gap-1 sm:gap-2"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash"></i>
                                <span class="hidden sm:inline">Hapus Buku</span>
                            </button>
                        </form>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-amber-500 text-slate-900 text-xs sm:text-sm rounded-lg hover:bg-amber-600 transition-colors flex items-center justify-center gap-1 sm:gap-2">
                            <i class="fas fa-edit"></i>
                            <span class="hidden sm:inline">Edit Buku</span>
                        </a>
                        <a href="{{ route('admin.books.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center justify-center gap-1 sm:gap-2">
                            <i class="fas fa-list"></i>
                            <span class="hidden sm:inline">Lihat Semua</span>
                        </a>
                    </div>
@endsection

