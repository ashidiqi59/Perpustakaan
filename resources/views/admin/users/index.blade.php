@extends('layouts.admin')

@section('title', 'Kelola Users')
@section('subtitle', 'Kelola data user perpustakaan')

@section('content')
                    <!-- ALERT MESSAGES -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- SEARCH -->
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                        <form action="{{ route('admin.users.index') }}" method="GET" id="searchForm" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cari User</label>
                                    <input type="text" name="search" value="{{ $search }}" placeholder="Nama atau NPM..." 
                                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            @if($search)
                                <div class="flex justify-end">
                                    <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 bg-slate-500 text-white text-xs rounded-lg hover:bg-slate-600 transition-colors flex items-center">
                                        <i class="fas fa-times mr-1"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- USERS TABLE -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($users->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">No</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">NPM</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Nama</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 hidden md:table-cell">Email</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Role</th>
                                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-600">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($users as $index => $user)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600">
                                                    {{ $users->firstItem() + $index }}
                                                </td>
                                                <td class="px-3 py-3">
                                                    <span class="font-medium text-slate-800 text-xs sm:text-sm">{{ $user->npm }}</span>
                                                </td>
                                                <td class="px-3 py-3">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                                            <i class="fas fa-user text-blue-500 text-xs"></i>
                                                        </div>
                                                        <span class="font-medium text-slate-800 text-xs sm:text-sm truncate max-w-[100px] sm:max-w-none">{{ $user->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600 hidden md:table-cell truncate max-w-[150px]">{{ $user->email }}</td>
                                                <td class="px-3 py-3">
                                                    @if($user->role === 'admin')
                                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                                                            Admin
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                                            Pengunjung
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-3">
                                                    <div class="flex items-center justify-center gap-1">
                                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                            class="p-1.5 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded transition-colors"
                                                            title="Edit">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>
                                                        @if($user->id !== auth()->id())
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                    class="p-1.5 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                                    title="Hapus"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                                                                    <i class="fas fa-trash text-xs"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="p-1.5 text-slate-300 cursor-not-allowed" title="Tidak bisa menghapus diri sendiri">
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
                            <div class="px-3 py-4 border-t border-slate-200 overflow-x-auto">
                                {{ $users->appends(['search' => $search])->links() }}
                            </div>
                        @else
                            <div class="p-6 sm:p-8 text-center">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-slate-400 text-xl sm:text-2xl"></i>
                                </div>
                                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-2">Tidak ada user</h3>
                                <p class="text-sm text-slate-500">
                                    {{ $search ? 'Tidak ada user yang sesuai dengan pencarian.' : 'Belum ada user yang terdaftar.' }}
                                </p>
                            </div>
                        @endif
                    </div>
@endsection

