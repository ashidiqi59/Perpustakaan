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
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">Beranda</a>
                    <a href="{{ route('books.collection') }}" class="{{ request()->routeIs('books.collection') || request()->routeIs('books.show') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">Koleksi</a>
                    @auth
                        <a href="{{ route('my-loans') }}" class="{{ request()->routeIs('my-loans') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">
                            <i class="fas fa-history mr-1"></i>Peminjaman
                        </a>
                    @endauth
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

