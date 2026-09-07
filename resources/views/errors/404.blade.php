<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | Perpustakaan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=EB+Garamond:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .font-serif {
            font-family: 'EB Garamond', Georgia, serif;
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

        /* Subtle grid background */
        .bg-grid-pattern {
            background-color: #F8FAFC;
            background-image: radial-gradient(#CBD5E1 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Floating Animation */
        @keyframes floatSlow {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(1.5deg);
            }
        }

        @keyframes floatReverse {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(8px) rotate(-1.5deg);
            }
        }

        .animate-float {
            animation: floatSlow 4s ease-in-out infinite;
        }

        .animate-float-reverse {
            animation: floatReverse 5s ease-in-out infinite;
        }

        .text-gradient {
            background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 50%, #60A5FA 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-grid-pattern text-gray-800 min-h-screen flex flex-col justify-between antialiased">
    <x-page-loader />
    @include('components.navbar')

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12 sm:py-20 relative overflow-hidden">
        <!-- Ambient Decorative Glows -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 sm:w-[540px] h-96 sm:h-[540px] bg-blue-400/15 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-amber-200/20 rounded-full blur-2xl pointer-events-none -z-10"></div>

        <div class="max-w-2xl w-full text-center relative z-10">
            <!-- 404 Creative Illustration & Badge -->
            <div class="relative inline-flex items-center justify-center mb-6">
                <!-- Floating Decorative Books -->
                <div class="hidden sm:block absolute -left-16 top-2 animate-float text-blue-500/70">
                    <div class="w-12 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-r-md shadow-lg flex items-center justify-center text-white text-lg">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                <div class="hidden sm:block absolute -right-16 bottom-4 animate-float-reverse text-amber-500/80">
                    <div class="w-11 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-l-md shadow-lg flex items-center justify-center text-white text-base">
                        <i class="fas fa-bookmark"></i>
                    </div>
                </div>

                <!-- Big 404 Digits -->
                <div class="relative flex items-center justify-center">
                    <span class="text-8xl sm:text-9xl font-extrabold tracking-tighter text-gradient select-none">
                        404
                    </span>
                    
                    <!-- Center Floating Magnifying Glass & Book -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white/80 backdrop-blur-md border border-white shadow-xl flex items-center justify-center text-library-primary transform -rotate-6 transition-transform hover:rotate-0 duration-300">
                            <i class="fas fa-search text-2xl sm:text-3xl text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Pill Badge -->
            <div class="mb-4 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200/80 text-blue-700 text-xs font-semibold tracking-wide uppercase">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-ping"></span>
                <span>Halaman Tidak Ditemukan</span>
            </div>

            <!-- Heading & Description -->
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-3 font-serif">
                Buku atau Rak Ini Belum Tersedia
            </h1>
            <p class="text-sm sm:text-base text-gray-600 max-w-lg mx-auto mb-8 leading-relaxed">
                Maaf, halaman atau buku yang Anda tuju telah dipindahkan, tautan salah ketik, atau belum tercatat di katalog sistem perpustakaan.
            </p>

            <!-- Search Box Quick Action -->
            <div class="max-w-md mx-auto mb-8">
                <form action="{{ route('books.collection') }}" method="GET" class="relative flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari judul buku, penulis, atau topik..."
                        class="w-full pl-11 pr-24 py-3.5 bg-white rounded-2xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 text-sm shadow-sm transition-all outline-none"
                    >
                    <div class="absolute left-4 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <button 
                        type="submit" 
                        class="absolute right-2 px-4 py-2 bg-library-primary text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm"
                    >
                        Cari
                    </button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-library-primary text-white text-sm font-semibold rounded-xl hover:bg-blue-700 active:scale-95 transition-all shadow-md hover:shadow-lg group">
                    <i class="fas fa-home text-xs transition-transform group-hover:-translate-y-0.5"></i>
                    <span>Kembali ke Beranda</span>
                </a>

                <a href="{{ route('books.collection') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white text-gray-700 hover:text-blue-600 border border-gray-200 hover:border-blue-300 text-sm font-semibold rounded-xl hover:bg-blue-50/50 active:scale-95 transition-all shadow-sm">
                    <i class="fas fa-book text-xs text-blue-600"></i>
                    <span>Jelajahi Koleksi Buku</span>
                </a>

                <button onclick="window.history.back()" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 text-gray-500 hover:text-gray-800 text-sm font-medium transition-colors">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Halaman Sebelumnya</span>
                </button>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>
</html>
