@extends('layouts.admin')

@section('title', 'Edit Peminjaman')
@section('subtitle', 'Perbarui data peminjaman')

@section('header-actions')
    <a href="{{ route('admin.loans.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                            @if($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>Peminjam
                                    </label>
                                    <select name="user_id" disabled
                                        class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed">
                                        <option value="{{ $loan->user->id }}">
                                            {{ $loan->user->name }} ({{ $loan->user->npm }})
                                        </option>
                                    </select>
                                    <p class="text-xs text-slate-500 mt-1">Peminjam tidak dapat diubah</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-book mr-2"></i>Buku
                                    </label>
                                    <select name="book_id" disabled
                                        class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed">
                                        <option value="{{ $loan->book->id }}">
                                            {{ $loan->book->title }} by {{ $loan->book->author }}
                                        </option>
                                    </select>
                                    <p class="text-xs text-slate-500 mt-1">Buku tidak dapat diubah</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-2"></i>Tgl Pinjam
                                        </label>
                                        <input type="date" name="loan_date" required value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('loan_date') border-red-500 @enderror">
                                        @error('loan_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-check mr-2"></i>Tgl Tenggat
                                        </label>
                                        <input type="date" name="due_date" required value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                                        @error('due_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-undo mr-2"></i>Tgl Pengembalian
                                    </label>
                                    <input type="date" name="return_date" value="{{ old('return_date', $loan->return_date?->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('return_date') border-red-500 @enderror">
                                    @error('return_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-500 mt-1">Kosongkan jika belum dikembalikan</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-flag mr-2"></i>Status
                                    </label>
                                    <div id="status-preview-box" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50 text-slate-600 text-sm">
                                        @if($loan->return_date)
                                            @if($loan->isReturnedLate())
                                                <span class="text-amber-700 font-medium flex items-center gap-2">
                                                    <i class="fas fa-exclamation-triangle text-amber-600"></i> Dikembalikan (Terlambat {{ $loan->getDaysLate() }} hari)
                                                </span>
                                            @else
                                                <span class="text-green-700 font-medium flex items-center gap-2">
                                                    <i class="fas fa-check-circle text-green-600"></i> Dikembalikan (Tepat Waktu)
                                                </span>
                                            @endif
                                        @elseif($loan->getActualStatus() === 'terlambat')
                                            <span class="text-red-700 font-medium flex items-center gap-2">
                                                <i class="fas fa-exclamation-circle text-red-600"></i> Terlambat (Belum Dikembalikan, {{ $loan->getDaysLate() }} hari)
                                            </span>
                                        @elseif($loan->getActualStatus() === 'peminjaman')
                                            <span class="text-blue-700 font-medium flex items-center gap-2">
                                                <i class="fas fa-hourglass-half text-blue-600"></i> Peminjaman Aktif
                                            </span>
                                        @elseif($loan->getActualStatus() === 'menunggu_konfirmasi')
                                            <span class="text-amber-700 font-medium flex items-center gap-2">
                                                <i class="fas fa-clock text-amber-600"></i> Menunggu Konfirmasi
                                            </span>
                                        @elseif($loan->getActualStatus() === 'menunggu_pengembalian')
                                            <span class="text-purple-700 font-medium flex items-center gap-2">
                                                <i class="fas fa-undo text-purple-600"></i> Menunggu Pengembalian
                                            </span>
                                        @else
                                            <span class="text-slate-600 font-medium flex items-center gap-2">
                                                <i class="fas fa-ban text-slate-500"></i> Hangus
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Status dihitung otomatis berdasarkan tanggal pengembalian dan tenggat</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" rows="3" placeholder="Tambahkan catatan peminjaman..."
                                        class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $loan->notes) }}</textarea>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                                    <button type="submit" class="flex-1 px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium text-sm">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.loans.index') }}" class="flex-1 px-6 py-2.5 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors font-medium text-sm text-center">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dueInput = document.querySelector('input[name="due_date"]');
        const returnInput = document.querySelector('input[name="return_date"]');
        const statusContainer = document.getElementById('status-preview-box');

        function updateStatusPreview() {
            if (!dueInput || !statusContainer) return;

            const dueDateVal = dueInput.value;
            const returnDateVal = returnInput ? returnInput.value : '';

            if (returnDateVal && dueDateVal) {
                const returnDate = new Date(returnDateVal + 'T00:00:00');
                const dueDate = new Date(dueDateVal + 'T00:00:00');
                const diffDays = Math.round((returnDate - dueDate) / (1000 * 60 * 60 * 24));

                if (diffDays > 0) {
                    statusContainer.innerHTML = `<span class="text-amber-700 font-medium flex items-center gap-2"><i class="fas fa-exclamation-triangle text-amber-600"></i> Dikembalikan (Terlambat ${diffDays} hari)</span>`;
                } else {
                    statusContainer.innerHTML = `<span class="text-green-700 font-medium flex items-center gap-2"><i class="fas fa-check-circle text-green-600"></i> Dikembalikan (Tepat Waktu)</span>`;
                }
            } else if (dueDateVal) {
                const dueDate = new Date(dueDateVal + 'T00:00:00');
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const diffDays = Math.round((today - dueDate) / (1000 * 60 * 60 * 24));

                if (diffDays > 0) {
                    statusContainer.innerHTML = `<span class="text-red-700 font-medium flex items-center gap-2"><i class="fas fa-exclamation-circle text-red-600"></i> Terlambat (Belum Dikembalikan, ${diffDays} hari)</span>`;
                } else {
                    statusContainer.innerHTML = `<span class="text-blue-700 font-medium flex items-center gap-2"><i class="fas fa-hourglass-half text-blue-600"></i> Peminjaman Aktif</span>`;
                }
            }
        }

        if (dueInput) dueInput.addEventListener('change', updateStatusPreview);
        if (returnInput) returnInput.addEventListener('change', updateStatusPreview);
    });
    </script>
@endsection

