@extends('layouts.admin')

@section('title', 'Dashboard Stok Buku')
@section('subtitle', 'Ringkasan koleksi dan kondisi stok buku perpustakaan')

@section('header-actions')
    <a href="{{ route('stok.books.create') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-500 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-plus"></i>
        <span class="hidden sm:inline">Tambah Buku</span>
        <span class="sm:hidden">Tambah</span>
    </a>
@endsection

@section('content')
    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            <i class="fas fa-check-circle text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Judul</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($totalBooks) }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-book-open text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Stok</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalStock) }} <span class="text-sm font-normal text-slate-400">Eksemplar</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-layer-group text-xl"></i>
            </div>
        </div>

        <a href="{{ route('stok.books.index', ['filter' => 'low']) }}"
           class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between hover:border-amber-300 hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Rendah</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $lowStockCount }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Stok ≤ 3 eksemplar</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </a>

        <a href="{{ route('stok.books.index', ['filter' => 'out']) }}"
           class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between hover:border-red-300 hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Habis</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $outOfStockCount }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Stok = 0</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
        </a>
    </div>

    {{-- MAIN PANELS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">

        {{-- ── Buku Stok Habis ── --}}
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-times-circle text-red-500"></i>
                Buku Stok Habis
                @if($outOfStockBooks->count() > 0)
                    <span class="text-xs font-bold bg-red-100 text-red-700 px-2 py-0.5 rounded-full">{{ $outOfStockBooks->count() }}</span>
                @endif
            </h3>

            @if($outOfStockBooks->count() > 0)
                <div class="space-y-1">
                    @foreach($outOfStockBooks->take(5) as $book)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($book->image)
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}"
                                         class="w-9 h-12 object-cover rounded shadow-sm shrink-0 border border-slate-200">
                                @else
                                    <div class="w-9 h-12 bg-slate-100 rounded flex items-center justify-center shrink-0">
                                        <i class="fas fa-book text-slate-300 text-xs"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 text-sm truncate">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $book->author ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 ml-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    <i class="fas fa-times-circle text-[9px]"></i> Habis
                                </span>
                                <a href="{{ route('stok.books.edit', $book) }}"
                                   class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-semibold">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link lihat selengkapnya --}}
                <div class="pt-3 mt-1 text-center">
                    <a href="{{ route('stok.books.index', ['filter' => 'out']) }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat semua stok habis →
                    </a>
                </div>
            @else
                <div class="py-10 text-center">
                    <i class="fas fa-check-circle text-emerald-400 text-3xl mb-2"></i>
                    <p class="text-sm text-slate-500 font-medium">Tidak ada buku yang stoknya habis 🎉</p>
                </div>
            @endif
        </div>

        {{-- ── Buku Stok Hampir Habis ── --}}
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                Stok Hampir Habis
                @if($lowStockBooks->count() > 0)
                    <span class="text-xs font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">{{ $lowStockBooks->count() }}</span>
                @endif
            </h3>

            @if($lowStockBooks->count() > 0)
                <div class="space-y-1">
                    @foreach($lowStockBooks->take(5) as $book)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($book->image)
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}"
                                         class="w-9 h-12 object-cover rounded shadow-sm shrink-0 border border-slate-200">
                                @else
                                    <div class="w-9 h-12 bg-slate-100 rounded flex items-center justify-center shrink-0">
                                        <i class="fas fa-book text-slate-300 text-xs"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 text-sm truncate">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $book->author ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 ml-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    <i class="fas fa-exclamation-circle text-[9px]"></i> {{ $book->stock }} eks
                                </span>
                                <a href="{{ route('stok.books.edit', $book) }}"
                                   class="text-xs text-blue-600 hover:text-blue-800 hover:underline font-semibold">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link lihat selengkapnya --}}
                <div class="pt-3 mt-1 text-center">
                    <a href="{{ route('stok.books.index', ['filter' => 'low']) }}"
                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat semua stok hampir habis →
                    </a>
                </div>
            @else
                <div class="py-10 text-center">
                    <i class="fas fa-check-circle text-emerald-400 text-3xl mb-2"></i>
                    <p class="text-sm text-slate-500 font-medium">Semua stok aman (> 3 eksemplar)</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Distribusi Kategori ── --}}
    @if($categoryStats->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
        <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-5 flex items-center gap-2">
            <i class="fas fa-chart-pie text-blue-500"></i>
            Distribusi Kategori
            <span class="text-xs font-normal text-slate-400 ml-1">Stok per kategori</span>
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            {{-- Donut Chart --}}
            <div class="flex justify-center items-center">
                <div class="relative" style="width:220px;height:220px;">
                    <canvas id="categoryDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-bold text-slate-800">{{ $totalStock }}</span>
                        <span class="text-xs text-slate-400">Total Stok</span>
                    </div>
                </div>
            </div>

            {{-- Bar list --}}
            <div class="space-y-3">
                @php $maxStock = $categoryStats->max('total_stock'); @endphp
                @foreach($categoryStats->take(7) as $i => $stat)
                    @php
                        $pct = $maxStock > 0 ? round(($stat->total_stock / $maxStock) * 100) : 0;
                        $colors = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-purple-500','bg-rose-500','bg-indigo-500','bg-cyan-500'];
                        $color  = $colors[$i % count($colors)];
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $color }} shrink-0"></span>
                                <span class="text-sm font-medium text-slate-700 truncate max-w-[140px]">{{ $stat->category }}</span>
                                <span class="text-xs text-slate-400">{{ $stat->total_titles }} judul</span>
                            </div>
                            <span class="text-sm font-semibold text-slate-600 shrink-0">{{ number_format($stat->total_stock) }} eks</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="{{ $color }} h-2 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach

                @if($categoryStats->count() > 7)
                    <p class="text-xs text-slate-400 text-center pt-1">+ {{ $categoryStats->count() - 7 }} kategori lainnya</p>
                @endif
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('categoryDonutChart');
    if (!ctx) return;

    var labels = @json($categoryStats->take(7)->pluck('category'));
    var data   = @json($categoryStats->take(7)->pluck('total_stock'));
    var colors = ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#6366f1','#06b6d4'];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString() + ' eks';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
