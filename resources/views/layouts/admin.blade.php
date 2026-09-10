<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Admin Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
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
            // Toggle Sidebar functionality
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                const isMobile = window.innerWidth <= 768;
                
                if (isMobile) {
                    sidebar.classList.toggle('active');
                    if (overlay) {
                        overlay.classList.toggle('active');
                    }
                    document.body.classList.toggle('sidebar-open', sidebar.classList.contains('active'));
                } else {
                    sidebar.classList.toggle('collapsed');
                    document.getElementById('sidebar-toggle').classList.toggle('collapsed');
                    
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                }
            }

            // Close sidebar when clicking overlay
            function closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    if (overlay) {
                        overlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                }
            }

            // Load sidebar state on page load
            document.addEventListener('DOMContentLoaded', function() {
                const isMobile = window.innerWidth <= 768;
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebar-toggle');
                
                if (isMobile) {
                    sidebar.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                } else {
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        if (toggleBtn) {
                            toggleBtn.classList.add('collapsed');
                        }
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    if (overlay) {
                        overlay.classList.remove('active');
                    }
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
            @include('components.sidebar')

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
                            <h2 class="text-lg sm:text-xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h2>
                            <p class="text-xs sm:text-sm text-slate-500">@yield('subtitle', 'Selamat datang, ' . (Auth::user()?->name ?? 'User'))</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        @yield('header-actions')
                        <span class="hidden sm:inline-flex px-3 py-1 bg-amber-100 text-amber-700 text-xs sm:text-sm rounded-full font-medium">
                            <i class="fas fa-shield-alt mr-1"></i>Admin
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
        @stack('scripts')
    </body>
</html>

