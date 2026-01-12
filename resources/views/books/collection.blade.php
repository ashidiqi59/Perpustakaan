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
    @include('components.navbar')

    <!-- Breadcrumb -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-library-primary">Beranda</a>
                <svg class="w-5 h-5 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-gray-800">Koleksi Buku</span>
            </nav>
        </div>
    </div>

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
        <div class="bg-white rounded-xl shadow-lg p-6 fade-in-up">
            <form action="{{ route('books.collection') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Cari Buku</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Judul, penulis, ISBN..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                    <select name="category" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-48">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                @if($search || $category)
                    <a href="{{ route('books.collection') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2 font-semibold">
                        <i class="fas fa-times"></i>
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    <!-- Books Grid Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results Info -->
            <div class="flex items-center justify-between mb-8 fade-in-up">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Semua Buku</h2>
                    <p class="text-gray-600">Menampilkan {{ $books->count() }} dari {{ $books->total() }} buku</p>
                </div>
                <div class="text-sm text-gray-500">
                    Halaman {{ $books->currentPage() }} dari {{ $books->lastPage() }}
                </div>
            </div>
            
            @if($books->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($books as $index => $book)
                    <a href="{{ route('books.show', $book->id) }}" class="fade-in-up delay-{{ ($index + 1) * 50 }} book-card block group">
                        <div class="bg-white rounded-lg overflow-hidden shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:-translate-y-1">
                            <div class="relative">
                                <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="status-badge {{ $book->stock > 0 ? 'status-available' : 'status-borrowed' }}">{{ $book->stock > 0 ? 'Tersedia' : 'Dipinjam' }}</span>
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
                                    <span class="text-xs text-library-primary font-semibold">{{ $book->stock }} tersedia</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 flex justify-center fade-in-up">
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
                        <a href="{{ route('books.collection') }}" class="inline-block mt-4 px-6 py-2 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Lihat Semua Buku
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @include('components.footer')
</body>
</html>


