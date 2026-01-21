@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')
@section('subtitle', 'Catat peminjaman buku baru')

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

                            <form action="{{ route('admin.loans.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-user mr-2"></i>Peminjam
                                    </label>
                                    <select name="user_id" required
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                                        <option value="">-- Pilih Peminjam --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->npm }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-book mr-2"></i>Buku
                                    </label>
                                    <select name="book_id" required
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('book_id') border-red-500 @enderror">
                                        <option value="">-- Pilih Buku --</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }} by {{ $book->author }} (Stok: {{ $book->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-2"></i>Tanggal Peminjaman
                                        </label>
                                        <input type="date" name="loan_date" required value="{{ old('loan_date', now()->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('loan_date') border-red-500 @enderror">
                                        @error('loan_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">
                                            <i class="fas fa-calendar-check mr-2"></i>Tanggal Tenggat
                                        </label>
                                        <input type="date" name="due_date" required value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                                        @error('due_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" rows="4" placeholder="Tambahkan catatan peminjaman..."
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                                </div>

                                <div class="flex gap-4">
                                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                        <i class="fas fa-save mr-2"></i>Simpan Peminjaman
                                    </button>
                                    <a href="{{ route('admin.loans.index') }}" class="flex-1 px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors font-medium text-center">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
@endsection

