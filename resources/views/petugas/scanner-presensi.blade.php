@extends('layouts.petugas')

@section('title', 'Presensi Pengunjung Hari Ini')
@section('subtitle', 'Daftar kehadiran anggota dan pengunjung perpustakaan hari ini (' . now()->translatedFormat('l, d F Y') . ')')

@section('content')

    {{-- TOP ACTION BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 bg-white p-4 rounded-xl shadow-sm border border-slate-200/80">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center font-bold text-lg">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Daftar Hadir Pengunjung Hari Ini</h3>
                <p class="text-xs text-slate-500">Seluruh anggota yang telah melakukan check-in pada hari ini</p>
            </div>
        </div>
        <div>
            <a href="{{ route('petugas.dashboard') }}"
               class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs font-bold rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                <i class="fas fa-qrcode"></i> Buka Scanner Barcode
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengunjung Hari Ini</p>
                <h3 class="text-2xl font-bold text-violet-600 mt-1">
                    {{ $todayAttendance }} <span class="text-sm font-normal text-slate-400">Orang</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 shrink-0">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Minggu Ini</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">
                    {{ $totalWeek }} <span class="text-sm font-normal text-slate-400">Pengunjung</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-calendar-week text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Bulan Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                    {{ $totalMonth }} <span class="text-sm font-normal text-slate-400">Pengunjung</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH BAR --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-4 mb-6">
        <form method="GET" action="{{ route('petugas.scanner.presensi') }}" class="flex flex-col sm:flex-row gap-3 items-center">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-3.5 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari berdasarkan nama anggota, NPM, atau prodi..."
                       class="w-full pl-9 pr-4 py-2 text-xs border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
            </div>
            <button type="submit"
                    class="w-full sm:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shrink-0">
                <i class="fas fa-search mr-1"></i> Cari
            </button>
            @if($search)
                <a href="{{ route('petugas.scanner.presensi') }}"
                   class="w-full sm:w-auto px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium rounded-xl transition-colors text-center shrink-0">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ATTENDANCE TABLE --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-800">Daftar Kehadiran Anggota</h3>
            <span class="px-2.5 py-1 bg-violet-100 text-violet-700 rounded-full font-bold text-xs">
                Total: {{ $attendances->total() }} Orang
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                    <tr>
                        <th class="px-4 py-3.5">No</th>
                        <th class="px-4 py-3.5">Anggota</th>
                        <th class="px-4 py-3.5">NPM</th>
                        <th class="px-4 py-3.5">Program Studi</th>
                        <th class="px-4 py-3.5">Jam Masuk</th>
                        <th class="px-4 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attendances as $index => $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-slate-400 font-mono">
                                {{ $attendances->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $log->user?->getAvatarUrl() }}" alt="{{ $log->user?->name }}"
                                         class="w-8 h-8 rounded-lg object-cover border border-slate-200">
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $log->user?->name ?? '-' }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $log->user?->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-slate-700 font-medium">
                                {{ $log->user?->npm ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $log->user?->prodi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg font-semibold inline-flex items-center gap-1 text-[11px]">
                                    <i class="fas fa-clock text-[10px]"></i> {{ $log->scanned_at ? $log->scanned_at->format('H:i') . ' WIB' : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-violet-100 text-violet-800 rounded-full font-bold text-[10px] inline-flex items-center gap-1">
                                    <i class="fas fa-check text-[9px]"></i> Hadir
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                <i class="fas fa-users text-3xl mb-2 text-slate-300 block"></i>
                                <p class="text-sm font-medium text-slate-600">
                                    {{ $search ? 'Tidak ada pengunjung yang sesuai pencarian.' : 'Belum ada pengunjung yang hadir hari ini.' }}
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    Scan kartu anggota digital di Scanner Barcode saat pengunjung memasuki perpustakaan.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($attendances->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

@endsection
