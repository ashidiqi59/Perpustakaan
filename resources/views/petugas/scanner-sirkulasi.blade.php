@extends('layouts.petugas')

@section('title', 'Sirkulasi Buku Hari Ini')
@section('subtitle', 'Daftar peminjaman & pengembalian buku yang diproses hari ini (' . now()->translatedFormat('l, d F Y') . ')')

@section('content')

    {{-- TOP ACTION BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200/80">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-lg">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Laporan Sirkulasi Harian</h3>
                <p class="text-xs text-slate-500">Menampilkan seluruh transaksi peminjaman & pengembalian buku hari ini</p>
            </div>
        </div>
        <a href="{{ route('petugas.dashboard') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-slate-900 text-xs font-bold rounded-xl transition-all shadow-sm">
            <i class="fas fa-qrcode"></i> Buka Scanner Barcode
        </a>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dipinjam Hari Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $todayLoanScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dikembalikan Hari Ini</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $todayReturnScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-undo text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Pinjam</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $pendingLoans }} <span class="text-sm font-normal text-slate-400">Tiket</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Kembali</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $pendingReturns }} <span class="text-sm font-normal text-slate-400">Tiket</span></h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-undo-alt text-xl"></i>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT TABS --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">
        {{-- TAB HEADER --}}
        <div class="flex border-b border-slate-200 bg-slate-50/70 px-4 pt-3 gap-2 overflow-x-auto">
            <button onclick="switchTab('pinjam')" id="tab-btn-pinjam"
                class="px-4 py-2.5 text-xs font-bold rounded-t-xl transition-all border-b-2 border-emerald-600 bg-white text-emerald-700 shadow-xs flex items-center gap-2">
                <i class="fas fa-arrow-down text-emerald-600"></i>
                <span>Peminjaman Hari Ini</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800">{{ $todayLoanScans }}</span>
            </button>
            <button onclick="switchTab('kembali')" id="tab-btn-kembali"
                class="px-4 py-2.5 text-xs font-medium rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 hover:text-slate-900 hover:bg-white/50 flex items-center gap-2">
                <i class="fas fa-arrow-up text-blue-600"></i>
                <span>Pengembalian Hari Ini</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-100 text-blue-800">{{ $todayReturnScans }}</span>
            </button>
        </div>

        {{-- TAB 1: PEMINJAMAN HARI INI --}}
        <div id="tab-content-pinjam" class="p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5">No</th>
                            <th class="px-4 py-3.5">Peminjam</th>
                            <th class="px-4 py-3.5">NPM / Prodi</th>
                            <th class="px-4 py-3.5">Buku Dipinjam</th>
                            <th class="px-4 py-3.5">Jam Pinjam</th>
                            <th class="px-4 py-3.5">Tenggat Kembali</th>
                            <th class="px-4 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($todayLoans as $index => $loan)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $loan->user?->getAvatarUrl() }}" alt="{{ $loan->user?->name }}"
                                             class="w-7 h-7 rounded-lg object-cover border border-slate-200">
                                        <span class="font-bold text-slate-800">{{ $loan->user?->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-mono text-slate-700 font-medium">{{ $loan->user?->npm ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-[140px]">{{ $loan->user?->prodi ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-slate-800 line-clamp-1 max-w-xs">{{ $loan->book?->title ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $loan->book?->author ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-semibold inline-flex items-center gap-1 text-[11px]">
                                        <i class="fas fa-clock text-[10px]"></i>
                                        {{ $loan->loan_barcode_scanned_at ? $loan->loan_barcode_scanned_at->format('H:i') . ' WIB' : '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-slate-600">
                                    {{ $loan->due_date ? $loan->due_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($loan->status === 'dikembalikan')
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full font-semibold text-[11px]">Sudah Kembali</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-semibold text-[11px]">Sedang Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">
                                    <i class="fas fa-book-open text-3xl mb-2 text-slate-300 block"></i>
                                    <p class="text-sm font-medium text-slate-600">Belum ada peminjaman buku hari ini.</p>
                                    <p class="text-xs text-slate-400 mt-1">Scan barcode <strong class="font-mono text-emerald-600">PINJAM-</strong> di Scanner Barcode untuk menyerahkan buku ke anggota.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 2: PENGEMBALIAN HARI INI --}}
        <div id="tab-content-kembali" class="p-0 hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <tr>
                            <th class="px-4 py-3.5">No</th>
                            <th class="px-4 py-3.5">Pengembali</th>
                            <th class="px-4 py-3.5">NPM / Prodi</th>
                            <th class="px-4 py-3.5">Buku Dikembalikan</th>
                            <th class="px-4 py-3.5">Jam Kembali</th>
                            <th class="px-4 py-3.5">Status Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($todayReturns as $index => $loan)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $loan->user?->getAvatarUrl() }}" alt="{{ $loan->user?->name }}"
                                             class="w-7 h-7 rounded-lg object-cover border border-slate-200">
                                        <span class="font-bold text-slate-800">{{ $loan->user?->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-mono text-slate-700 font-medium">{{ $loan->user?->npm ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-[140px]">{{ $loan->user?->prodi ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-slate-800 line-clamp-1 max-w-xs">{{ $loan->book?->title ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $loan->book?->author ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-semibold inline-flex items-center gap-1 text-[11px]">
                                        <i class="fas fa-clock text-[10px]"></i>
                                        {{ $loan->return_barcode_scanned_at ? $loan->return_barcode_scanned_at->format('H:i') . ' WIB' : '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($loan->due_date && $loan->return_date && $loan->return_date > $loan->due_date)
                                        <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full font-bold text-[11px]">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-bold text-[11px]">Tepat Waktu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">
                                    <i class="fas fa-undo text-3xl mb-2 text-slate-300 block"></i>
                                    <p class="text-sm font-medium text-slate-600">Belum ada buku yang dikembalikan hari ini.</p>
                                    <p class="text-xs text-slate-400 mt-1">Scan barcode <strong class="font-mono text-blue-600">KEMBALI-</strong> di Scanner Barcode saat anggota mengembalikan buku.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function switchTab(tab) {
    const btnPinjam = document.getElementById('tab-btn-pinjam');
    const btnKembali = document.getElementById('tab-btn-kembali');
    const contentPinjam = document.getElementById('tab-content-pinjam');
    const contentKembali = document.getElementById('tab-content-kembali');

    if (tab === 'pinjam') {
        btnPinjam.className = "px-4 py-2.5 text-xs font-bold rounded-t-xl transition-all border-b-2 border-emerald-600 bg-white text-emerald-700 shadow-xs flex items-center gap-2";
        btnKembali.className = "px-4 py-2.5 text-xs font-medium rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 hover:text-slate-900 hover:bg-white/50 flex items-center gap-2";
        contentPinjam.classList.remove('hidden');
        contentKembali.classList.add('hidden');
    } else {
        btnKembali.className = "px-4 py-2.5 text-xs font-bold rounded-t-xl transition-all border-b-2 border-blue-600 bg-white text-blue-700 shadow-xs flex items-center gap-2";
        btnPinjam.className = "px-4 py-2.5 text-xs font-medium rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 hover:text-slate-900 hover:bg-white/50 flex items-center gap-2";
        contentKembali.classList.remove('hidden');
        contentPinjam.classList.add('hidden');
    }
}
</script>
@endpush
