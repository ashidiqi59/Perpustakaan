<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan | Beranda</title>
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

        /* Scroll Animation */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger animation delay */
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }
        .delay-500 { transition-delay: 0.5s; }

        /* Service card hover effect */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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

        /* Scroll indicator */
        .scroll-indicator {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        /* Icon background */
        .icon-bg {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== Koleksi Section ===== */

        /* Subtle dot-grid background */
        .koleksi-bg {
            background-color: #F4EFEA;
            background-image: radial-gradient(circle, rgba(160,135,100,0.14) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Shelf frame — thin, elegant border */
        .shelf-frame {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 20px rgba(100,75,40,0.10), 0 0 0 1px rgba(200,175,140,0.35);
        }

        /* Bottom info bar */
        .koleksi-info-bar {
            background: rgba(255,255,255,0.80);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(210,190,160,0.35);
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <x-page-loader />
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-50 via-white to-blue-50 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="fade-in-up">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        Selamat Datang di<br>
                        <span class="text-library-primary">Perpustakaan Digital</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Akses ribuan koleksi buku digital, jurnal, dan referensi akademik. Temukan pengetahuan yang Anda butuhkan untuk mendukung pembelajaran dan penelitian.
                    </p>

                    <!-- Search Bar -->
                    <form action="{{ route('books.collection') }}" method="GET" class="bg-white rounded-xl shadow-lg p-2 flex flex-col sm:flex-row gap-2 mb-6">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="Cari judul buku, penulis, atau ISBN..."
                            class="w-full sm:flex-1 px-4 py-3 border-0 focus:outline-none focus:ring-0 text-gray-700 text-sm sm:text-base"
                        >
                        <button type="submit" class="bg-library-primary text-white px-6 sm:px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </form>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-4">
                        <div class="bg-white rounded-lg p-2.5 sm:p-4 shadow-sm text-center">
                            <div class="text-lg sm:text-2xl font-bold text-library-primary">1,250+</div>
                            <div class="text-[11px] sm:text-xs text-gray-600 mt-1">Koleksi Buku</div>
                        </div>
                        <div class="bg-white rounded-lg p-2.5 sm:p-4 shadow-sm text-center">
                            <div class="text-lg sm:text-2xl font-bold text-library-primary">500+</div>
                            <div class="text-[11px] sm:text-xs text-gray-600 mt-1">Anggota Aktif</div>
                        </div>
                        <div class="bg-white rounded-lg p-2.5 sm:p-4 shadow-sm text-center">
                            <div class="text-lg sm:text-2xl font-bold text-library-primary">24/7</div>
                            <div class="text-[11px] sm:text-xs text-gray-600 mt-1">Akses Online</div>
                        </div>
                    </div>
                </div>

                <!-- Right - Featured Books Stack -->
                <div class="fade-in-up delay-200 flex justify-center max-w-full overflow-hidden sm:overflow-visible py-4">
                    <div class="relative h-[420px] sm:h-[500px] w-[280px] sm:w-[300px]">
                        @forelse($featuredBooks as $index => $book)
                            @php
                                $rotations = [-5, 2, -3];
                                $zIndexes = [30, 20, 10];
                                $topPositions = [0, 6, 12];
                                $leftPositions = [0, 12, 24];
                            @endphp
                            <div class="absolute w-64 h-80 rounded-lg shadow-2xl transform hover:rotate-0 transition-transform duration-300 group cursor-pointer"
                                style="top: {{ $topPositions[$index] }}px; left: {{ $leftPositions[$index] }}px; transform: rotate({{ $rotations[$index] }}deg); z-index: {{ $zIndexes[$index] }};">
                                <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg shadow-2xl">
                                <a href="{{ route('books.show', $book->id) }}" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 rounded-lg flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span class="bg-white text-gray-800 px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <!-- Fallback if no books available -->
                            <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 1" class="absolute top-0 left-0 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[-5deg] z-30 hover:rotate-0 transition-transform duration-300">
                            <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 2" class="absolute top-6 left-12 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[2deg] z-20 hover:rotate-0 transition-transform duration-300">
                            <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 3" class="absolute top-12 left-24 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[-3deg] z-10 hover:rotate-0 transition-transform duration-300">
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="flex justify-center mt-12 fade-in-up delay-400">
                <a href="#koleksi" class="scroll-indicator cursor-pointer">
                    <svg class="w-6 h-6 text-gray-400 hover:text-library-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 sm:py-20 relative overflow-hidden bg-gradient-to-b from-white via-slate-50/40 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14 fade-in-up">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Layanan Perpustakaan</h2>
                <p class="text-gray-500 text-sm sm:text-base mt-2.5 leading-relaxed">
                    Kami menyediakan berbagai kemudahan akses referensi akademik, sirkulasi koleksi, dan asistensi belajar untuk mendukung riset Anda.
                </p>
            </div>

            <!-- Services Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Service 1: Peminjaman Buku -->
                <div class="fade-in-up delay-100 group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-book-open-reader absolute -right-3 -bottom-3 text-7xl text-blue-50/60 group-hover:text-blue-100/70 group-hover:scale-110 transition-all pointer-events-none"></i>
                    
                    <div class="relative">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-xl shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300 mb-5">
                            <i class="fas fa-book-open-reader"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 mb-2.5">
                            Fisik & Digital
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Peminjaman Buku</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                            Pinjam koleksi buku fisik di konter atau baca ribuan e-book akademik langsung dari perangkat Anda.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-5 relative flex items-center justify-between">
                        <a href="{{ route('books.collection') }}" class="text-xs font-semibold text-blue-600 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                            <span>Mulai Pinjam</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </div>

                <!-- Service 2: Reservasi Buku -->
                <div class="fade-in-up delay-200 group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-purple-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-bookmark absolute -right-3 -bottom-3 text-7xl text-purple-50/60 group-hover:text-purple-100/70 group-hover:scale-110 transition-all pointer-events-none"></i>
                    
                    <div class="relative">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 text-white flex items-center justify-center text-xl shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300 mb-5">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-100 mb-2.5">
                            Antrean Cerdas
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Reservasi Buku</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                            Buku favorit sedang dipinjam? Kunci antrean Anda dan dapatkan notifikasi begitu buku siap diambil.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-5 relative flex items-center justify-between">
                        <a href="{{ route('books.collection') }}" class="text-xs font-semibold text-purple-600 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                            <span>Reservasi Sekarang</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="w-6 h-6 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </div>

                <!-- Service 3: Pengembalian Mandiri -->
                <div class="fade-in-up delay-300 group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-rotate-left absolute -right-3 -bottom-3 text-7xl text-emerald-50/60 group-hover:text-emerald-100/70 group-hover:scale-110 transition-all pointer-events-none"></i>
                    
                    <div class="relative">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300 mb-5">
                            <i class="fas fa-rotate-left"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 mb-2.5">
                            Drop-Box & Loket
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors">Pengembalian</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                            Proses pengembalian tanpa antre lama dengan pemindaian barcode otomatis di konter sirkulasi.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-5 relative flex items-center justify-between">
                        @auth
                            <a href="{{ route('my-loans') }}" class="text-xs font-semibold text-emerald-600 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Cek Pinjaman</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-emerald-600 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Masuk Akun</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        @endauth
                        <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </div>

                <!-- Service 4: Pencarian Katalog -->
                <div class="fade-in-up delay-400 group relative bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-amber-200 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-magnifying-glass absolute -right-3 -bottom-3 text-7xl text-amber-50/60 group-hover:text-amber-100/70 group-hover:scale-110 transition-all pointer-events-none"></i>
                    
                    <div class="relative">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform duration-300 mb-5">
                            <i class="fas fa-magnifying-glass"></i>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100 mb-2.5">
                            Katalog Cerdas
                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-amber-600 transition-colors">Pencarian Katalog</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                            Eksplorasi ribuan judul buku, skripsi, dan jurnal ilmiah dengan filter kategori dan kata kunci akurat.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-5 relative flex items-center justify-between">
                        <a href="{{ route('books.collection') }}" class="text-xs font-semibold text-amber-600 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                            <span>Jelajahi Koleksi</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="w-6 h-6 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- All Books / 3D Interactive Bookshelf Section -->
    <section id="koleksi" class="koleksi-bg py-16 lg:py-20 border-y border-[#E6DFD5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="fade-in-up flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                        Top Buku Perpustakaan
                    </h2>
                    <p class="text-gray-500 text-sm sm:text-base mt-2.5 max-w-lg">
                        Jelajahi koleksi secara interaktif. Klik sampul mana pun untuk membaca ringkasan karya dan preview isi.
                    </p>
                </div>
                <a href="{{ route('books.collection') }}" class="shrink-0 px-5 py-2.5 bg-library-primary text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2 group">
                    <i class="fas fa-book text-xs"></i>
                Selengkapnya
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- 3D Bookshelf with clean frame -->
            <div class="fade-in-up delay-200 mb-2 sm:mb-6">
                <div class="shelf-frame">
                    <x-ashen-press class="" />
                </div>
            </div>

        </div>
    </section>

    <!-- Statistics & Info Section -->
    <section class="py-16 sm:py-20 bg-gradient-to-b from-gray-50/50 via-white to-gray-50/60 border-t border-gray-100 relative overflow-hidden">
        <!-- Subtle background glow decoration -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-100/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                
                <!-- Left Column: Statistics -->
                <div class="fade-in-up">
                    <div class="mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-library-primary border border-blue-100 shadow-xs mb-2">
                            <i class="fas fa-chart-pie text-[11px]"></i>
                            <span>Data & Aktivitas Terkini</span>
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Statistik Perpustakaan</h2>
                        <p class="text-sm text-gray-500 mt-1">Perkembangan inventaris koleksi dan aktivitas literasi civitas akademika.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Stat 1: Total Koleksi -->
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 relative group overflow-hidden">
                            <i class="fas fa-book-open absolute -right-3 -bottom-3 text-7xl text-blue-50/70 group-hover:text-blue-100/80 transition-colors pointer-events-none"></i>
                            <div class="flex items-center justify-between relative">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-book-bookmark text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Koleksi</p>
                                        <div class="flex items-baseline gap-2 mt-0.5">
                                            <p class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">1,250</p>
                                            <span class="text-sm font-bold text-blue-600">Buku</span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                <i class="fas fa-check-circle mr-1 text-[9px]"></i> Terkatalog
                                            </span>
                                            <span class="text-xs text-gray-400">Buku fisik</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden sm:flex items-center text-blue-500 font-semibold text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span>Lihat Semua</span>
                                    <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Stat 2: Anggota Aktif -->
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 hover:-translate-y-1 transition-all duration-300 relative group overflow-hidden">
                            <i class="fas fa-users absolute -right-3 -bottom-3 text-7xl text-emerald-50/70 group-hover:text-emerald-100/80 transition-colors pointer-events-none"></i>
                            <div class="flex items-center justify-between relative">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-user-graduate text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Anggota Terdaftar</p>
                                        <div class="flex items-baseline gap-2 mt-0.5">
                                            <p class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">520</p>
                                            <span class="text-sm font-bold text-emerald-600">Mahasiswa</span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <i class="fas fa-id-badge mr-1 text-[9px]"></i> Aktif Semester Ini
                                            </span>
                                            <span class="text-xs text-gray-400">Civitas akademika</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden sm:flex items-center text-emerald-600 font-semibold text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span>Tervalidasi</span>
                                    <i class="fas fa-check ml-1 text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Stat 3: Buku Dipinjam -->
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-amber-200 hover:-translate-y-1 transition-all duration-300 relative group overflow-hidden">
                            <i class="fas fa-receipt absolute -right-3 -bottom-3 text-7xl text-amber-50/70 group-hover:text-amber-100/80 transition-colors pointer-events-none"></i>
                            <div class="flex items-center justify-between relative">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-clock-rotate-left text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Buku Sedang Dipinjam</p>
                                        <div class="flex items-baseline gap-2 mt-0.5">
                                            <p class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">342</p>
                                            <span class="text-sm font-bold text-amber-600">Buku</span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                <i class="fas fa-arrows-rotate mr-1 text-[9px]"></i> Sirkulasi Lancar
                                            </span>
                                            <span class="text-xs text-gray-400">98% pengembalian tepat</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden sm:flex items-center text-amber-600 font-semibold text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span>Peminjaman Aktif</span>
                                    <i class="fas fa-arrow-up-right-from-square ml-1 text-[10px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Google Maps Lokasi ULBI -->
                        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">
                            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                                        <i class="fas fa-map-location-dot"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-sm sm:text-base">Lokasi Perpustakaan</h3>
                                        <p class="text-xs text-gray-400">Universitas Logistik dan Bisnis Internasional (ULBI)</p>
                                    </div>
                                </div>
                                <a href="https://maps.google.com/?q=Universitas+Logistik+dan+Bisnis+Internasional+(ULBI)+Bandung" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition-colors shadow-2xs">
                                    <i class="fas fa-directions text-[11px]"></i>
                                    <span>Petunjuk Arah</span>
                                </a>
                            </div>

                            <!-- Map Iframe with Rounded Corners & Subtle Border -->
                            <div class="w-full h-56 sm:h-64 rounded-xl overflow-hidden border border-gray-200/80 shadow-inner relative">
                                <iframe 
                                    src="https://maps.google.com/maps?q=Universitas+Logistik+dan+Bisnis+Internasional+(ULBI)+Bandung&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade"
                                    class="w-full h-full">
                                </iframe>
                            </div>

                            <div class="mt-3.5 pt-3 border-t border-gray-100 flex items-start gap-2 text-xs text-gray-500">
                                <i class="fas fa-location-dot text-rose-500 mt-0.5 shrink-0"></i>
                                <span>Jl. Sariasih No. 54, Sarijadi, Kec. Sukasari, Kota Bandung, Jawa Barat 40151</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Operating Hours & Contact -->
                <div class="fade-in-up delay-200 space-y-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-xs mb-2">
                            <i class="fas fa-info-circle text-[11px]"></i>
                            <span>Layanan & Informasi</span>
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Informasi Perpustakaan</h2>
                        <p class="text-sm text-gray-500 mt-1">Jadwal kunjungan tatap muka serta layanan bantuan perpustakaan.</p>
                    </div>

                    @php
                        $nowWib = \Carbon\Carbon::now('Asia/Jakarta');
                        $dayOfWeek = $nowWib->dayOfWeek; // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
                        $currentHourMin = (int)$nowWib->format('Hi'); // format JamMenit misal 0028

                        $isOpen = false;
                        $statusText = 'Sedang Tutup';
                        $statusDesc = '';

                        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
                            // Senin - Jumat: 08:00 - 17:00 WIB
                            if ($currentHourMin >= 800 && $currentHourMin < 1700) {
                                $isOpen = true;
                                $statusText = 'Buka Sekarang';
                                $statusDesc = 'Buka s/d 17:00 WIB';
                            } elseif ($currentHourMin < 800) {
                                $statusDesc = 'Buka hari ini pukul 08:00 WIB';
                            } else {
                                $statusDesc = ($dayOfWeek == 5) ? 'Buka besok (Sabtu) pukul 08:00 WIB' : 'Buka besok pukul 08:00 WIB';
                            }
                        } elseif ($dayOfWeek == 6) {
                            // Sabtu: 08:00 - 14:00 WIB
                            if ($currentHourMin >= 800 && $currentHourMin < 1400) {
                                $isOpen = true;
                                $statusText = 'Buka Sekarang';
                                $statusDesc = 'Buka s/d 14:00 WIB';
                            } elseif ($currentHourMin < 800) {
                                $statusDesc = 'Buka hari ini pukul 08:00 WIB';
                            } else {
                                $statusDesc = 'Buka Senin pukul 08:00 WIB';
                            }
                        } else {
                            // Minggu: Tutup
                            $statusDesc = 'Buka Senin pukul 08:00 WIB';
                        }
                    @endphp

                    <!-- Jam Operasional Card -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-library-primary flex items-center justify-center text-base">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm sm:text-base">Jam Operasional</h3>
                                    <p class="text-xs text-gray-500 font-medium">{{ $statusDesc }}</p>
                                </div>
                            </div>
                            <!-- Live Status Indicator Dinamis (WIB) -->
                            @if($isOpen)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span>Buka Sekarang</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 shadow-2xs">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    <span>Sedang Tutup</span>
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2.5 text-sm">
                            <!-- Senin - Jumat -->
                            <div class="flex items-center justify-between p-2.5 rounded-xl transition-colors {{ ($dayOfWeek >= 1 && $dayOfWeek <= 5) ? 'bg-blue-50/70 border border-blue-200/80 ring-1 ring-blue-200/50' : 'bg-gray-50/70 hover:bg-gray-50' }}">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg {{ ($dayOfWeek >= 1 && $dayOfWeek <= 5) ? 'bg-blue-600 text-white' : 'bg-blue-100/60 text-blue-600' }} flex items-center justify-center text-xs">
                                        <i class="fas fa-calendar-week"></i>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-800">Senin – Jumat</span>
                                        @if($dayOfWeek >= 1 && $dayOfWeek <= 5)
                                            <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-1.5 py-0.5 rounded-md">Hari Ini</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-bold text-xs sm:text-sm text-gray-900 bg-white px-3 py-1 rounded-lg border border-gray-200/80 shadow-2xs">
                                    08:00 – 17:00 WIB
                                </span>
                            </div>

                            <!-- Sabtu -->
                            <div class="flex items-center justify-between p-2.5 rounded-xl transition-colors {{ ($dayOfWeek == 6) ? 'bg-amber-50/70 border border-amber-200/80 ring-1 ring-amber-200/50' : 'bg-gray-50/70 hover:bg-gray-50' }}">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg {{ ($dayOfWeek == 6) ? 'bg-amber-500 text-white' : 'bg-amber-100/60 text-amber-600' }} flex items-center justify-center text-xs">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-800">Sabtu</span>
                                        @if($dayOfWeek == 6)
                                            <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded-md">Hari Ini</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-bold text-xs sm:text-sm text-gray-900 bg-white px-3 py-1 rounded-lg border border-gray-200/80 shadow-2xs">
                                    08:00 – 14:00 WIB
                                </span>
                            </div>

                            <!-- Minggu & Libur Nasional -->
                            <div class="flex items-center justify-between p-2.5 rounded-xl transition-colors {{ ($dayOfWeek == 0) ? 'bg-rose-50 border border-rose-200 ring-1 ring-rose-200/50' : 'bg-rose-50/40 border border-rose-100/60' }}">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg {{ ($dayOfWeek == 0) ? 'bg-rose-500 text-white' : 'bg-rose-100/80 text-rose-500' }} flex items-center justify-center text-xs">
                                        <i class="fas fa-calendar-xmark"></i>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-700">Minggu & Libur Nasional</span>
                                        @if($dayOfWeek == 0)
                                            <span class="text-[10px] font-bold text-rose-700 bg-rose-100 px-1.5 py-0.5 rounded-md">Hari Ini</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-bold text-xs text-rose-600 bg-rose-100/80 px-3 py-1 rounded-lg">
                                    Tutup
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
                            <i class="fas fa-circle-info text-blue-500"></i>
                            <span>Akses katalog buku online & peminjaman digital tetap aktif <strong>24/7</strong>.</span>
                        </div>
                    </div>

                    <!-- Kontak Card Interaktif -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex items-center space-x-3 pb-4 mb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm sm:text-base">Kontak & Pusat Bantuan</h3>
                                <p class="text-xs text-gray-400">Hubungi petugas kami untuk bantuan literasi</p>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            <!-- Telepon -->
                            <a href="tel:02112345678" class="group flex items-center justify-between p-3 rounded-xl bg-gray-50/70 hover:bg-blue-50/70 border border-transparent hover:border-blue-200 transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-100/80 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-phone-alt text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Telepon Layanan</p>
                                        <p class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">(021) 1234-5678</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-blue-600 flex items-center gap-1 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all">
                                    <span>Panggil</span>
                                    <i class="fas fa-chevron-right text-[10px]"></i>
                                </span>
                            </a>

                            <!-- Email -->
                            <a href="mailto:info@perpustakaan.ac.id" class="group flex items-center justify-between p-3 rounded-xl bg-gray-50/70 hover:bg-indigo-50/70 border border-transparent hover:border-indigo-200 transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-100/80 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-envelope text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Surel Resmi</p>
                                        <p class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">info@perpustakaan.ac.id</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-indigo-600 flex items-center gap-1 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all">
                                    <span>Kirim Surel</span>
                                    <i class="fas fa-chevron-right text-[10px]"></i>
                                </span>
                            </a>

                            <!-- Lokasi -->
                            <a href="https://maps.google.com/?q=Universitas+Logistik+dan+Bisnis+Internasional+(ULBI)+Bandung" target="_blank" class="group flex items-center justify-between p-3 rounded-xl bg-gray-50/70 hover:bg-emerald-50/70 border border-transparent hover:border-emerald-200 transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100/80 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-location-dot text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Lokasi Gedung</p>
                                        <p class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">ULBI Bandung, Jl. Sariasih No. 54</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1 opacity-80 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all">
                                    <span>Peta</span>
                                    <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('components.footer')

    <!-- Scroll Animation Script -->
    <script>
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in-up elements
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Trigger initial animation for hero section
        window.addEventListener('load', () => {
            const heroElements = document.querySelectorAll('.fade-in-up');
            heroElements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('visible');
                }, index * 100);
            });
        });
    </script>
</body>
</html>
