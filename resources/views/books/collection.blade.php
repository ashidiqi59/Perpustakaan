<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku | Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #F9FAFB;
            color: #1F2937;
        }
        
        .library-primary {
            color: #2563EB;
        }
        
        .bg-library-primary {
            background-color: #2563EB;
        }
        
        .bg-library-light {
            background-color: #EFF6FF;
        }
        
        .border-library {
            border-color: #2563EB;
        }
        
        .fade-in-up { 
            animation: fadeInUp 0.6s ease-out; 
        }
        
        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        /* Book card hover effect */
        .book-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Status badge */
        .status-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }
        
        .status-available {
            background-color: #D1FAE5;
            color: #059669;
        }
        
        .status-borrowed {
            background-color: #FEE2E2;
            color: #DC2626;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    <x-page-loader />
    @include('components.navbar')

    <!-- Sub-Navbar / Breadcrumb -->
    @include('components.sub-navbar', ['title' => 'Koleksi Buku'])

    <!-- Collection Header -->
    <section class="bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in-up">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Koleksi Buku</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi koleksi lengkap buku perpustakaan kami. Temukan buku yang Anda butuhkan untuk mendukung pembelajaran dan penelitian.</p>
            </div>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 fade-in-up">
            <form id="collection-search-form" action="{{ route('books.collection') }}" method="GET" class="flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-end">
                <div class="w-full md:flex-1 min-w-0">
                    <label for="search-input" class="block text-sm font-medium text-gray-700 mb-1.5">Cari Buku</label>
                    <div class="relative">
                        <input type="text" id="search-input" name="search" value="{{ $search }}" autocomplete="off" placeholder="Ketik judul, penulis, ISBN untuk langsung mencari..." 
                            class="w-full h-12 pl-11 pr-10 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base text-gray-800 placeholder:text-gray-400 bg-white transition-all shadow-xs">
                        <span class="absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none flex items-center">
                            <i id="search-icon" class="fas fa-search text-base"></i>
                        </span>
                        <button type="button" id="clear-search-btn" class="absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 {{ $search ? '' : 'hidden' }}" title="Hapus pencarian">
                            <i class="fas fa-times-circle text-base"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full md:w-80 lg:w-96">
                    <label for="category-select" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                    <div class="relative">
                        <select id="category-select" name="category" class="w-full h-12 appearance-none pl-4 pr-10 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base font-medium text-gray-800 bg-white cursor-pointer transition-all shadow-xs">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <span class="absolute right-3.5 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none flex items-center">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>
                <div id="reset-filter-container" class="{{ ($search || $category) ? '' : 'hidden' }} w-full md:w-auto">
                    <button type="button" id="reset-all-btn" class="w-full md:w-auto h-12 px-5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors flex items-center justify-center gap-2 font-medium text-sm" title="Reset filter pencarian">
                        <i class="fas fa-times text-xs"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Books Grid Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="collection-results-wrapper">
                <!-- Results Info -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 fade-in-up gap-2">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Semua Buku</h2>
                        <p class="text-gray-600 text-sm">Menampilkan {{ $books->count() }} dari {{ $books->total() }} buku</p>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-500">
                        Halaman {{ $books->currentPage() }} dari {{ $books->lastPage() }}
                    </div>
                </div>
                
                @if($books->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-6">
                        @foreach($books as $index => $book)
                        <a href="{{ route('books.show', $book->id) }}" class="fade-in-up delay-{{ ($index + 1) * 50 }} book-card block group">
                            <div class="bg-white rounded-lg overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                                <div class="relative">
                                    <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                                    <div class="absolute top-2 right-2">
                                        <span class="status-badge {{ $book->stock > 0 ? 'status-available' : 'status-borrowed' }}">{{ $book->stock > 0 ? 'Tersedia' : 'Stok Habis' }}</span>
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            <span class="bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-1 text-sm line-clamp-2 group-hover:text-library-primary transition-colors">{{ $book->title }}</h3>
                                    <p class="text-xs text-gray-500 mb-2">{{ $book->author ?: 'Penulis Tidak Diketahui' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-400">ISBN: {{ $book->isbn }}</span>
                                        <span class="text-xs font-semibold {{ $book->stock > 0 ? 'text-library-primary' : 'text-red-600' }}">{{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Stok Habis' }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12 w-full fade-in-up">
                        {{ $books->appends(['search' => $search, 'category' => $category])->links() }}
                    </div>
                @else
                    <div class="text-center py-16 fade-in-up">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada buku</h3>
                        <p class="text-gray-500">Tidak ada buku yang sesuai dengan pencarian Anda.</p>
                        @if($search || $category)
                            <button type="button" onclick="document.getElementById('reset-all-btn')?.click()" class="inline-block mt-4 px-6 py-2 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Lihat Semua Buku
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('components.footer')

    <script>
        (function() {
            var searchInput = document.getElementById('search-input');
            var categorySelect = document.getElementById('category-select');
            var clearBtn = document.getElementById('clear-search-btn');
            var resetContainer = document.getElementById('reset-filter-container');
            var resetBtn = document.getElementById('reset-all-btn');
            var searchIcon = document.getElementById('search-icon');
            var resultsWrapper = document.getElementById('collection-results-wrapper');
            var searchForm = document.getElementById('collection-search-form');

            var debounceTimer = null;
            var activeController = null;

            function getTargetPerPage() {
                var width = window.innerWidth;
                if (width < 768) return 8;
                if (width < 1024) return 16;
                return 15;
            }

            function updateResetButtonVisibility() {
                var hasFilter = (searchInput && searchInput.value.trim().length > 0) || (categorySelect && categorySelect.value !== '');
                if (resetContainer) {
                    if (hasFilter) {
                        resetContainer.classList.remove('hidden');
                    } else {
                        resetContainer.classList.add('hidden');
                    }
                }
                if (clearBtn && searchInput) {
                    if (searchInput.value.trim().length > 0) {
                        clearBtn.classList.remove('hidden');
                    } else {
                        clearBtn.classList.add('hidden');
                    }
                }
            }

            function performSearch(pageUrl) {
                updateResetButtonVisibility();

                if (searchIcon) {
                    searchIcon.className = 'fas fa-circle-notch fa-spin text-blue-500';
                }
                if (resultsWrapper) {
                    resultsWrapper.style.transition = 'opacity 0.2s ease';
                    resultsWrapper.style.opacity = '0.5';
                }

                if (activeController) {
                    activeController.abort();
                }
                activeController = new AbortController();

                var url;
                if (pageUrl) {
                    url = new URL(pageUrl, window.location.origin);
                } else {
                    url = new URL('{{ route('books.collection') }}', window.location.origin);
                    var q = searchInput ? searchInput.value.trim() : '';
                    var cat = categorySelect ? categorySelect.value : '';
                    if (q) url.searchParams.set('search', q);
                    if (cat) url.searchParams.set('category', cat);
                }

                var targetPerPage = getTargetPerPage();
                if (!url.searchParams.has('per_page')) {
                    url.searchParams.set('per_page', targetPerPage);
                }

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: activeController.signal
                })
                .then(function(res) {
                    return res.text();
                })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    var newResults = doc.getElementById('collection-results-wrapper');
                    if (newResults && resultsWrapper) {
                        resultsWrapper.innerHTML = newResults.innerHTML;
                        bindPaginationLinks();
                    }
                    window.history.replaceState({}, '', url.toString());
                })
                .catch(function(err) {
                    if (err.name !== 'AbortError') {
                        console.error('Search error:', err);
                    }
                })
                .finally(function() {
                    if (searchIcon) {
                        searchIcon.className = 'fas fa-search';
                    }
                    if (resultsWrapper) {
                        resultsWrapper.style.opacity = '1';
                    }
                });
            }

            function bindPaginationLinks() {
                if (!resultsWrapper) return;
                var links = resultsWrapper.querySelectorAll('nav a');
                links.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        var href = this.getAttribute('href');
                        if (href && href !== '#') {
                            performSearch(href);
                            resultsWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        performSearch();
                    }, 300);
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

            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    performSearch();
                });
            }

            // Bind initial pagination links
            bindPaginationLinks();

            // Device per page responsive sync
            (function() {
                var width = window.innerWidth;
                var target = 15;
                if (width < 768) {
                    target = 8;
                } else if (width < 1024) {
                    target = 16;
                }

                var current = {{ $books->perPage() }};
                var match = document.cookie.match(/(?:^|; )device_per_page=([^;]*)/);
                var cookieVal = match ? parseInt(match[1]) : null;

                if (cookieVal !== target) {
                    document.cookie = "device_per_page=" + target + "; path=/; max-age=604800; SameSite=Lax";
                }

                if (current !== target) {
                    var flagKey = 'synced_per_page_' + target;
                    if (!sessionStorage.getItem(flagKey)) {
                        sessionStorage.setItem(flagKey, '1');
                        [8, 15, 16].forEach(function(p) {
                            if (p !== target) sessionStorage.removeItem('synced_per_page_' + p);
                        });
                        window.location.reload();
                    }
                }
            })();
        })();
    </script>
</body>
</html>


