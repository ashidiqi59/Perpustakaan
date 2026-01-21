<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @if(Route::is('admin.*'))
        <meta http-equiv="refresh" content="30">
        @endif
        <title>Perpustakaan | Admin Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            /* Sidebar fixed width */
            #sidebar {
                width: 256px;
                flex-shrink: 0;
                transition: all 0.3s ease;
            }
            
            /* Main content takes remaining space */
            #main-content {
                flex: 1;
                min-width: 0;
                transition: margin-left 0.3s ease;
            }
            
            /* Collapsed sidebar */
            #sidebar.collapsed {
                width: 80px !important;
            }
            
            /* Main content adjusted when sidebar collapsed - no margin needed since flex handles it */
            #sidebar.collapsed ~ #main-content {
                /* In flex layout, content automatically expands - no margin needed */
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
        </style>
        <script>
            // Auto-refresh every 30 seconds untuk data terbaru (hanya di dashboard)
            @if(Route::is('admin.dashboard'))
            setTimeout(function() {
                window.location.reload(true);
            }, 30000);
            @endif

            // Toggle Sidebar functionality
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const toggleBtn = document.getElementById('sidebar-toggle');
                
                // Toggle collapsed state
                sidebar.classList.toggle('collapsed');
                toggleBtn.classList.toggle('collapsed');
                
                // Save state to localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }

            // Load sidebar state on page load
            document.addEventListener('DOMContentLoaded', function() {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    document.getElementById('sidebar').classList.add('collapsed');
                    document.getElementById('sidebar-toggle').classList.add('collapsed');
                }
            });
        </script>
        @stack('styles')
    </head>
    <body class="h-screen bg-slate-100 text-slate-800 font-sans">
        <div class="flex h-full">
            <!-- SIDEBAR -->
            @include('components.sidebar')

            <!-- MAIN CONTENT -->
            <main id="main-content" class="flex-1 flex flex-col h-full min-w-0">
                <!-- TOP BAR -->
                <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center shrink-0">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">@yield('title', 'Dashboard')</h2>
                        <p class="text-sm text-slate-500">@yield('subtitle', 'Selamat datang, ' . Auth::user()->name)</p>
                    </div>
                    <div class="flex items-center gap-4">
                        @yield('header-actions')
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm rounded-full font-medium">
                            <i class="fas fa-shield-alt mr-1"></i>Admin
                        </span>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    @yield('content')
                </div>
            </main>
        </div>
        @stack('scripts')
    </body>
</html>

