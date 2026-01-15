<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Kelola Buku</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 font-sans">
        <div class="flex h-screen">
            @include('components.sidebar')

            <!-- MAIN CONTENT -->
            <main class="flex-1 flex flex-col overflow-hidden">
                <!-- TOP BAR -->
                <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">Kelola Buku</h2>
                        <p class="text-sm text-slate-500">Kelola koleksi buku perpustakaan</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Tambah Buku
                        </a>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- ALERT MESSAGES -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- SEARCH & FILTER -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <form action="{{ route('admin.books.index') }}" method="GET" id="searchForm" class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Cari Buku</label>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Judul, penulis, atau ISBN..." 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 auto-search">
                            </div>
                            <div class="w-48">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Kategori</label>
                                <select name="category" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 auto-search">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                @if($search || $category)
                                    <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors flex items-center">
                                        <i class="fas fa-times mr-1"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- BOOKS TABLE -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($books->count() > 0)
                            <table class="w-full">
                                <thead class="bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">No</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Cover</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">ISBN</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Judul</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Penulis</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Kategori</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Stok</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($books as $index => $book)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                {{ $books->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" 
                                                    alt="{{ $book->title }}" 
                                                    class="w-12 h-16 object-cover rounded shadow-sm">
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">{{ $book->isbn }}</td>
                                            <td class="px-6 py-4">
                                                <p class="font-medium text-slate-800">{{ $book->title }}</p>
                                                <p class="text-xs text-slate-500">{{ $book->publisher }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">{{ $book->author ?: '-' }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                                    {{ $book->category ?: 'Umum' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs rounded-full">
                                                    {{ $book->stock }} buku
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.books.show', $book->id) }}" 
                                                        class="p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.books.edit', $book->id) }}" 
                                                        class="p-2 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                            class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- PAGINATION -->
                            <div class="px-6 py-4 border-t border-slate-200">
                                {{ $books->appends(['search' => $search, 'category' => $category])->links() }}
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-book text-slate-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">Tidak ada buku</h3>
                                <p class="text-slate-500 mb-4">Belum ada buku yang ditambahkan atau sesuai dengan pencarian.</p>
                                <a href="{{ route('admin.books.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center gap-2">
                                    <i class="fas fa-plus"></i>
                                    Tambah Buku Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    <script>
        // Auto-submit search on input with debounce
        let searchTimeout;
        document.querySelectorAll('.auto-search').forEach(function(input) {
            input.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    document.getElementById('searchForm').submit();
                }, 400);
            });
        });
    </script>
    </body>
</html>

