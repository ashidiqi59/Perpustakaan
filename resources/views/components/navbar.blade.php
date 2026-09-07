<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        
        menu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobile-menu');
        const menuButton = event.target.closest('button[onclick="toggleMobileMenu()"]');
        const menuContent = event.target.closest('#mobile-menu');
        
        // If menu is open and click is outside menu and menu button
        if (!menu.classList.contains('hidden') && !menuButton && !menuContent) {
            menu.classList.add('hidden');
            document.getElementById('menu-icon').classList.remove('hidden');
            document.getElementById('close-icon').classList.add('hidden');
        }
    });
</script>

<!-- Header / Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-library-primary rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-base sm:text-xl font-bold text-gray-900 truncate">Perpustakaan</h1>
                        <p class="text-[10px] sm:text-xs text-gray-500 truncate">Sistem Informasi Perpustakaan</p>
                    </div>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">Beranda</a>
                    <a href="{{ route('books.collection') }}" class="{{ request()->routeIs('books.collection') || request()->routeIs('books.show') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">Koleksi</a>
                    @auth
                        <a href="{{ route('my-loans') }}" class="{{ request()->routeIs('my-loans') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors">
                            <i class="fas fa-history mr-1"></i>Peminjaman
                        </a>
                        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'text-gray-900 font-semibold border-b-2 border-library-primary' : 'text-gray-600 hover:text-library-primary' }} transition-colors flex items-center">
                            <i class="fas fa-user-circle mr-1"></i>Profil
                            @if(!Auth::user()->isProfileComplete())
                                <span class="w-2 h-2 ml-1 rounded-full bg-amber-500 ring-2 ring-white animate-pulse" title="Lengkapi Biodata"></span>
                            @endif
                        </a>
                    @endauth
                    <!-- <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Tentang</a>
                    <a href="#" class="text-gray-600 hover:text-library-primary transition-colors">Kontak</a> -->
                </div>

                <!-- Right Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600 p-2">
                        <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('profile') }}" class="flex items-center space-x-3 group hover:opacity-90 transition-opacity">
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-library-primary transition-colors">{{ Auth::user()->name }}</p>
                                        <p class="text-xs {{ empty(Auth::user()->npm) ? 'text-amber-600 font-semibold' : 'text-gray-500' }}">
                                            {{ Auth::user()->npm ?: 'Lengkapi Biodata' }}
                                        </p>
                                    </div>
                                    <div class="relative">
                                        <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100" alt="{{ Auth::user()->name }}">
                                        @if(!Auth::user()->isProfileComplete())
                                            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-amber-500 rounded-full ring-2 ring-white" title="Biodata belum lengkap"></span>
                                        @endif
                                    </div>
                                </a>
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

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-4 space-y-3">
                <!-- Mobile Navigation Links -->
                <a href="{{ route('home') }}" class="block py-2 px-3 rounded-lg {{ request()->routeIs('home') ? 'bg-library-light text-library-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">Beranda</a>
                <a href="{{ route('books.collection') }}" class="block py-2 px-3 rounded-lg {{ request()->routeIs('books.collection') || request()->routeIs('books.show') ? 'bg-library-light text-library-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">Koleksi</a>
                @auth
                    <a href="{{ route('my-loans') }}" class="block py-2 px-3 rounded-lg {{ request()->routeIs('my-loans') ? 'bg-library-light text-library-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-history mr-1"></i>Peminjaman
                    </a>
                    <a href="{{ route('profile') }}" class="block py-2 px-3 rounded-lg {{ request()->routeIs('profile') ? 'bg-library-light text-library-primary font-semibold' : 'text-gray-600 hover:bg-gray-50' }} transition-colors flex items-center justify-between">
                        <span><i class="fas fa-user-circle mr-1"></i>Profil Saya</span>
                        @if(!Auth::user()->isProfileComplete())
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-800 rounded-full">Lengkapi</span>
                        @endif
                    </a>
                @endauth
                <!-- <a href="#" class="block py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">Tentang</a>
                <a href="#" class="block py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">Kontak</a> -->
                
                <hr class="border-gray-200 my-3">
                
                <!-- Mobile Auth Section -->
                @auth
                    <div class="pt-2">
                        <a href="{{ route('profile') }}" class="flex items-center space-x-3 py-2 px-3 hover:bg-gray-50 rounded-xl transition-colors">
                            <div class="relative">
                                <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100" alt="{{ Auth::user()->name }}">
                                @if(!Auth::user()->isProfileComplete())
                                    <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-amber-500 rounded-full ring-2 ring-white"></span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs {{ empty(Auth::user()->npm) ? 'text-amber-600 font-semibold' : 'text-gray-500' }}">
                                    {{ Auth::user()->npm ?: 'Lengkapi Biodata' }}
                                </p>
                            </div>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-library-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </header>

