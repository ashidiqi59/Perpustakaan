@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
                    <!-- STAT CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-blue-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Total Buku</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ number_format($totalBooks) }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-book text-blue-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Total Users</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ number_format($totalUsers) }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-users text-green-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-amber-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Peminjaman Aktif</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ number_format($activeLoans) }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-hand-holding text-amber-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-red-500">
                            <div class="flex justify-between items-center">
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm text-slate-500">Terlambat</p>
                                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ number_format($overdueLoans) }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-lg sm:text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QUICK ACTIONS -->
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <a href="{{ route('admin.books.create') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-500 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-plus mr-1 sm:mr-2"></i>Tambah Buku
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-green-500 text-white text-xs sm:text-sm rounded-lg hover:bg-green-600 transition-colors">
                                <i class="fas fa-user-plus mr-1 sm:mr-2"></i>Kelola User
                            </a>
                            <a href="{{ route('admin.loans.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-purple-500 text-white text-xs sm:text-sm rounded-lg hover:bg-purple-600 transition-colors">
                                <i class="fas fa-list mr-1 sm:mr-2"></i>Kelola Peminjaman
                            </a>
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

