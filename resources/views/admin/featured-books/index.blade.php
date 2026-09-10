@extends('layouts.admin')

@section('title', 'Kelola Buku Beranda')
@section('subtitle', 'Atur buku yang tampil di rak interaktif 3D dan halaman beranda')

@section('content')
<div class="space-y-6">

    <!-- ALERT MESSAGES -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-exclamation-triangle text-rose-500 text-lg"></i>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-medium text-sm">
                <i class="fas fa-exclamation-circle text-rose-500"></i>
                <span>Terdapat kesalahan pengisian data:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tampil di Beranda</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $featuredCount }} <span class="text-sm font-normal text-slate-400">/ 10 Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <i class="fas fa-desktop text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lengkap Cover Belakang</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $completeBackCoverCount }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-check-double text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Perlu Cover Belakang</p>
                <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $missingBackCoverCount }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600">
                <i class="fas fa-images text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Koleksi Buku</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalBooks }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
    </div>

    <!-- PETUNJUK & ATURAN BERANDA -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-4 sm:p-5 flex items-start gap-3.5 shadow-sm">
        <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5">
            <i class="fas fa-lightbulb text-sm"></i>
        </div>
        <div class="text-sm text-slate-700">
            <h4 class="font-semibold text-slate-900 mb-1">Ketentuan Buku Tampil di Beranda:</h4>
            <p class="leading-relaxed">
                Kapasitas rak buku 3D beranda adalah <strong>maksimal 10 buku pilihan</strong> (Buku 1 sampai 10).
                <span class="text-amber-900 font-semibold bg-amber-100/80 px-1.5 py-0.5 rounded">Syarat Wajib:</span> Setiap buku yang ditampilkan di beranda <strong>wajib memiliki foto cover belakang</strong> agar pengunjung dapat membalik buku dan melihat cover depan serta belakang secara otentik.
            </p>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-4">
        <form id="featured-search-form" action="{{ route('admin.featured-books.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
            <input type="hidden" id="featured-status-input" name="status" value="{{ $status }}">

            <div class="flex items-center gap-2 flex-1 max-w-full md:max-w-md">
                <div class="relative flex-1">
                    <i id="featured-search-icon" class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" id="featured-books-search" name="search" value="{{ $search }}" autocomplete="off" placeholder="Ketik judul, penulis, ISBN untuk langsung mencari..." 
                           class="w-full pl-9 pr-8 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-slate-50/30">
                    <button type="button" id="clear-featured-search-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 {{ $search ? '' : 'hidden' }}" title="Hapus pencarian">
                        <i class="fas fa-times-circle text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2 justify-between sm:justify-end overflow-x-auto pb-1 sm:pb-0">
                <div class="flex bg-slate-100 p-1 rounded-lg text-xs font-medium shrink-0">
                    <a href="{{ route('admin.featured-books.index', ['status' => 'all', 'search' => $search]) }}"
                       class="status-tab px-2.5 sm:px-3 py-1.5 rounded-md transition-colors {{ $status === 'all' ? 'bg-white text-slate-900 shadow-sm font-semibold' : 'text-slate-500 hover:text-slate-800' }}" data-status="all">
                        Semua ({{ $totalBooks }})
                    </a>
                    <a href="{{ route('admin.featured-books.index', ['status' => 'featured', 'search' => $search]) }}"
                       class="status-tab px-2.5 sm:px-3 py-1.5 rounded-md transition-colors {{ $status === 'featured' ? 'bg-amber-500 text-white shadow-sm font-semibold' : 'text-slate-500 hover:text-slate-800' }}" data-status="featured">
                        Beranda ({{ $featuredCount }})
                    </a>
                    <a href="{{ route('admin.featured-books.index', ['status' => 'not_featured', 'search' => $search]) }}"
                       class="status-tab px-2.5 sm:px-3 py-1.5 rounded-md transition-colors {{ $status === 'not_featured' ? 'bg-white text-slate-900 shadow-sm font-semibold' : 'text-slate-500 hover:text-slate-800' }}" data-status="not_featured">
                        Bukan Beranda ({{ $totalBooks - $featuredCount }})
                    </a>
                </div>

                @if($search || $status !== 'all')
                    <a href="{{ route('admin.featured-books.index') }}" class="px-3 py-2 text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-slate-800 rounded-lg transition-colors flex items-center shrink-0" title="Reset filter">
                        <i class="fas fa-undo text-xs mr-1"></i>Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- TABLE LIST BUKU -->
    <div id="featured-books-table-wrapper" class="bg-white rounded-xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-semibold tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">#</th>
                        <th class="py-3.5 px-4">Buku &amp; Penulis</th>
                        <th class="py-3.5 px-4 text-center">Cover Depan</th>
                        <th class="py-3.5 px-4 text-center">Cover Belakang</th>
                        <th class="py-3.5 px-4 text-center">Status Beranda</th>
                        <th class="py-3.5 px-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $index => $book)
                    <tr class="hover:bg-slate-50/60 transition-colors {{ $book->is_featured ? 'bg-amber-50/20' : '' }}">
                        <!-- Index -->
                        <td class="py-4 px-4 text-center text-xs font-semibold text-slate-400">
                            {{ $books->firstItem() + $index }}
                        </td>

                        <!-- Book Info -->
                        <td class="py-4 px-4">
                            <div class="font-semibold text-slate-900 line-clamp-1">{{ $book->title }}</div>
                            <div class="text-xs text-slate-500 flex flex-wrap items-center gap-x-3 gap-y-1 mt-0.5">
                                <span><i class="fas fa-user-edit mr-1 text-slate-400"></i>{{ $book->author ?: '-' }}</span>
                                <span><i class="fas fa-barcode mr-1 text-slate-400"></i>{{ $book->isbn }}</span>
                                <span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 font-mono text-[10px]">{{ $book->shelf_number ?: 'Tanpa Rak' }}</span>
                            </div>
                        </td>

                        <!-- Front Cover Preview -->
                        <td class="py-4 px-4 text-center">
                            <div class="inline-block relative group">
                                @if($book->image && file_exists(public_path($book->image)))
                                    <img src="{{ asset($book->image) }}" alt="Front" class="w-12 h-16 object-cover rounded-md shadow-sm border border-slate-200 group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-12 h-16 bg-slate-100 rounded-md border border-dashed border-slate-300 flex items-center justify-center text-slate-400 text-xs">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <span class="text-[10px] block text-slate-400 mt-1 font-medium">Depan</span>
                            </div>
                        </td>

                        <!-- Back Cover Preview -->
                        <td class="py-4 px-4 text-center">
                            <div class="inline-block relative group">
                                @if($book->back_image && file_exists(public_path($book->back_image)))
                                    <img src="{{ asset($book->back_image) }}" alt="Back" class="w-12 h-16 object-cover rounded-md shadow-sm border border-slate-200 group-hover:scale-105 transition-transform">
                                    <span class="text-[10px] block text-emerald-600 font-semibold mt-1 flex items-center justify-center gap-0.5">
                                        <i class="fas fa-check text-[9px]"></i> Ada
                                    </span>
                                @else
                                    <div class="w-12 h-16 bg-rose-50 rounded-md border-2 border-dashed border-rose-300 flex flex-col items-center justify-center text-rose-400 text-xs">
                                        <i class="fas fa-file-upload text-sm"></i>
                                    </div>
                                    <span class="text-[10px] block text-rose-600 font-medium mt-1">Belum Ada</span>
                                @endif
                            </div>
                        </td>

                        <!-- Status Beranda Badge -->
                        <td class="py-4 px-4 text-center">
                            @if($book->is_featured)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Tampil di Beranda
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    Tidak Tampil
                                </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 text-center">
                            <button type="button" 
                                    onclick="openModal({{ $book->id }}, '{{ addslashes($book->title) }}', {{ $book->is_featured ? 'true' : 'false' }}, '{{ $book->image ? asset($book->image) : '' }}', '{{ $book->back_image ? asset($book->back_image) : '' }}')"
                                    class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all shadow-sm flex items-center justify-center gap-1.5 mx-auto {{ $book->is_featured ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-slate-800 hover:bg-slate-900 text-white' }}">
                                <i class="fas fa-sliders-h text-xs"></i>
                                Atur Beranda
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fas fa-book-open text-3xl mb-2 block text-slate-300"></i>
                            Tidak ada data buku yang sesuai pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- PAGINATION -->
        @if($books->total() > 0)
            <div class="px-4 py-3.5 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500">
                    Menampilkan <strong>{{ $books->firstItem() }}</strong> - <strong>{{ $books->lastItem() }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                </div>
                @if($books->hasPages())
                    <div class="overflow-x-auto">
                        {{ $books->appends(['search' => $search, 'status' => $status])->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- MODAL ATUR BUKU BERANDA -->
<div id="featuredModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden animate-fade-in p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-slate-900 flex items-center justify-center font-bold">
                    <i class="fas fa-desktop text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-white">Atur Tampilan Beranda</h3>
                    <p id="modalBookTitle" class="text-xs text-slate-300 line-clamp-1"></p>
                </div>
            </div>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="featuredForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            <!-- Dual Cover Preview Grid -->
            <div class="grid grid-cols-2 gap-4 bg-slate-50 p-3.5 rounded-xl border border-slate-200/80">
                <!-- Front Cover -->
                <div class="text-center">
                    <span class="text-xs font-semibold text-slate-600 block mb-1.5">Cover Depan</span>
                    <div class="w-24 h-32 mx-auto rounded-lg overflow-hidden shadow border border-slate-200 bg-white">
                        <img id="modalFrontPreview" src="" alt="Cover Depan" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Back Cover -->
                <div class="text-center">
                    <span class="text-xs font-semibold text-slate-600 block mb-1.5">Cover Belakang</span>
                    <div id="modalBackContainer" class="w-24 h-32 mx-auto rounded-lg overflow-hidden shadow border border-slate-200 bg-white relative flex items-center justify-center">
                        <img id="modalBackPreview" src="" alt="Cover Belakang" class="w-full h-full object-cover hidden">
                        <div id="modalNoBackText" class="text-[11px] text-rose-500 font-medium px-2 text-center">
                            <i class="fas fa-exclamation-circle text-lg mb-1 block text-rose-400"></i>
                            Belum ada cover belakang
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Cover Belakang -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Unggah / Ganti Cover Belakang <span class="text-rose-500">*</span>
                </label>
                <div class="border-2 border-dashed border-slate-300 hover:border-amber-500 rounded-xl p-4 text-center transition-colors bg-white">
                    <input type="file" name="back_image" id="back_image_input" accept="image/*" class="hidden" onchange="previewBackUpload(event)">
                    <label for="back_image_input" class="cursor-pointer block">
                        <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-1.5 block hover:text-amber-500 transition-colors"></i>
                        <span class="text-xs font-medium text-slate-700 block">Pilih file foto cover belakang</span>
                        <span class="text-[11px] text-slate-400 block mt-0.5">Format: JPG, PNG, WEBP (Maksimal 3MB)</span>
                    </label>
                </div>
                <p id="uploadFileName" class="text-xs text-emerald-600 font-medium mt-1.5 hidden flex items-center gap-1">
                    <i class="fas fa-check-circle"></i> <span></span>
                </p>
            </div>

            <!-- Checkbox Switch: Tampilkan di Beranda -->
            <div class="pt-2 border-t border-slate-100">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_featured" value="1" id="modalFeaturedCheckbox" 
                           class="mt-1 w-4 h-4 text-amber-500 rounded border-slate-300 focus:ring-amber-400 cursor-pointer"
                           onchange="handleCheckboxChange(this)">
                    <div>
                        <span class="text-sm font-semibold text-slate-900 block">Tampilkan buku ini di halaman beranda</span>
                        <span class="text-xs text-slate-500 block mt-0.5">
                            Buku akan ditempatkan pada rak interaktif 3D beranda perpustakaan. 
                            <span class="text-amber-700 font-medium">(Wajib melampirkan cover belakang)</span>
                        </span>
                    </div>
                </label>
            </div>

            <!-- Warning Callout when toggling without back cover -->
            <div id="missingBackWarning" class="p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-800 flex items-start gap-2 hidden">
                <i class="fas fa-exclamation-triangle text-amber-600 shrink-0 mt-0.5"></i>
                <span>Buku ini belum memiliki foto cover belakang. Anda wajib mengunggah file cover belakang di atas agar buku dapat ditampilkan di beranda.</span>
            </div>

            <!-- Modal Footer Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-semibold bg-amber-500 hover:bg-amber-600 text-white rounded-lg shadow-sm transition-all flex items-center gap-1.5">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentBookHasBackImage = false;

    function openModal(bookId, title, isFeatured, frontUrl, backUrl) {
        const modal = document.getElementById('featuredModal');
        const form = document.getElementById('featuredForm');
        const titleEl = document.getElementById('modalBookTitle');
        const frontImg = document.getElementById('modalFrontPreview');
        const backImg = document.getElementById('modalBackPreview');
        const noBackText = document.getElementById('modalNoBackText');
        const checkbox = document.getElementById('modalFeaturedCheckbox');
        const uploadFileName = document.getElementById('uploadFileName');
        const fileInput = document.getElementById('back_image_input');
        const warning = document.getElementById('missingBackWarning');

        form.action = `/admin/featured-books/${bookId}`;
        titleEl.textContent = title;
        checkbox.checked = isFeatured;

        // Reset file input
        fileInput.value = '';
        uploadFileName.classList.add('hidden');

        // Front preview
        frontImg.src = frontUrl || '{{ asset("images/books/spine&cover.jpg") }}';

        // Back preview
        currentBookHasBackImage = !!backUrl;
        if (backUrl) {
            backImg.src = backUrl;
            backImg.classList.remove('hidden');
            noBackText.classList.add('hidden');
        } else {
            backImg.classList.add('hidden');
            noBackText.classList.remove('hidden');
        }

        checkBackWarning();

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('featuredModal').classList.add('hidden');
    }

    function previewBackUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const uploadFileName = document.getElementById('uploadFileName');
        uploadFileName.querySelector('span').textContent = file.name;
        uploadFileName.classList.remove('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            const backImg = document.getElementById('modalBackPreview');
            const noBackText = document.getElementById('modalNoBackText');
            backImg.src = e.target.result;
            backImg.classList.remove('hidden');
            noBackText.classList.add('hidden');

            currentBookHasBackImage = true;
            checkBackWarning();
        };
        reader.readAsDataURL(file);
    }

    function handleCheckboxChange(cb) {
        checkBackWarning();
    }

    function checkBackWarning() {
        const checkbox = document.getElementById('modalFeaturedCheckbox');
        const fileInput = document.getElementById('back_image_input');
        const warning = document.getElementById('missingBackWarning');

        const hasUploaded = fileInput.files && fileInput.files.length > 0;
        const hasBack = currentBookHasBackImage || hasUploaded;

        if (checkbox.checked && !hasBack) {
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // Automatically open modal if redirected with error
    @if(session('open_modal_book_id'))
        document.addEventListener('DOMContentLoaded', function() {
            const row = document.querySelector('button[onclick*="openModal({{ session('open_modal_book_id') }},"]');
            if (row) row.click();
        });
    @endif

    // Live Auto Search
    (function() {
        var searchInput = document.getElementById('featured-books-search');
        var statusInput = document.getElementById('featured-status-input');
        var clearBtn = document.getElementById('clear-featured-search-btn');
        var searchIcon = document.getElementById('featured-search-icon');
        var tableWrapper = document.getElementById('featured-books-table-wrapper');
        var form = document.getElementById('featured-search-form');

        var debounceTimer = null;
        var activeController = null;

        function updateClearBtn() {
            if (clearBtn && searchInput) {
                if (searchInput.value.trim().length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            }
        }

        function performSearch(pageUrl) {
            updateClearBtn();

            if (searchIcon) searchIcon.className = 'fas fa-circle-notch fa-spin text-amber-500 absolute left-3.5 top-1/2 -translate-y-1/2 text-sm';
            if (tableWrapper) {
                tableWrapper.style.transition = 'opacity 0.2s ease';
                tableWrapper.style.opacity = '0.5';
            }

            if (activeController) activeController.abort();
            activeController = new AbortController();

            var url;
            if (pageUrl) {
                url = new URL(pageUrl, window.location.origin);
            } else {
                url = new URL('{{ route('admin.featured-books.index') }}', window.location.origin);
                var q = searchInput ? searchInput.value.trim() : '';
                var st = statusInput ? statusInput.value : 'all';
                if (q) url.searchParams.set('search', q);
                if (st && st !== 'all') url.searchParams.set('status', st);
            }

            fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: activeController.signal
            })
            .then(function(res) { return res.text(); })
            .then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var newWrapper = doc.getElementById('featured-books-table-wrapper');
                if (newWrapper && tableWrapper) {
                    tableWrapper.innerHTML = newWrapper.innerHTML;
                    bindPaginationLinks();
                }
                window.history.replaceState({}, '', url.toString());
            })
            .catch(function(err) {
                if (err.name !== 'AbortError') console.error(err);
            })
            .finally(function() {
                if (searchIcon) searchIcon.className = 'fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm';
                if (tableWrapper) tableWrapper.style.opacity = '1';
            });
        }

        function bindPaginationLinks() {
            if (!tableWrapper) return;
            var links = tableWrapper.querySelectorAll('nav a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var href = this.getAttribute('href');
                    if (href && href !== '#') {
                        performSearch(href);
                    }
                });
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(performSearch, 300);
            });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    performSearch();
                }
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (searchInput) {
                    searchInput.value = '';
                    clearBtn.classList.add('hidden');
                    searchInput.focus();
                }
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        bindPaginationLinks();
    })();
</script>
@endsection
