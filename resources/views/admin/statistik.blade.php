@extends('layouts.admin')

@section('title', 'Statistik Perpustakaan')
@section('subtitle', 'Visualisasi data & analitik sistem perpustakaan')

@section('content')
{{-- ════════════════════════════════════════
     RINGKASAN STAT CARDS
     ════════════════════════════════════════ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Koleksi</p>
            <h3 class="text-xl sm:text-2xl font-bold text-blue-600 mt-1">{{ number_format($totalBooks) }} <span class="text-xs font-normal text-slate-400">Judul</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
            <i class="fas fa-book text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Anggota</p>
            <h3 class="text-xl sm:text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalUsers) }} <span class="text-xs font-normal text-slate-400">User</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
            <i class="fas fa-users text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Peminjaman</p>
            <h3 class="text-xl sm:text-2xl font-bold text-amber-500 mt-1">{{ number_format($totalLoans) }} <span class="text-xs font-normal text-slate-400">Transaksi</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
            <i class="fas fa-clipboard-list text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kunjungan</p>
            <h3 class="text-xl sm:text-2xl font-bold text-purple-600 mt-1">{{ number_format($totalAttendance) }} <span class="text-xs font-normal text-slate-400">Scan</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 shrink-0">
            <i class="fas fa-door-open text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Peminjaman Aktif</p>
            <h3 class="text-xl sm:text-2xl font-bold text-indigo-600 mt-1">{{ number_format($activeLoans) }} <span class="text-xs font-normal text-slate-400">Buku</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
            <i class="fas fa-clock text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat</p>
            <h3 class="text-xl sm:text-2xl font-bold text-rose-600 mt-1">{{ number_format($overdueLoans) }} <span class="text-xs font-normal text-slate-400">Buku</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 shrink-0">
            <i class="fas fa-exclamation-triangle text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Rendah</p>
            <h3 class="text-xl sm:text-2xl font-bold text-amber-500 mt-1">{{ number_format($lowStockCount) }} <span class="text-xs font-normal text-slate-400">Judul</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
            <i class="fas fa-layer-group text-lg sm:text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
        <div>
            <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Habis</p>
            <h3 class="text-xl sm:text-2xl font-bold text-red-600 mt-1">{{ number_format($outOfStockCount) }} <span class="text-xs font-normal text-slate-400">Judul</span></h3>
        </div>
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shrink-0">
            <i class="fas fa-times-circle text-lg sm:text-xl"></i>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     ROW 1: Tren Peminjaman + Tren Kunjungan
     ════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">

    {{-- Tren Peminjaman --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-500"></i> Tren Peminjaman
            </h3>
            <span class="text-xs text-slate-400">12 bulan terakhir</span>
        </div>
        <canvas id="loanTrendChart" height="180"></canvas>
    </div>

    {{-- Tren Kunjungan --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-chart-area text-purple-500"></i> Tren Kunjungan
            </h3>
            <span class="text-xs text-slate-400">12 bulan terakhir</span>
        </div>
        <canvas id="attendanceTrendChart" height="180"></canvas>
    </div>
</div>

{{-- ════════════════════════════════════════
     ROW 2: Status Peminjaman + Kondisi Stok + User Baru
     ════════════════════════════════════════ --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6">

    {{-- Status Peminjaman (Donut) --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-amber-500"></i> Status Peminjaman
        </h3>
        <div class="flex justify-center">
            <canvas id="loanStatusChart" width="180" height="180"></canvas>
        </div>
        <div class="mt-4 space-y-1.5">
            @php
                $statusColors = [
                    'dikembalikan'         => ['bg-emerald-400','Dikembalikan'],
                    'peminjaman'           => ['bg-blue-400','Dipinjam'],
                    'terlambat'            => ['bg-rose-400','Terlambat'],
                    'menunggu_konfirmasi'  => ['bg-amber-400','Menunggu Konfirmasi'],
                    'menunggu_pengembalian'=> ['bg-indigo-400','Mau Dikembalikan'],
                    'expired'              => ['bg-slate-400','Expired'],
                ];
            @endphp
            @foreach($loanStatusData as $status => $count)
                @php [$colorClass, $label] = $statusColors[$status] ?? ['bg-slate-300', $status]; @endphp
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $colorClass }}"></span>
                        <span class="text-slate-600">{{ $label }}</span>
                    </div>
                    <span class="font-semibold text-slate-800">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Kondisi Stok (Donut) --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-boxes text-emerald-500"></i> Kondisi Stok
        </h3>
        <div class="flex justify-center">
            <canvas id="stockStatusChart" width="180" height="180"></canvas>
        </div>
        <div class="mt-4 space-y-1.5">
            @php $stockColors = ['bg-emerald-400','bg-amber-400','bg-red-400']; $si = 0; @endphp
            @foreach($stockStatus as $label => $count)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $stockColors[$si] }}"></span>
                        <span class="text-slate-600">{{ $label }}</span>
                    </div>
                    <span class="font-semibold text-slate-800">{{ $count }}</span>
                </div>
                @php $si++; @endphp
            @endforeach
        </div>
    </div>

    {{-- Pengguna Baru per Bulan --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                <i class="fas fa-user-plus text-emerald-500"></i> Anggota Baru
            </h3>
            <span class="text-xs text-slate-400">12 bulan</span>
        </div>
        <canvas id="userTrendChart" height="180"></canvas>
    </div>
</div>

{{-- ════════════════════════════════════════
     ROW 3: Distribusi Kategori + Top Buku
     ════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

    {{-- Distribusi Kategori (Horizontal Bar) --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-tags text-blue-500"></i> Distribusi Kategori Buku
        </h3>
        <canvas id="categoryChart" height="220"></canvas>
    </div>

    {{-- Top 10 Buku Dipinjam (Horizontal Bar) --}}
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h3 class="text-base font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-fire text-rose-500"></i> Top Buku Paling Dipinjam
        </h3>
        @if($topBooks->count() > 0)
            <canvas id="topBooksChart" height="220"></canvas>
        @else
            <div class="flex flex-col items-center justify-center h-40 text-slate-400">
                <i class="fas fa-chart-bar text-4xl mb-2"></i>
                <p class="text-sm">Belum ada data peminjaman</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Palette ──────────────────────────────────────────────────────
    const palette = ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#6366f1','#06b6d4','#f97316','#14b8a6','#ec4899'];
    const gridColor = 'rgba(148,163,184,0.15)';
    const fontColor = '#64748b';

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = fontColor;

    // ── 1. Tren Peminjaman (Line) ────────────────────────────────────
    new Chart(document.getElementById('loanTrendChart'), {
        type: 'line',
        data: {
            labels: @json($loanTrend->pluck('label')),
            datasets: [{
                label: 'Peminjaman',
                data: @json($loanTrend->pluck('count')),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: gridColor } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── 2. Tren Kunjungan (Line Area) ────────────────────────────────
    new Chart(document.getElementById('attendanceTrendChart'), {
        type: 'line',
        data: {
            labels: @json($attendanceTrend->pluck('label')),
            datasets: [{
                label: 'Kunjungan',
                data: @json($attendanceTrend->pluck('count')),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: gridColor } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── 3. Status Peminjaman (Donut) ─────────────────────────────────
    @php
        $statusMap = ['dikembalikan'=>'Dikembalikan','peminjaman'=>'Dipinjam','terlambat'=>'Terlambat','menunggu_konfirmasi'=>'Menunggu Konfirmasi','menunggu_pengembalian'=>'Mau Dikembalikan','expired'=>'Expired'];
        $statusChartColors = ['dikembalikan'=>'#10b981','peminjaman'=>'#3b82f6','terlambat'=>'#ef4444','menunggu_konfirmasi'=>'#f59e0b','menunggu_pengembalian'=>'#6366f1','expired'=>'#94a3b8'];
        $statusLabels = $loanStatusData->keys()->map(fn($k) => $statusMap[$k] ?? $k);
        $statusColors = $loanStatusData->keys()->map(fn($k) => $statusChartColors[$k] ?? '#94a3b8');
    @endphp
    new Chart(document.getElementById('loanStatusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels->values()),
            datasets: [{
                data: @json($loanStatusData->values()),
                backgroundColor: @json($statusColors->values()),
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 5,
            }]
        },
        options: {
            responsive: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

    // ── 4. Kondisi Stok (Donut) ──────────────────────────────────────
    new Chart(document.getElementById('stockStatusChart'), {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($stockStatus)),
            datasets: [{
                data: @json(array_values($stockStatus)),
                backgroundColor: ['#10b981','#f59e0b','#ef4444'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 5,
            }]
        },
        options: {
            responsive: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

    // ── 5. Anggota Baru per Bulan (Bar) ─────────────────────────────
    new Chart(document.getElementById('userTrendChart'), {
        type: 'bar',
        data: {
            labels: @json($userTrend->pluck('label')),
            datasets: [{
                label: 'Anggota Baru',
                data: @json($userTrend->pluck('count')),
                backgroundColor: 'rgba(16,185,129,0.75)',
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: gridColor } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── 6. Distribusi Kategori (Horizontal Bar) ──────────────────────
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: @json($categoryStats->pluck('category')),
            datasets: [
                {
                    label: 'Judul',
                    data: @json($categoryStats->pluck('total_titles')),
                    backgroundColor: 'rgba(59,130,246,0.7)',
                    borderRadius: 4,
                },
                {
                    label: 'Stok (eks)',
                    data: @json($categoryStats->pluck('total_stock')),
                    backgroundColor: 'rgba(16,185,129,0.7)',
                    borderRadius: 4,
                }
            ]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } } },
            scales: {
                x: { beginAtZero: true, grid: { color: gridColor } },
                y: { grid: { display: false } }
            }
        }
    });

    // ── 7. Top Buku (Horizontal Bar) ─────────────────────────────────
    @if($topBooks->count() > 0)
    const topLoansData = @json($topBooks->pluck('total_loans'));
    new Chart(document.getElementById('topBooksChart'), {
        type: 'bar',
        data: {
            labels: @json($topBooks->map(fn($b) => strlen($b->title) > 25 ? substr($b->title, 0, 25).'…' : $b->title)),
            datasets: [{
                label: 'Dipinjam',
                data: topLoansData,
                backgroundColor: topLoansData.map((_, i) => palette[i % palette.length]),
                borderRadius: 4,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: gridColor } },
                y: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
    @endif

});
</script>
@endpush
