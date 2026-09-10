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
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-4 sm:p-5 mb-6">
                        <form action="{{ route('admin.books.index') }}" method="GET" id="searchForm" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3 items-end">
                                <div class="flex-1 w-full">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cari Buku</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i id="search-icon" class="fas fa-search text-sm"></i>
                                        </div>
                                        <input type="text" id="admin-books-search" name="search" value="{{ $search }}" autocomplete="off" placeholder="Ketik judul, penulis, atau ISBN untuk langsung mencari..." 
                                            class="w-full h-10 pl-9 pr-8 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/30">
                                        <button type="button" id="clear-search-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 {{ $search ? '' : 'hidden' }}" title="Hapus pencarian">
                                            <i class="fas fa-times-circle text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="w-full sm:w-64">
                                    <label for="admin-books-category" class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Kategori</label>
                                    <div class="relative">
                                        <select id="admin-books-category" name="category" class="w-full h-10 appearance-none pl-3.5 pr-8 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white cursor-pointer transition-all">
                                            <option value="">Semua Kategori</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 flex items-center">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </span>
                                    </div>
                                </div>
                                <div id="reset-btn-container" class="{{ ($search || $category) ? '' : 'hidden' }} flex items-center gap-2 w-full sm:w-auto">
                                    <button type="button" id="reset-filter-btn" class="w-full sm:w-auto h-10 px-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5" title="Reset filter">
                                        <i class="fas fa-undo text-xs"></i>
                                        <span>Reset</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- BOOKS TABLE -->
                    <div id="books-table-wrapper" class="bg-white rounded-xl shadow-sm overflow-hidden">
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
                            <div class="px-4 py-3.5 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <div class="text-xs text-slate-500">
                                    Menampilkan <strong>{{ $books->firstItem() }}</strong> - <strong>{{ $books->lastItem() }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                                </div>
                                @if($books->hasPages())
                                    <div class="overflow-x-auto">
                                        {{ $books->appends(['search' => $search, 'category' => $category])->links() }}
                                    </div>
                                @endif
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
    (function() {
        var searchInput = document.getElementById('admin-books-search');
        var categorySelect = document.getElementById('admin-books-category');
        var clearBtn = document.getElementById('clear-search-btn');
        var resetContainer = document.getElementById('reset-btn-container');
        var resetBtn = document.getElementById('reset-filter-btn');
        var searchIcon = document.getElementById('search-icon');
        var tableWrapper = document.getElementById('books-table-wrapper');
        var form = document.getElementById('searchForm');

        var debounceTimer = null;
        var activeController = null;

        function updateResetVisibility() {
            var hasFilter = (searchInput && searchInput.value.trim().length > 0) || (categorySelect && categorySelect.value !== '');
            if (resetContainer) {
                if (hasFilter) resetContainer.classList.remove('hidden');
                else resetContainer.classList.add('hidden');
            }
            if (clearBtn && searchInput) {
                if (searchInput.value.trim().length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            }
        }

        function performSearch(pageUrl) {
            updateResetVisibility();

            if (searchIcon) searchIcon.className = 'fas fa-circle-notch fa-spin text-blue-500 text-sm';
            if (tableWrapper) {
                tableWrapper.style.transition = 'opacity 0.2s ease';
                tableWrapper.style.opacity = '0.5';
            }

            if (activeController) activeController.abort();
            activeController = new AbortController();

            var url;
            if (pageUrl) {
                url = new URL(pageUrl, window.location.origin);
            } else {
                url = new URL('{{ route('admin.books.index') }}', window.location.origin);
                var q = searchInput ? searchInput.value.trim() : '';
                var cat = categorySelect ? categorySelect.value : '';
                if (q) url.searchParams.set('search', q);
                if (cat) url.searchParams.set('category', cat);
            }

            fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: activeController.signal
            })
            .then(function(res) { return res.text(); })
            .then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var newWrapper = doc.getElementById('books-table-wrapper');
                if (newWrapper && tableWrapper) {
                    tableWrapper.innerHTML = newWrapper.innerHTML;
                    bindPaginationLinks();
                }
                window.history.replaceState({}, '', url.toString());
            })
            .catch(function(err) {
                if (err.name !== 'AbortError') console.error(err);
            })
            .finally(function() {
                if (searchIcon) searchIcon.className = 'fas fa-search text-sm';
                if (tableWrapper) tableWrapper.style.opacity = '1';
            });
        }

        function bindPaginationLinks() {
            if (!tableWrapper) return;
            var links = tableWrapper.querySelectorAll('nav a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var href = this.getAttribute('href');
                    if (href && href !== '#') {
                        performSearch(href);
                    }
                });
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(performSearch, 300);
            });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    performSearch();
                }
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    clearBtn.classList.add('hidden');
                    searchInput.focus();
                }
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (categorySelect) categorySelect.value = '';
                if (clearBtn) clearBtn.classList.add('hidden');
                if (resetContainer) resetContainer.classList.add('hidden');
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        bindPaginationLinks();
    })();
</script>
@endpush

