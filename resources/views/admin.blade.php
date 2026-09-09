@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
    {{-- ALERT FLASH MESSAGES --}}
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-info-circle text-blue-500 text-base shrink-0"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle text-rose-500 text-base shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('warning'))
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-triangle text-amber-500 text-base shrink-0"></i>
            <span>{{ session('warning') }}</span>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- STAT CARDS (STYLE PERSIS BUKU BERANDA) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Peminjaman Aktif</p>
                                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ number_format($activeLoans) }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Users</p>
                                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalUsers) }} <span class="text-sm font-normal text-slate-400">User</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Terlambat</p>
                                <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($overdueLoans) }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Koleksi Buku</p>
                                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalBooks) }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
                            </div>
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- RECENT ACTIVITY -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                                <i class="fas fa-clock text-blue-500 mr-1 sm:mr-2"></i>Peminjaman Terbaru
                            </h3>
                            @if($recentLoans->count() > 0)
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach($recentLoans as $loan)
                                        <div class="flex items-center justify-between py-2 sm:py-3 border-b border-slate-100">
                                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                                    <i class="fas fa-user text-blue-500 text-xs sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $loan->user->name }}</p>
                                                    <p class="text-xs text-slate-500 truncate">{{ $loan->book->title }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                @if($loan->getActualStatus() === 'peminjaman')
                                                    <span class="text-xs text-amber-600 font-medium">Dipinjam</span>
                                                @elseif($loan->getActualStatus() === 'dikembalikan')
                                                    <span class="text-xs text-green-600 font-medium">Dikembalikan</span>
                                                @else
                                                    <span class="text-xs text-red-600 font-medium">Terlambat</span>
                                                @endif
                                                <p class="text-xs text-slate-400">{{ $loan->loan_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.loans.index') }}" class="text-xs sm:text-sm text-blue-500 hover:text-blue-600">
                                        Lihat semua peminjaman <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-6 sm:py-8">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-inbox text-slate-400 text-xl sm:text-2xl"></i>
                                    </div>
                                    <p class="text-sm sm:text-base text-slate-600 font-medium">Belum ada peminjaman</p>
                                    <p class="text-xs sm:text-sm text-slate-400">Peminjaman akan muncul di sini</p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-1 sm:mr-2"></i>Pinjaman Terlambat
                            </h3>
                            @if($overdueLoansList->count() > 0)
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach($overdueLoansList as $loan)
                                        @php
                                            $daysOverdue = $loan->getDaysLate();
                                        @endphp
                                        <div class="flex items-center justify-between py-2 sm:py-3 border-b border-slate-100">
                                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                                                    <i class="fas fa-exclamation-circle text-red-500 text-xs sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $loan->user->name }}</p>
                                                    <p class="text-xs text-slate-500 truncate">{{ $loan->book->title }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="text-xs text-red-600 font-medium">{{ $daysOverdue }} hari</span>
                                                <p class="text-xs text-slate-400">Jatuh tempo: {{ $loan->due_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.loans.index', ['status' => 'terlambat']) }}" class="text-xs sm:text-sm text-blue-500 hover:text-blue-600">
                                        Lihat semua keterlambatan <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-6 sm:py-8">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-check-circle text-green-500 text-xl sm:text-2xl"></i>
                                    </div>
                                    <p class="text-sm sm:text-base text-slate-600 font-medium">Tidak ada keterlambatan</p>
                                    <p class="text-xs sm:text-sm text-slate-400">Semua peminjaman dikembalikan tepat waktu</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- BORROWED & RETURNED BOOKS -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-4 sm:mt-6">
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                                <i class="fas fa-book-reader text-amber-500 mr-1 sm:mr-2"></i>Buku Sedang Dipinjam
                            </h3>
                            @if($borrowedBooks->count() > 0)
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach($borrowedBooks as $loan)
                                        <div class="flex items-center justify-between py-2 sm:py-3 border-b border-slate-100">
                                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                                    <i class="fas fa-book text-amber-500 text-xs sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $loan->book->title }}</p>
                                                    <p class="text-xs text-slate-500 truncate">{{ $loan->user->name }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="text-xs text-amber-600 font-medium">Dipinjam</span>
                                                <p class="text-xs text-slate-400">Jatuh tempo: {{ $loan->due_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.loans.index', ['status' => 'peminjaman']) }}" class="text-xs sm:text-sm text-blue-500 hover:text-blue-600">
                                        Lihat semua peminjaman aktif <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-6 sm:py-8">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-book text-slate-400 text-xl sm:text-2xl"></i>
                                    </div>
                                    <p class="text-sm sm:text-base text-slate-600 font-medium">Tidak ada buku yang dipinjam</p>
                                    <p class="text-xs sm:text-sm text-slate-400">Belum ada peminjaman aktif</p>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">
                                <i class="fas fa-check-circle text-green-500 mr-1 sm:mr-2"></i>Buku Sudah Dikembalikan
                            </h3>
                            @if($returnedBooks->count() > 0)
                                <div class="space-y-3 sm:space-y-4">
                                    @foreach($returnedBooks as $loan)
                                        <div class="flex items-center justify-between py-2 sm:py-3 border-b border-slate-100">
                                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                                    <i class="fas fa-check text-green-500 text-xs sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-medium text-slate-800 text-sm sm:text-base truncate">{{ $loan->book->title }}</p>
                                                    <p class="text-xs text-slate-500 truncate">{{ $loan->user->name }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="text-xs text-green-600 font-medium">Dikembalikan</span>
                                                <p class="text-xs text-slate-400">{{ $loan->return_date->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.loans.index', ['status' => 'dikembalikan']) }}" class="text-xs sm:text-sm text-blue-500 hover:text-blue-600">
                                        Lihat semua riwayat <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-6 sm:py-8">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-history text-slate-400 text-xl sm:text-2xl"></i>
                                    </div>
                                    <p class="text-sm sm:text-base text-slate-600 font-medium">Belum ada yang dikembalikan</p>
                                    <p class="text-xs sm:text-sm text-slate-400">Riwayat peminjaman akan muncul di sini</p>
                                </div>
                            @endif
                        </div>
                    </div>
@endsection

