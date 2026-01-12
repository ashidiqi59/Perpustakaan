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
                @foreach($popularBooks as $index => $book)
                <div class="fade-in-up delay-{{ ($index + 1) * 100 }} book-card">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <div class="relative">
                            <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                            <div class="absolute top-2 right-2">
                                <span class="status-badge {{ $book->stock > 0 ? 'status-available' : 'status-borrowed' }}">{{ $book->stock > 0 ? 'Tersedia' : 'Dipinjam' }}</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 text-sm line-clamp-2">{{ $book->title }}</h3>
                            <p class="text-xs text-gray-500 mb-2">{{ $book->author ?: 'Penulis Tidak Diketahui' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">ISBN: {{ $book->isbn }}</span>
                                <span class="text-xs text-library-primary font-semibold">{{ $book->stock }} tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
