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
    @if(session('error'))
        <div class="mb-4 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl">
            <i class="fas fa-exclamation-circle text-rose-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total Judul --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Judul</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($totalBooks) }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                <i class="fas fa-book-open text-xl"></i>
            </div>
        </div>

        {{-- Total Stok --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Stok</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalStock) }} <span class="text-sm font-normal text-slate-400">Eksemplar</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-layer-group text-xl"></i>
            </div>
        </div>

        {{-- Stok Rendah --}}
        <a href="{{ route('stok.books.index', ['filter' => 'low']) }}" class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between hover:border-amber-300 hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Rendah</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $lowStockCount }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Stok ≤ 3 eksemplar</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </a>

        {{-- Stok Habis --}}
        <a href="{{ route('stok.books.index', ['filter' => 'out']) }}" class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between hover:border-rose-300 hover:shadow-md transition-all">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Habis</p>
                <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $outOfStockCount }} <span class="text-sm font-normal text-slate-400">Judul</span></h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Stok = 0</p>
            </div>
            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        {{-- ── Buku Stok Habis ── --}}
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-times-circle text-rose-500 mr-2"></i>Buku Stok Habis
                @if($outOfStockBooks->count() > 0)
                    <span class="ml-2 text-xs font-bold bg-rose-100 text-rose-700 px-2 py-0.5 rounded-full">{{ $outOfStockBooks->count() }}</span>
                @endif
            </h3>

            @if($outOfStockBooks->count() > 0)
                <div class="space-y-3">
                    @foreach($outOfStockBooks->take(5) as $book)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($book->image)
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="w-9 h-12 object-cover rounded-md border border-slate-200 shrink-0">
                                @else
                                    <div class="w-9 h-12 bg-slate-100 rounded-md flex items-center justify-center shrink-0">
                                        <i class="fas fa-book text-slate-300"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 text-sm truncate">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $book->author ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700 border border-rose-200">
                                    Habis
                                </span>
                                <a href="{{ route('stok.books.edit', $book) }}" class="text-xs text-blue-600 hover:underline font-medium">Edit</a>
                            </div>
                        </div>
                    @endforeach
                    @if($outOfStockBooks->count() > 5)
                        <div class="pt-1 text-center">
                            <a href="{{ route('stok.books.index', ['filter' => 'out']) }}" class="text-xs text-blue-600 hover:underline font-medium">
                                Lihat {{ $outOfStockBooks->count() - 5 }} buku lainnya →
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="py-8 text-center">
                    <i class="fas fa-check-circle text-emerald-400 text-3xl mb-2"></i>
                    <p class="text-sm text-slate-500 font-medium">Tidak ada buku yang stoknya habis</p>
                </div>
            @endif
        </div>

        {{-- ── Buku Stok Rendah & Distribusi ── --}}
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                <i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>Stok Hampir Habis
                @if($lowStockBooks->count() > 0)
                    <span class="ml-2 text-xs font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">{{ $lowStockBooks->count() }}</span>
                @endif
            </h3>

            @if($lowStockBooks->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockBooks->take(5) as $book)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100">
                            <div class="flex items-center gap-3 min-w-0">
                                @if($book->image)
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="w-9 h-12 object-cover rounded-md border border-slate-200 shrink-0">
                                @else
                                    <div class="w-9 h-12 bg-slate-100 rounded-md flex items-center justify-center shrink-0">
                                        <i class="fas fa-book text-slate-300"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 text-sm truncate">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $book->author ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    {{ $book->stock }} eks
                                </span>
                                <a href="{{ route('stok.books.edit', $book) }}" class="text-xs text-blue-600 hover:underline font-medium">Edit</a>
                            </div>
                        </div>
                    @endforeach
                    @if($lowStockBooks->count() > 5)
                        <div class="pt-1 text-center">
                            <a href="{{ route('stok.books.index', ['filter' => 'low']) }}" class="text-xs text-blue-600 hover:underline font-medium">
                                Lihat {{ $lowStockBooks->count() - 5 }} buku lainnya →
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="py-8 text-center">
                    <i class="fas fa-check-circle text-emerald-400 text-3xl mb-2"></i>
                    <p class="text-sm text-slate-500 font-medium">Semua stok aman (> 3 eksemplar)</p>
                </div>
            @endif

            {{-- Distribusi Kategori --}}
            @if($categoryStats->count() > 0)
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <h4 class="text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-tags text-slate-400 mr-1"></i> Distribusi Kategori
                    </h4>
                    <div class="space-y-2">
                        @php $maxStock = $categoryStats->max('total_stock'); @endphp
                        @foreach($categoryStats->take(5) as $stat)
                            @php $pct = $maxStock > 0 ? round(($stat->total_stock / $maxStock) * 100) : 0; @endphp
                            <div>
                                <div class="flex justify-between text-xs mb-0.5">
                                    <span class="font-medium text-slate-700 truncate max-w-[150px]">{{ $stat->category }}</span>
                                    <span class="text-slate-500 shrink-0 ml-2">{{ $stat->total_stock }} eks</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
