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
    </style>
</head>
<body>
    <!-- Header / Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-library-primary rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Perpustakaan</h1>
                        <p class="text-xs text-gray-500">Sistem Informasi Perpustakaan</p>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-900 font-semibold border-b-2 border-library-primary pb-1">Beranda</a>
                    <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Koleksi</a>
                    <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Peminjaman</a>
                    <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Kontak</a>
                </div>
                
                <!-- Right Icons -->
                <div class="flex items-center space-x-4">
                    <button class="md:hidden text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->npm }}</p>
                                </div>
                                <div class="w-10 h-10 bg-library-light rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-red-600 transition-colors text-sm">Keluar</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="bg-library-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

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
                    <div class="bg-white rounded-xl shadow-lg p-2 flex gap-2 mb-6">
                        <input 
                            type="text" 
                            placeholder="Cari judul buku, penulis, atau ISBN..." 
                            class="flex-1 px-4 py-3 border-0 focus:outline-none focus:ring-0 text-gray-700"
                        >
                        <button class="bg-library-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-library-primary">1,250+</div>
                            <div class="text-xs text-gray-600 mt-1">Koleksi Buku</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-library-primary">500+</div>
                            <div class="text-xs text-gray-600 mt-1">Anggota Aktif</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-library-primary">24/7</div>
                            <div class="text-xs text-gray-600 mt-1">Akses Online</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right - Featured Books Stack -->
                <div class="fade-in-up delay-200 flex justify-center">  
                    <div class="relative h-[500px] w-[300px]">
                        <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 1" class="absolute top-0 left-0 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[-5deg] z-30 hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 2" class="absolute top-6 left-12 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[2deg] z-20 hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Featured Book 3" class="absolute top-12 left-24 w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-[-3deg] z-10 hover:rotate-0 transition-transform duration-300">
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="flex justify-center mt-12 fade-in-up delay-400">
                <div class="scroll-indicator">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12 fade-in-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Layanan Perpustakaan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai layanan untuk mendukung kebutuhan informasi dan pembelajaran Anda</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $services = [
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Peminjaman Buku', 'desc' => 'Pinjam buku fisik dan digital dengan mudah'],
                    ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Reservasi Buku', 'desc' => 'Reservasi buku yang sedang dipinjam'],
                    ['icon' => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Pengembalian', 'desc' => 'Kembalikan buku dengan cepat dan mudah'],
                    ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'title' => 'Pencarian Katalog', 'desc' => 'Cari buku dari koleksi perpustakaan']
                ];
            @endphp
            
            @foreach($services as $index => $service)
            <div class="fade-in-up delay-{{ ($index + 1) * 100 }} service-card bg-white rounded-xl p-6 shadow-md hover:shadow-lg">
                <div class="icon-bg bg-library-light mb-4">
                    <svg class="w-8 h-8 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service['title'] }}</h3>
                <p class="text-sm text-gray-600">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Popular Books Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12 fade-in-up">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Koleksi Populer</h2>
                    <p class="text-gray-600">Buku-buku yang paling banyak dipinjam</p>
                </div>
                <a href="#" class="text-library-primary font-semibold hover:underline flex items-center gap-2">
                    Lihat Semua
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @for($i = 0; $i < 5; $i++)
                <div class="fade-in-up delay-{{ ($i + 1) * 100 }} book-card">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <div class="relative">
                            <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Book {{ $i + 1 }}" class="w-full h-64 object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="status-badge status-available">Tersedia</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 text-sm line-clamp-2">Pemrograman Web Modern</h3>
                            <p class="text-xs text-gray-500 mb-2">Dr. Ahmad Fauzi</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">ISBN: 978-123-456</span>
                                <span class="text-xs text-library-primary font-semibold">15x dipinjam</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Statistics & Info Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Statistics -->
            <div class="fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Statistik Perpustakaan</h2>
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-6 shadow-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="icon-bg bg-library-light">
                                <svg class="w-6 h-6 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Koleksi</p>
                                <p class="text-2xl font-bold text-gray-900">1,250 Buku</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 shadow-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="icon-bg bg-library-light">
                                <svg class="w-6 h-6 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Anggota Aktif</p>
                                <p class="text-2xl font-bold text-gray-900">520 Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-6 shadow-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="icon-bg bg-library-light">
                                <svg class="w-6 h-6 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                                <p class="text-2xl font-bold text-gray-900">342 Buku</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Operating Hours & Contact -->
            <div class="fade-in-up delay-200">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi Perpustakaan</h2>
                <div class="bg-white rounded-lg p-6 shadow-md mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Jam Operasional
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Senin - Jumat</span>
                            <span class="font-medium text-gray-900">08:00 - 17:00 WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sabtu</span>
                            <span class="font-medium text-gray-900">08:00 - 14:00 WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Minggu</span>
                            <span class="font-medium text-red-600">Tutup</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-library-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kontak
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-600">(021) 1234-5678</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-600">info@perpustakaan.ac.id</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-600">Jl. Kampus No. 123, Jakarta</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-library-primary rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold">Perpustakaan</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400">Sistem Informasi Perpustakaan Digital untuk mendukung pembelajaran dan penelitian.</p>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Koleksi Buku</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Peminjaman</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pengembalian</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Reservasi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Pencarian Katalog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Buku Digital</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Jurnal Online</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-library-primary transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-library-primary transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-library-primary transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Perpustakaan. All rights reserved.</p>
                <p class="mt-2 text-gray-500">Sistem Informasi Perpustakaan Digital</p>
            </div>
        </div>
    </footer>

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
