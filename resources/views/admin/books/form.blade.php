@extends('layouts.admin')

@section('title', $action == 'create' ? 'Tambah Buku Baru' : 'Edit Buku')
@section('subtitle', $action == 'create' ? 'Tambahkan buku baru ke koleksi' : 'Perbarui informasi buku')

@section('header-actions')
    <a href="{{ route('admin.books.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
                    <!-- ALERT MESSAGES -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ $action == 'create' ? route('admin.books.store') : route('admin.books.update', $book->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @csrf
                        @if($action == 'edit')
                            @method('PUT')
                        @endif

                        <div class="p-4 sm:p-6">
                            <!-- Mobile: Stacked layout, Desktop: Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                                <!-- LEFT COLUMN - MAIN INFO -->
                                <div class="lg:col-span-2 space-y-4">
                                    <!-- ISBN & Title -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">ISBN *</label>
                                            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="978-1234567890">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Judul Buku *</label>
                                            <input type="text" name="title" value="{{ old('title', $book->title) }}" required
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Judul buku">
                                        </div>
                                    </div>

                                    <!-- Author & Publisher -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Penulis</label>
                                            <input type="text" name="author" value="{{ old('author', $book->author) }}"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Nama penulis">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Penerbit</label>
                                            <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Nama penerbit">
                                        </div>
                                    </div>

                                    <!-- Category & Language -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Kategori</label>
                                            <select name="category" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">Pilih Kategori</option>
                                                <option value="Fiksi" {{ old('category', $book->category) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                                <option value="Non-Fiksi" {{ old('category', $book->category) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                                <option value="Sains" {{ old('category', $book->category) == 'Sains' ? 'selected' : '' }}>Sains</option>
                                                <option value="Teknologi" {{ old('category', $book->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                                <option value="Sejarah" {{ old('category', $book->category) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                                <option value="Biografi" {{ old('category', $book->category) == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                                                <option value="Pendidikan" {{ old('category', $book->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                                <option value="Agama" {{ old('category', $book->category) == 'Agama' ? 'selected' : '' }}>Agama</option>
                                                <option value="Novel" {{ old('category', $book->category) == 'Novel' ? 'selected' : '' }}>Novel</option>
                                                <option value="Komik" {{ old('category', $book->category) == 'Komik' ? 'selected' : '' }}>Komik</option>
                                                <option value="Lainnya" {{ old('category', $book->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Bahasa</label>
                                            <select name="language" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">Pilih Bahasa</option>
                                                <option value="Indonesia" {{ old('language', $book->language) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                <option value="Inggris" {{ old('language', $book->language) == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                                                <option value="Jerman" {{ old('language', $book->language) == 'Jerman' ? 'selected' : '' }}>Jerman</option>
                                                <option value="Prancis" {{ old('language', $book->language) == 'Prancis' ? 'selected' : '' }}>Prancis</option>
                                                <option value="Jepang" {{ old('language', $book->language) == 'Jepang' ? 'selected' : '' }}>Jepang</option>
                                                <option value="Mandarin" {{ old('language', $book->language) == 'Mandarin' ? 'selected' : '' }}>Mandarin</option>
                                                <option value="Lainnya" {{ old('language', $book->language) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Shelf Number & Stock -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Nomor Rak</label>
                                            <input type="text" name="shelf_number" value="{{ old('shelf_number', $book->shelf_number) }}"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="A-1-1">
                                        </div>
                                        <div>
                                            <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Jumlah Stok *</label>
                                            <input type="number" name="stock" value="{{ old('stock', $book->stock ?? 1) }}" required min="0"
                                                class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="0">
                                        </div>
                                    </div>

                                    <!-- Published Date -->
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Tanggal Terbit</label>
                                        <input type="date" name="published_date" value="{{ old('published_date', $book->published_date ? \Carbon\Carbon::parse($book->published_date)->format('Y-m-d') : '') }}"
                                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Deskripsi</label>
                                        <textarea name="description" rows="4"
                                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Deskripsi singkat tentang buku ini...">{{ old('description', $book->description) }}</textarea>
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN - IMAGE -->
                                <div class="space-y-4">
                                    <!-- Cover Image -->
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Cover Buku</label>
                                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-3 text-center hover:border-blue-500 transition-colors">
                                            <input type="file" name="image" id="image" accept="image/*" class="hidden"
                                                onchange="previewImage(event)">
                                            <label for="image" class="cursor-pointer">
                                                @if($book->image)
                                                    <img id="image-preview" src="{{ asset($book->image) }}" alt="Preview" class="w-full h-36 sm:h-48 object-cover rounded-lg">
                                                @else
                                                    <img id="image-preview" src="{{ asset('images/books/spine&cover.jpg') }}" alt="Preview" class="w-full h-36 sm:h-48 object-cover rounded-lg">
                                                @endif
                                                <p class="mt-2 text-xs sm:text-sm text-slate-500">
                                                    <i class="fas fa-cloud-upload-alt mr-1"></i>
                                                    Klik untuk upload
                                                </p>
                                                <p class="text-xs text-slate-400">Format: JPEG, PNG, JPG (Max 2MB)</p>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Book Summary -->
                                    <div class="bg-blue-50 rounded-lg p-3 sm:p-4">
                                        <h4 class="font-medium text-blue-800 mb-2 text-sm">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Informasi Buku
                                        </h4>
                                        <div class="space-y-1 text-xs sm:text-sm text-blue-700">
                                            <p>ISBN: {{ $book->isbn ?: 'Belum ada' }}</p>
                                            <p>Kategori: {{ $book->category ?: 'Belum ada' }}</p>
                                            <p>Stok: {{ $book->stock ?: 0 }} buku</p>
                                            @if($book->created_at)
                                                <p>Diinput: {{ $book->created_at->format('d/m/Y') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ACTIONS -->
                        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                            <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-slate-500 text-white text-sm rounded-lg hover:bg-slate-600 transition-colors text-center">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                {{ $action == 'create' ? 'Simpan Buku' : 'Perbarui Buku' }}
                            </button>
                        </div>
                    </form>

                    <script>
                        function previewImage(event) {
                            const reader = new FileReader();
                            reader.onload = function() {
                                const output = document.getElementById('image-preview');
                                output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    </script>
@endsection

