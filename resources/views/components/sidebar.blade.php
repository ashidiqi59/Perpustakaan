<aside id="sidebar" class="h-full bg-slate-900 text-white flex flex-col">
    <!-- Mobile Header with Close Button -->
    <div class="p-4 border-b border-slate-700 relative shrink-0 flex items-center justify-between md:hidden">
        <div class="flex items-center gap-3">
            <i class="fas fa-book-reader text-amber-400 text-2xl"></i>
            <div>
                <h1 class="sidebar-text text-xl font-bold text-amber-400">PERPUSTAKAAN</h1>
                <p class="sidebar-subtitle text-xs text-slate-400 mt-0.5">Admin Panel</p>
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
                <p class="sidebar-subtitle text-xs text-slate-400 mt-0.5">Admin Panel</p>
            </div>
        </div>
        <button id="sidebar-toggle" onclick="toggleSidebar()" class="absolute -right-3 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center text-white hover:bg-slate-600 transition-colors shadow-lg z-10 border-2 border-slate-900">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
    </div>

    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
            <i class="fas fa-home w-5 text-center"></i>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('admin.books.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
            <i class="fas fa-book w-5 text-center"></i>
            <span class="nav-text">Kelola Buku</span>
        </a>
        <a href="{{ route('admin.loans.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.loans.*') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
            <i class="fas fa-clipboard-list w-5 text-center"></i>
            <span class="nav-text">Kelola Peminjaman</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
            <i class="fas fa-users w-5 text-center"></i>
            <span class="nav-text">Kelola Users</span>
        </a>
    </nav>

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

