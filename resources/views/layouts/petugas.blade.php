<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Perpustakaan | @yield('title', 'Petugas Dashboard')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            * { font-family: 'Inter', sans-serif; }

            /* Sidebar fixed width for desktop */
            #sidebar {
                width: 256px;
                flex-shrink: 0;
                transition: all 0.3s ease;
                z-index: 50;
            }

            /* Main content takes remaining space */
            #main-content {
                flex: 1;
                min-width: 0;
                transition: all 0.3s ease;
            }

            /* Collapsed sidebar */
            #sidebar.collapsed {
                width: 80px !important;
            }

            /* Hide text when collapsed */
            #sidebar.collapsed .sidebar-text,
            #sidebar.collapsed .sidebar-subtitle,
            #sidebar.collapsed .nav-text,
            #sidebar.collapsed .logout-text {
                display: none !important;
            }

            /* Center nav items when collapsed */
            #sidebar.collapsed .nav-item {
                justify-content: center;
                padding: 12px 0;
            }

            /* Toggle button transition */
            #sidebar-toggle {
                transition: all 0.3s ease;
            }

            #sidebar-toggle.collapsed {
                right: -12px;
            }

            #sidebar-toggle.collapsed i {
                transform: rotate(180deg);
            }

            /* Mobile Overlay */
            #sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            #sidebar-overlay.active {
                display: block;
            }

            /* Desktop Layout */
            @media (min-width: 769px) {
                html, body {
                    height: 100%;
                    overflow: hidden;
                }
                .app-wrapper {
                    height: 100vh;
                }
                #sidebar {
                    height: 100%;
                }
                #main-content {
                    height: 100%;
                    overflow: hidden;
                }
                #content-scroll-area {
                    flex: 1 1 0%;
                    overflow-y: auto;
                    -webkit-overflow-scrolling: touch;
                }
                .mobile-menu-btn {
                    display: none !important;
                }
            }

            /* Mobile Layout (Phone & Tablet) */
            @media (max-width: 768px) {
                html, body {
                    height: auto !important;
                    min-height: 100% !important;
                    overflow-x: hidden !important;
                    overflow-y: auto !important;
                    -webkit-overflow-scrolling: touch !important;
                    overscroll-behavior-y: auto !important;
                }

                body.sidebar-open {
                    overflow: hidden !important;
                }

                .app-wrapper {
                    height: auto !important;
                    min-height: 100vh !important;
                }

                #sidebar {
                    position: fixed;
                    left: -256px;
                    top: 0;
                    height: 100vh;
                    transform: translateX(0);
                    transition: left 0.3s ease;
                    z-index: 50;
                }

                #sidebar.active {
                    left: 0;
                }

                #sidebar.collapsed {
                    width: 256px !important;
                }

                #sidebar.collapsed .sidebar-text,
                #sidebar.collapsed .sidebar-subtitle,
                #sidebar.collapsed .nav-text,
                #sidebar.collapsed .logout-text {
                    display: block !important;
                }

                #sidebar.collapsed .nav-item {
                    justify-content: flex-start;
                    padding: 12px 16px;
                }

                #sidebar-toggle {
                    display: none !important;
                }

                #main-content {
                    width: 100%;
                    height: auto !important;
                    min-height: 100vh !important;
                    overflow: visible !important;
                }

                #top-header {
                    position: sticky;
                    top: 0;
                    z-index: 30;
                }

                #content-scroll-area {
                    height: auto !important;
                    overflow: visible !important;
                    flex: none !important;
                    padding: 1rem;
                    -webkit-overflow-scrolling: touch !important;
                }

                .mobile-menu-btn {
                    display: flex !important;
                }
            }
        </style>
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                const isMobile = window.innerWidth <= 768;

                if (isMobile) {
                    sidebar.classList.toggle('active');
                    if (overlay) overlay.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open', sidebar.classList.contains('active'));
                } else {
                    sidebar.classList.toggle('collapsed');
                    document.getElementById('sidebar-toggle').classList.toggle('collapsed');
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('petugasSidebarCollapsed', isCollapsed);
                }
            }

            function closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    if (overlay) overlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const isMobile = window.innerWidth <= 768;
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebar-toggle');

                if (isMobile) {
                    sidebar.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                } else {
                    const isCollapsed = localStorage.getItem('petugasSidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        if (toggleBtn) toggleBtn.classList.add('collapsed');
                    }
                }
            });

            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    if (overlay) overlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                }
            });
        </script>
        @stack('styles')
    </head>
    <body class="bg-slate-100 text-slate-800 font-sans">
        <x-page-loader />

        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" onclick="closeSidebar()"></div>

        <div class="app-wrapper flex">
            <!-- SIDEBAR -->
            <aside id="sidebar" class="bg-slate-900 text-white flex flex-col">
                <!-- Mobile Header -->
                <div class="p-4 border-b border-slate-700 relative shrink-0 flex items-center justify-between md:hidden">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-book-reader text-amber-400 text-2xl"></i>
                        <div>
                            <h1 class="sidebar-text text-xl font-bold text-amber-400">PERPUSTAKAAN</h1>
                            <p class="sidebar-subtitle text-xs text-slate-400 mt-0.5">Petugas Panel</p>
                        </div>
                    </div>
                    <button onclick="closeSidebar()" class="w-8 h-8 flex items-center justify-center bg-slate-700 rounded-full text-slate-300 hover:bg-slate-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Desktop Header -->
                <div class="p-4 border-b border-slate-700 relative shrink-0 hidden md:block">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-book-reader text-amber-400 text-2xl"></i>
                        <div>
                            <h1 class="sidebar-text text-xl font-bold text-amber-400">PERPUSTAKAAN</h1>
                            <p class="sidebar-subtitle text-xs text-slate-400 mt-0.5">Petugas Panel</p>
                        </div>
                    </div>
                    <button id="sidebar-toggle" onclick="toggleSidebar()" class="absolute -right-3 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center text-white hover:bg-slate-600 transition-colors shadow-lg z-10 border-2 border-slate-900">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
                    <a href="{{ route('petugas.dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('petugas.dashboard') ? 'bg-amber-500 text-slate-900 font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-qrcode w-5 text-center text-base"></i>
                        <span class="nav-text">Scanner Barcode</span>
                    </a>

                    <div class="border-t border-slate-700/60 my-2"></div>
                    <p class="nav-text text-[10px] text-slate-400 px-4 py-1 uppercase font-semibold tracking-wider">Aktivitas Hari Ini</p>

                    <a href="{{ route('petugas.scanner.sirkulasi') }}" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('petugas.scanner.sirkulasi') ? 'bg-indigo-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-exchange-alt w-5 text-center"></i>
                        <span class="nav-text">Sirkulasi Buku</span>
                    </a>

                    <a href="{{ route('petugas.scanner.presensi') }}" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors {{ request()->routeIs('petugas.scanner.presensi') ? 'bg-violet-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="nav-text">Presensi Pengunjung</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                        <div class="border-t border-slate-700 my-2"></div>
                        <p class="nav-text text-xs text-slate-500 px-4 py-1 uppercase font-semibold tracking-wider">Admin</p>
                        <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors text-slate-300 hover:bg-slate-800">
                            <i class="fas fa-tachometer-alt w-5 text-center"></i>
                            <span class="nav-text">Admin Dashboard</span>
                        </a>
                        <a href="{{ route('admin.loans.index') }}" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors text-slate-300 hover:bg-slate-800">
                            <i class="fas fa-clipboard-list w-5 text-center"></i>
                            <span class="nav-text">Kelola Peminjaman</span>
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-lg font-medium transition-colors text-slate-300 hover:bg-slate-800">
                            <i class="fas fa-history w-5 text-center"></i>
                            <span class="nav-text">Riwayat Presensi</span>
                        </a>
                    @endif
                </nav>

                <!-- Logout -->
                <div class="p-4 border-t border-slate-700 shrink-0">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item flex items-center gap-3 w-full px-4 py-3 text-red-400 hover:bg-slate-800 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span class="logout-text">Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main id="main-content" class="flex-1 flex flex-col min-w-0">
                <!-- TOP BAR -->
                <header id="top-header" class="bg-white shadow-sm px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-3">
                        <!-- Mobile Menu Button -->
                        <button onclick="toggleSidebar()" class="mobile-menu-btn w-10 h-10 items-center justify-center bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            <i class="fas fa-bars text-slate-600"></i>
                        </button>
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-slate-800">@yield('title', 'Scanner Barcode')</h2>
                            <p class="text-xs sm:text-sm text-slate-500">@yield('subtitle', 'Selamat datang, ' . Auth::user()->name)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        @yield('header-actions')
                        <span class="hidden sm:inline-flex px-3 py-1 bg-indigo-100 text-indigo-700 text-xs sm:text-sm rounded-full font-medium">
                            <i class="fas fa-user-shield mr-1"></i>
                            {{ auth()->user()->isAdmin() ? 'Admin' : 'Petugas' }}
                        </span>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div id="content-scroll-area" class="flex-1 p-4 sm:p-6">
                    @yield('content')
                </div>
            </main>
        </div>

        <x-toast-notification />
        <x-confirm-modal />

        @stack('scripts')
    </body>
</html>
