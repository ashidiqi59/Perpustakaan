@extends('layouts.admin')

@section('title', 'Edit Peminjaman')
@section('subtitle', 'Perbarui data peminjaman')

@section('content')
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            @if($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>Peminjam
                                    </label>
                                    <select name="user_id" disabled
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed">
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
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed">
                                        <option value="{{ $loan->book->id }}">
                                            {{ $loan->book->title }} by {{ $loan->book->author }}
                                        </option>
                                    </select>
                                    <p class="text-xs text-slate-500 mt-1">Buku tidak dapat diubah</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-2"></i>Tanggal Peminjaman
                                        </label>
                                        <input type="date" name="loan_date" required value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('loan_date') border-red-500 @enderror">
                                        @error('loan_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-check mr-2"></i>Tanggal Tenggat
                                        </label>
                                        <input type="date" name="due_date" required value="{{ old('due_date', $loan->due_date->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                                        @error('due_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-undo mr-2"></i>Tanggal Pengembalian
                                    </label>
                                    <input type="date" name="return_date" value="{{ old('return_date', $loan->return_date?->format('Y-m-d')) }}"
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('return_date') border-red-500 @enderror">
                                    @error('return_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-slate-500 mt-1">Kosongkan jika belum dikembalikan</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-flag mr-2"></i>Status
                                    </label>
                                    <div class="w-full px-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-600">
                                        @if($loan->getActualStatus() === 'peminjaman')
                                            <span class="text-amber-700 font-medium">
                                                <i class="fas fa-hourglass-half mr-2"></i>Peminjaman Aktif
                                            </span>
                                        @elseif($loan->getActualStatus() === 'dikembalikan')
                                            <span class="text-green-700 font-medium">
                                                <i class="fas fa-check-circle mr-2"></i>Dikembalikan (Tepat Waktu)
                                            </span>
                                        @else
                                            <span class="text-red-700 font-medium">
                                                <i class="fas fa-exclamation-circle mr-2"></i>Terlambat
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">Status dihitung otomatis berdasarkan tanggal pengembalian dan tenggat</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" rows="4" placeholder="Tambahkan catatan peminjaman..."
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $loan->notes) }}</textarea>
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.loans.index') }}" class="flex-1 px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors font-medium text-center">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
@endsection

