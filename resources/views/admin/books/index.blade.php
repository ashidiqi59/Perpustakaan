@extends('layouts.admin')

@section('title', 'Kelola Buku')
@section('subtitle', 'Kelola koleksi buku perpustakaan')

@section('header-actions')
    <a href="{{ route('admin.books.create') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-500 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-plus"></i>
        <span class="hidden sm:inline">Tambah Buku</span>
        <span class="sm:hidden">Tambah</span>
    </a>
@endsection

@section('content')
                    <!-- ALERT MESSAGES -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- SEARCH & FILTER -->
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                        <form action="{{ route('admin.books.index') }}" method="GET" id="searchForm" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cari Buku</label>
                                    <input type="text" name="search" value="{{ $search }}" placeholder="Judul, penulis, atau ISBN..." 
                                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="w-full sm:w-40">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Kategori</label>
                                    <select name="category" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Semua</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if($search || $category)
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.books.index') }}" class="px-3 py-1.5 bg-slate-500 text-white text-xs rounded-lg hover:bg-slate-600 transition-colors flex items-center">
                                        <i class="fas fa-times mr-1"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- BOOKS TABLE -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($books->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">No</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Cover</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">ISBN</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Judul</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 hidden md:table-cell">Penulis</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 hidden lg:table-cell">Kategori</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Stok</th>
                                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-600">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($books as $index => $book)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600">
                                                    {{ $books->firstItem() + $index }}
                                                </td>
                                                <td class="px-3 py-3">
                                                    <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" 
                                                        alt="{{ $book->title }}" 
                                                        class="w-8 h-10 sm:w-10 sm:h-14 object-cover rounded shadow-sm">
                                                </td>
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600">{{ $book->isbn }}</td>
                                                <td class="px-3 py-3">
                                                    <p class="font-medium text-slate-800 text-xs sm:text-sm">{{ $book->title }}</p>
                                                    <p class="text-xs text-slate-500 hidden sm:block">{{ $book->publisher }}</p>
                                                </td>
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600 hidden md:table-cell">{{ $book->author ?: '-' }}</td>
                                                <td class="px-3 py-3 hidden lg:table-cell">
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                                        {{ $book->category ?: 'Umum' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-3">
                                                    <span class="px-2 py-1 {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs rounded-full">
                                                        {{ $book->stock }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-3">
                                                    <div class="flex items-center justify-center gap-1">
                                                        <a href="{{ route('admin.books.show', $book->id) }}" 
                                                            class="p-1.5 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                            title="Detail">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('admin.books.edit', $book->id) }}" 
                                                            class="p-1.5 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded transition-colors"
                                                            title="Edit">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>
                                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                class="p-1.5 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                                title="Hapus"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                                <i class="fas fa-trash text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- PAGINATION -->
                            <div class="px-3 py-4 border-t border-slate-200 overflow-x-auto">
                                {{ $books->appends(['search' => $search, 'category' => $category])->links() }}
                            </div>
                        @else
                            <div class="p-6 sm:p-8 text-center">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book text-slate-400 text-xl sm:text-2xl"></i>
                                </div>
                                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-2">Tidak ada buku</h3>
                                <p class="text-sm text-slate-500 mb-4">Belum ada buku yang ditambahkan atau sesuai dengan pencarian.</p>
                                <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center gap-2 text-sm">
                                    <i class="fas fa-plus"></i>
                                    Tambah Buku Pertama
                                </a>
                            </div>
                        @endif
                    </div>
@endsection

@push('scripts')
<script>
    // Auto-submit search on input with debounce
    let searchTimeout;
    document.querySelectorAll('select[name="category"]').forEach(function(select) {
        select.addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
    });
</script>
@endpush

