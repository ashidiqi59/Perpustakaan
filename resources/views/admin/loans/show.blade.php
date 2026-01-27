@extends('layouts.admin')

@section('title', 'Detail Peminjaman')
@section('subtitle', 'Informasi lengkap peminjaman')

@section('header-actions')
    <a href="{{ route('admin.loans.edit', $loan->id) }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-amber-500 text-white text-xs sm:text-sm rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-edit"></i>
        <span class="hidden sm:inline">Edit</span>
    </a>
    <a href="{{ route('admin.loans.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
                    <div class="space-y-4 sm:space-y-6 max-w-4xl mx-auto">
                        <!-- STATUS BADGE -->
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-2">Status Peminjaman</h3>
                                    @if($loan->getActualStatus() === 'peminjaman')
                                        <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-amber-100 text-amber-700 rounded-full font-medium text-sm">
                                            <i class="fas fa-hourglass-half mr-1 sm:mr-2"></i>Peminjaman Aktif
                                        </span>
                                    @elseif($loan->getActualStatus() === 'dikembalikan')
                                        <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-100 text-green-700 rounded-full font-medium text-sm">
                                            <i class="fas fa-check-circle mr-1 sm:mr-2"></i>Sudah Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-red-100 text-red-700 rounded-full font-medium text-sm">
                                            <i class="fas fa-exclamation-circle mr-1 sm:mr-2"></i>Terlambat
                                        </span>
                                    @endif
                                </div>
                                @if($loan->getActualStatus() === 'terlambat')
                                    <div class="text-left sm:text-right">
                                        <p class="text-red-600 font-semibold text-lg">{{ $loan->getDaysLate() }} hari terlambat</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- PEMINJAM INFO -->
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Informasi Peminjam</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="border-l-4 border-blue-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Nama</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->user->name }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">NPM</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->user->npm }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Email</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ $loan->user->email }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Role</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ ucfirst($loan->user->role) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- BUKU INFO -->
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Informasi Buku</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center justify-center sm:justify-start">
                                    @if($loan->book->image)
                                        <img src="{{ asset($loan->book->image) }}" alt="{{ $loan->book->title }}"
                                            class="w-24 h-32 sm:w-28 sm:h-40 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-24 h-32 sm:w-28 sm:h-40 bg-slate-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-book text-slate-400 text-3xl sm:text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-3">
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">Judul</p>
                                        <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ $loan->book->title }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">Penulis</p>
                                        <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ $loan->book->author }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">ISBN</p>
                                        <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->book->isbn }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">Penerbit</p>
                                        <p class="font-semibold text-slate-800 text-sm sm:text-base truncate">{{ $loan->book->publisher }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TANGGAL & DURASI -->
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Tanggal & Durasi</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="border-l-4 border-purple-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Tgl Peminjaman</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->loan_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $loan->loan_date->format('l') }}</p>
                                </div>
                                <div class="border-l-4 border-purple-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Tgl Tenggat</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->due_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $loan->due_date->format('l') }}</p>
                                </div>
                                <div class="border-l-4 border-purple-500 pl-3 sm:pl-4">
                                    <p class="text-xs sm:text-sm text-slate-500 mb-1">Durasi</p>
                                    <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->loan_date->diffInDays($loan->due_date) }} hari</p>
                                    <p class="text-xs text-slate-500 mt-1">Standar</p>
                                </div>
                            </div>
                        </div>

                        <!-- PENGEMBALIAN -->
                        @if($loan->return_date)
                            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Informasi Pengembalian</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">Tgl Dikembalikan</p>
                                        <p class="font-semibold text-slate-800 text-sm sm:text-base">{{ $loan->return_date->format('d/m/Y') }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $loan->return_date->format('l') }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-3 sm:pl-4">
                                        <p class="text-xs sm:text-sm text-slate-500 mb-1">Status</p>
                                        @if($loan->return_date->isAfter($loan->due_date))
                                            <p class="font-semibold text-red-600 text-sm sm:text-base">Terlambat</p>
                                            <p class="text-xs text-red-500 mt-1">{{ $loan->return_date->diffInDays($loan->due_date) }} hari setelah tenggat</p>
                                        @else
                                            <p class="font-semibold text-green-600 text-sm sm:text-base">Tepat Waktu</p>
                                            <p class="text-xs text-green-500 mt-1">{{ $loan->due_date->diffInDays($loan->return_date) }} hari sebelum tenggat</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- CATATAN -->
                        @if($loan->notes)
                            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                                <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-3 sm:mb-4">Catatan</h3>
                                <div class="bg-slate-50 p-3 sm:p-4 rounded-lg">
                                    <p class="text-slate-700 text-sm">{{ $loan->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- ACTIONS -->
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <a href="{{ route('admin.loans.edit', $loan->id) }}" class="flex-1 px-4 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-medium text-sm text-center">
                                <i class="fas fa-edit mr-2"></i>Edit Peminjaman
                            </a>
                            @if($loan->getActualStatus() !== 'dikembalikan')
                                <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="w-full px-4 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium text-sm" onclick="return confirm('Kembalikan buku ini?')">
                                        <i class="fas fa-undo mr-2"></i>Kembalikan
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.loans.index') }}" class="flex-1 px-4 py-2.5 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors font-medium text-sm text-center">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>
@endsection

