            <!-- SIDEBAR -->
            <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0">
                <div class="p-6 border-b border-slate-700">
                    <h1 class="text-xl font-bold text-amber-400">
                        <i class="fas fa-book-reader mr-2"></i>PERPUSTAKAAN
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">Admin Panel</p>
                </div>
                
                <nav class="flex-1 p-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-home w-5"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.books.*') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-book w-5"></i>
                        Kelola Buku
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 rounded-lg transition-colors">
                        <i class="fas fa-clipboard-list w-5"></i>
                        Peminjaman
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-amber-500 text-slate-900' : 'text-slate-300 hover:bg-slate-800' }}">
                        <i class="fas fa-users w-5"></i>
                        Kelola Users
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-red-400 hover:bg-slate-800 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

