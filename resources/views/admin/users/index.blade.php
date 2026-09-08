@extends('layouts.admin')

@section('title', 'Kelola Users')
@section('subtitle', 'Kelola dan kelompokkan data pengguna perpustakaan')

@section('header-actions')
    <a href="{{ route('admin.users.create') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg shadow-sm transition-all duration-200 flex items-center gap-1.5 sm:gap-2">
        <i class="fas fa-plus"></i>
        <span>Tambah Akun</span>
    </a>
@endsection

@section('content')
    <!-- ALERT MESSAGES -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle text-red-500 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- STATS CARDS (KELOMPOK USER) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- ADMIN -->
        <a href="{{ route('admin.users.index', array_filter(['role' => 'admin', 'search' => $search])) }}"
           class="bg-white rounded-2xl p-5 shadow-sm border flex items-center justify-between transition-all duration-200 hover:shadow-md {{ $role === 'admin' ? 'border-amber-400 ring-2 ring-amber-400/25 bg-amber-50/10' : 'border-slate-200/80 hover:border-amber-300' }}">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $counts['admin'] }} <span class="text-sm font-normal text-slate-400">User</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shrink-0">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
        </a>

        <!-- PETUGAS -->
        <a href="{{ route('admin.users.index', array_filter(['role' => 'petugas', 'search' => $search])) }}"
           class="bg-white rounded-2xl p-5 shadow-sm border flex items-center justify-between transition-all duration-200 hover:shadow-md {{ $role === 'petugas' ? 'border-blue-400 ring-2 ring-blue-400/25 bg-blue-50/10' : 'border-slate-200/80 hover:border-blue-300' }}">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Petugas</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $counts['petugas'] }} <span class="text-sm font-normal text-slate-400">User</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-id-badge text-xl"></i>
            </div>
        </a>

        <!-- PENGUNJUNG -->
        <a href="{{ route('admin.users.index', array_filter(['role' => 'pengunjung', 'search' => $search])) }}"
           class="bg-white rounded-2xl p-5 shadow-sm border flex items-center justify-between transition-all duration-200 hover:shadow-md {{ $role === 'pengunjung' ? 'border-emerald-400 ring-2 ring-emerald-400/25 bg-emerald-50/10' : 'border-slate-200/80 hover:border-emerald-300' }}">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengunjung</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $counts['pengunjung'] }} <span class="text-sm font-normal text-slate-400">User</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </a>

        <!-- TOTAL KOLEKSI USER -->
        <a href="{{ route('admin.users.index', array_filter(['role' => 'all', 'search' => $search])) }}"
           class="bg-white rounded-2xl p-5 shadow-sm border flex items-center justify-between transition-all duration-200 hover:shadow-md {{ $role === 'all' ? 'border-slate-700 ring-2 ring-slate-700/20 bg-slate-50/30' : 'border-slate-200/80 hover:border-slate-400' }}">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Koleksi User</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $counts['all'] }} <span class="text-sm font-normal text-slate-400">User</span></h3>
            </div>
            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 shrink-0">
                <i class="fas fa-users text-xl"></i>
            </div>
        </a>
    </div>

    <!-- FILTER TABS & SEARCH BAR -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 mb-6 overflow-hidden">
        <!-- ROLE TABS -->
        <div class="flex flex-wrap border-b border-slate-200 bg-slate-50/60 px-3 sm:px-4 pt-3 gap-2">
            <!-- TAB: SEMUA -->
            <a href="{{ route('admin.users.index', array_filter(['role' => 'all', 'search' => $search])) }}" 
               class="px-3.5 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-colors flex items-center gap-2 border-b-2 {{ $role === 'all' ? 'border-slate-900 text-slate-900 bg-white font-semibold shadow-sm' : 'border-transparent text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                <i class="fas fa-layer-group text-slate-500 text-xs"></i>
                <span>Semua</span>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $role === 'all' ? 'bg-slate-900 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $counts['all'] }}</span>
            </a>

            <!-- TAB: ADMIN -->
            <a href="{{ route('admin.users.index', array_filter(['role' => 'admin', 'search' => $search])) }}" 
               class="px-3.5 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-colors flex items-center gap-2 border-b-2 {{ $role === 'admin' ? 'border-amber-500 text-amber-800 bg-white font-semibold shadow-sm' : 'border-transparent text-slate-600 hover:text-amber-700 hover:bg-amber-50/50' }}">
                <i class="fas fa-shield-alt text-amber-500 text-xs"></i>
                <span>Admin</span>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $role === 'admin' ? 'bg-amber-500 text-white' : 'bg-amber-100 text-amber-800' }}">{{ $counts['admin'] }}</span>
            </a>

            <!-- TAB: PETUGAS -->
            <a href="{{ route('admin.users.index', array_filter(['role' => 'petugas', 'search' => $search])) }}" 
               class="px-3.5 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-colors flex items-center gap-2 border-b-2 {{ $role === 'petugas' ? 'border-blue-500 text-blue-800 bg-white font-semibold shadow-sm' : 'border-transparent text-slate-600 hover:text-blue-700 hover:bg-blue-50/50' }}">
                <i class="fas fa-id-badge text-blue-500 text-xs"></i>
                <span>Petugas</span>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $role === 'petugas' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-800' }}">{{ $counts['petugas'] }}</span>
            </a>

            <!-- TAB: PENGUNJUNG -->
            <a href="{{ route('admin.users.index', array_filter(['role' => 'pengunjung', 'search' => $search])) }}" 
               class="px-3.5 py-2 text-xs sm:text-sm font-medium rounded-t-lg transition-colors flex items-center gap-2 border-b-2 {{ $role === 'pengunjung' ? 'border-emerald-500 text-emerald-800 bg-white font-semibold shadow-sm' : 'border-transparent text-slate-600 hover:text-emerald-700 hover:bg-emerald-50/50' }}">
                <i class="fas fa-user-graduate text-emerald-500 text-xs"></i>
                <span>Pengunjung</span>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $role === 'pengunjung' ? 'bg-emerald-500 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $counts['pengunjung'] }}</span>
            </a>
        </div>

        <!-- SEARCH INPUT -->
        <div class="p-4 sm:p-5">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center">
                <!-- Keep selected role -->
                <input type="hidden" name="role" value="{{ $role }}">

                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-search text-sm"></i>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" 
                        placeholder="Cari berdasarkan nama, NPM, atau email..." 
                        class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5">
                        <i class="fas fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>

                    @if($search || $role !== 'all')
                        <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5" title="Reset filter">
                            <i class="fas fa-undo text-xs"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>

            <!-- ACTIVE FILTER INFO -->
            @if($search || $role !== 'all')
                <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                    <div class="flex items-center gap-2">
                        <span>Menampilkan filter:</span>
                        @if($role !== 'all')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-medium">
                                Kelompok: <strong class="capitalize">{{ $role }}</strong>
                            </span>
                        @endif
                        @if($search)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-medium">
                                Kata Kunci: "{{ $search }}"
                            </span>
                        @endif
                    </div>
                    <div>
                        Ditemukan <strong>{{ $users->total() }}</strong> pengguna
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- USERS TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider w-14 text-center">No</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Identitas / NPM</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Pengguna</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider hidden md:table-cell">Email</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">Kelompok / Role</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider hidden lg:table-cell">Hak Akses</th>
                            <th class="px-4 py-3.5 text-xs font-semibold text-slate-600 uppercase tracking-wider text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $index => $user)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- NO -->
                                <td class="px-4 py-3.5 text-xs sm:text-sm text-slate-500 text-center font-medium">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <!-- NPM / IDENTITAS -->
                                <td class="px-4 py-3.5">
                                    @if($user->npm)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                            <i class="fas fa-id-card text-slate-400 mr-1.5 text-[10px]"></i>
                                            {{ $user->npm }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-50 text-slate-400 italic">
                                            Staf Sistem
                                        </span>
                                    @endif
                                </td>

                                <!-- NAMA -->
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($user->role === 'admin')
                                            <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200 shadow-sm">
                                                <i class="fas fa-shield-alt text-sm"></i>
                                            </div>
                                        @elseif($user->role === 'petugas')
                                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 border border-blue-200 shadow-sm">
                                                <i class="fas fa-id-badge text-sm"></i>
                                            </div>
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-200 shadow-sm">
                                                <i class="fas fa-user text-sm"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-semibold text-slate-800 text-xs sm:text-sm block">{{ $user->name }}</span>
                                            <span class="text-[11px] text-slate-400 md:hidden">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- EMAIL -->
                                <td class="px-4 py-3.5 text-xs sm:text-sm text-slate-600 hidden md:table-cell">
                                    {{ $user->email }}
                                </td>

                                <!-- ROLE BADGE -->
                                <td class="px-4 py-3.5">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-xs rounded-full font-semibold">
                                            <i class="fas fa-shield-alt text-amber-500"></i> Admin
                                        </span>
                                    @elseif($user->role === 'petugas')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-xs rounded-full font-semibold">
                                            <i class="fas fa-id-badge text-blue-500"></i> Petugas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs rounded-full font-semibold">
                                            <i class="fas fa-user-graduate text-emerald-500"></i> Pengunjung
                                        </span>
                                    @endif
                                </td>

                                <!-- HAK AKSES -->
                                <td class="px-4 py-3.5 text-xs text-slate-500 hidden lg:table-cell">
                                    @if($user->role === 'admin')
                                        <span class="text-amber-800 font-medium">Akses Penuh Seluruh Sistem</span>
                                    @elseif($user->role === 'petugas')
                                        <span class="text-blue-800 font-medium">Scanner Barcode & Sirkulasi</span>
                                    @else
                                        <span class="text-emerald-800 font-medium">Katalog & Peminjaman Buku</span>
                                    @endif
                                </td>

                                <!-- AKSI -->
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-200 transition-all"
                                            title="Edit User">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition-all"
                                                    title="Hapus User"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                                                    <i class="fas fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                                <i class="fas fa-trash text-xs"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION -->
            <div class="px-4 py-3.5 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500">
                    Menampilkan <strong>{{ $users->firstItem() }}</strong> - <strong>{{ $users->lastItem() }}</strong> dari <strong>{{ $users->total() }}</strong> pengguna
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="p-8 sm:p-12 text-center">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 
                    {{ $role === 'admin' ? 'bg-amber-50 text-amber-500' : ($role === 'petugas' ? 'bg-blue-50 text-blue-500' : ($role === 'pengunjung' ? 'bg-emerald-50 text-emerald-500' : 'bg-slate-100 text-slate-400')) }}">
                    @if($role === 'admin')
                        <i class="fas fa-shield-alt text-2xl"></i>
                    @elseif($role === 'petugas')
                        <i class="fas fa-id-badge text-2xl"></i>
                    @elseif($role === 'pengunjung')
                        <i class="fas fa-user-graduate text-2xl"></i>
                    @else
                        <i class="fas fa-users text-2xl"></i>
                    @endif
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-1">
                    @if($role === 'admin')
                        Tidak Ada Akun Admin
                    @elseif($role === 'petugas')
                        Belum Ada Akun Petugas
                    @elseif($role === 'pengunjung')
                        Tidak Ada Pengunjung Ditemukan
                    @else
                        Tidak Ada Pengguna Ditemukan
                    @endif
                </h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-5">
                    @if($search)
                        Tidak ada pengguna yang cocok dengan pencarian "<strong>{{ $search }}</strong>".
                    @elseif($role === 'petugas')
                        Buat akun petugas baru agar staf dapat melakukan scan barcode dan sirkulasi peminjaman.
                    @else
                        Belum ada data untuk kategori ini.
                    @endif
                </p>
                @if($search || $role !== 'all')
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-slate-900 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span>Tampilkan Semua User</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
