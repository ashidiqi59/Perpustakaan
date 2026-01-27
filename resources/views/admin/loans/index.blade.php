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
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-amber-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Peminjaman Aktif</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stats['active'] }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-hourglass-half text-amber-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-red-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Terlambat</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stats['overdue'] }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Dikembalikan</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stats['returned'] }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER -->
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                        <form action="{{ route('admin.loans.index') }}" method="GET" id="searchForm" class="space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cari Peminjam</label>
                                    <input type="text" name="search" placeholder="Nama atau NPM..." value="{{ request('search', '') }}"
                                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="w-full sm:w-40">
                                    <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Status</label>
                                    <select name="status" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Semua</option>
                                        <option value="peminjaman" {{ request('status') === 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    </select>
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
                                                    <div class="min-w-0">
                                                        <p class="font-medium text-slate-800 text-xs sm:text-sm truncate">{{ $loan->user->name }}</p>
                                                        <p class="text-xs text-slate-500">{{ $loan->user->npm }}</p>
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
                                                    @if($loan->getActualStatus() === 'peminjaman')
                                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                                                            Dipinjam
                                                        </span>
                                                    @elseif($loan->status === 'dikembalikan' && $loan->return_date && $loan->return_date->isAfter($loan->due_date))
                                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                                                            Terlambat
                                                        </span>
                                                    @elseif($loan->getActualStatus() === 'dikembalikan')
                                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                                            Kembali
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                                                            Terlambat
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
                                                        @if($loan->getActualStatus() !== 'dikembalikan')
                                                            <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="p-1.5 text-slate-600 hover:text-green-600 hover:bg-green-50 rounded transition-colors"
                                                                    title="Kembalikan"
                                                                    onclick="return confirm('Kembalikan buku ini?')">
                                                                    <i class="fas fa-undo text-xs"></i>
                                                                </button>
                                                            </form>
                                                        @endif
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
                            <div class="px-3 py-4 border-t border-slate-200 overflow-x-auto">
                                {{ $loans->links() }}
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

