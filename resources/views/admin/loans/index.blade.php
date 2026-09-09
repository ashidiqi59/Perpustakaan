@extends('layouts.admin')

@section('title', 'Kelola Peminjaman')
@section('subtitle', 'Kelola data peminjaman buku')

@section('header-actions')
    <a href="{{ route('admin.loans.create') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-500 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-plus"></i>
        <span class="hidden sm:inline">Tambah Peminjaman</span>
        <span class="sm:hidden">Tambah</span>
    </a>
@endsection

@section('content')
                    <!-- ALERT MESSAGES -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- STATS CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Konfirmasi</p>
                                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['menunggu'] }} <span class="text-sm font-normal text-slate-400">Transaksi</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Peminjaman Aktif</p>
                                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['active'] }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                                <i class="fas fa-hourglass-half text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat</p>
                                <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $stats['overdue'] }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 shrink-0">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dikembalikan</p>
                                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['returned'] }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-4 sm:p-5 mb-6">
                        <form action="{{ route('admin.loans.index') }}" method="GET" id="searchForm" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3 items-end">
                                <div class="flex-1 w-full">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cari Peminjam</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class="fas fa-search text-sm"></i>
                                        </div>
                                        <input type="text" name="search" placeholder="Nama atau NPM..." value="{{ request('search', '') }}"
                                            class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50/30">
                                    </div>
                                </div>
                                <div class="w-full sm:w-52">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Status</label>
                                    <select name="status" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">Semua Status</option>
                                        <option value="menunggu_konfirmasi" {{ request('status') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                        <option value="peminjaman" {{ request('status') === 'peminjaman' ? 'selected' : '' }}>Peminjaman Aktif</option>
                                        <option value="menunggu_pengembalian" {{ request('status') === 'menunggu_pengembalian' ? 'selected' : '' }}>Menunggu Pengembalian</option>
                                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Hangus/Expired</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                                        <i class="fas fa-search text-xs"></i>
                                        <span>Cari</span>
                                    </button>
                                    @if(request('search') || (request('status') && request('status') !== ''))
                                        <a href="{{ route('admin.loans.index') }}" class="flex-1 sm:flex-none px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-1.5" title="Reset filter">
                                            <i class="fas fa-undo text-xs"></i>
                                            <span>Reset</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- LOANS TABLE -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($loans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">No</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Peminjam</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 hidden md:table-cell">Buku</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Tgl</th>
                                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600">Status</th>
                                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-600">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($loans as $index => $loan)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600">
                                                    {{ $loans->firstItem() + $index }}
                                                </td>
                                                <td class="px-3 py-3">
                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                        @if(!empty($loan->user->avatar))
                                                            <img src="{{ $loan->user->getAvatarUrl() }}" 
                                                                 alt="{{ $loan->user->name }}" 
                                                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($loan->user->name) }}&background=0F2854&color=ffffff&bold=true'"
                                                                 class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover shrink-0 border border-slate-200 shadow-2xs">
                                                        @else
                                                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 text-xs font-semibold">
                                                                {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div class="min-w-0">
                                                            <p class="font-medium text-slate-800 text-xs sm:text-sm truncate">{{ $loan->user->name }}</p>
                                                            <p class="text-xs text-slate-500">{{ $loan->user->npm ?: '-' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 hidden md:table-cell">
                                                    <div class="min-w-0">
                                                        <p class="font-medium text-slate-800 text-xs sm:text-sm truncate max-w-[150px]">{{ $loan->book->title }}</p>
                                                        <p class="text-xs text-slate-500 truncate max-w-[150px]">{{ $loan->book->author }}</p>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3 text-xs sm:text-sm text-slate-600">
                                                    <div>
                                                        <span class="font-medium">{{ $loan->loan_date->format('d/m') }}</span>
                                                        @if($loan->getActualStatus() === 'terlambat')
                                                            <p class="text-xs text-red-600 font-semibold">{{ $loan->getDaysLate() }} hari</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-3 py-3">
                                                    @php $actualStatus = $loan->getActualStatus(); @endphp
                                                    @if($actualStatus === 'menunggu_konfirmasi')
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium whitespace-nowrap">
                                                            <i class="fas fa-clock"></i> Menunggu
                                                        </span>
                                                    @elseif($actualStatus === 'peminjaman')
                                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                                                            Dipinjam
                                                        </span>
                                                    @elseif($actualStatus === 'menunggu_pengembalian')
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-medium whitespace-nowrap">
                                                            <i class="fas fa-undo"></i> Mau Kembali
                                                        </span>
                                                    @elseif($actualStatus === 'dikembalikan')
                                                        @if($loan->isReturnedLate())
                                                            <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full font-medium whitespace-nowrap">
                                                                Kembali (Terlambat)
                                                            </span>
                                                        @else
                                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium whitespace-nowrap">
                                                                Kembali
                                                            </span>
                                                        @endif
                                                    @elseif($actualStatus === 'terlambat')
                                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                                                            Terlambat
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs rounded-full font-medium">
                                                            Hangus
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-3">
                                                    <div class="flex items-center justify-center gap-1">
                                                        <a href="{{ route('admin.loans.show', $loan->id) }}"
                                                            class="p-1.5 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                                            title="Detail">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('admin.loans.edit', $loan->id) }}"
                                                            class="p-1.5 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded transition-colors"
                                                            title="Edit">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>
                                                        <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="p-1.5 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                                                title="Hapus"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                                <i class="fas fa-trash text-xs"></i>
                                                            </button>
                                                        </form>
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
                                    Menampilkan <strong>{{ $loans->firstItem() }}</strong> - <strong>{{ $loans->lastItem() }}</strong> dari <strong>{{ $loans->total() }}</strong> data peminjaman
                                </div>
                                @if($loans->hasPages())
                                    <div class="overflow-x-auto">
                                        {{ $loans->links() }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-6 sm:p-8 text-center">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-search text-slate-400 text-xl sm:text-2xl"></i>
                                </div>
                                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-2">Tidak ada Data</h3>
                                <p class="text-sm text-slate-500">
                                    @if(request('search') || (request('status') && request('status') !== ''))
                                        Tidak ada data yang sesuai dengan pencarian.
                                    @else
                                        Belum ada peminjaman yang dicatat.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
@endsection

@push('scripts')
<script>
    // Auto-submit search on change
    document.querySelector('select[name="status"]').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
</script>
@endpush

