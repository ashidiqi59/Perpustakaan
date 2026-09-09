@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')
@section('subtitle', 'Catat peminjaman buku baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <!-- Header Banner -->
            <div class="p-5 sm:p-6 bg-gradient-to-r from-slate-50 via-slate-50 to-blue-50/40 border-b border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500 text-white flex items-center justify-center text-xl shrink-0 shadow-sm shadow-blue-500/20">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Formulir Peminjaman Buku</h3>
                    <p class="text-xs sm:text-sm text-slate-500">Cari anggota peminjam dan buku yang ingin dipinjam</p>
                </div>
            </div>

            <div class="p-5 sm:p-7">
                @if(isset($errors) && $errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl mb-6 text-sm flex items-start gap-3 shadow-xs">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fas fa-exclamation-circle text-base"></i>
                        </div>
                        <div>
                            <p class="font-bold text-rose-900 mb-1">Periksa kembali formulir:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-xs sm:text-sm text-rose-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form id="loan-form" action="{{ route('admin.loans.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- PEMINJAM (SEARCHABLE COMBOBOX) -->
                    <div class="relative" id="user-combobox">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-user text-blue-600 text-xs"></i>
                            <span>Peminjam (Anggota / Mahasiswa)</span>
                            <span class="text-rose-500">*</span>
                        </label>

                        <!-- Hidden value for form submission -->
                        <input type="hidden" name="user_id" id="selected-user-id" value="{{ old('user_id') }}" required>

                        <!-- Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-search text-sm"></i>
                            </div>
                            <input type="text" id="user-search-input" autocomplete="off"
                                placeholder="Ketik nama anggota atau NPM..."
                                class="w-full pl-10 pr-16 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium cursor-pointer">

                            <!-- Trailing Buttons (Clear + Dropdown Toggle) -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1">
                                <button type="button" id="user-clear-btn" class="hidden text-slate-400 hover:text-slate-600 p-1.5 rounded-md transition-colors" title="Hapus pilihan">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <button type="button" id="user-toggle-btn" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-md transition-colors">
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="user-chevron"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Dropdown Options Menu -->
                        <div id="user-dropdown" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl z-50 max-h-60 overflow-y-auto divide-y divide-slate-100">
                            @forelse($users as $user)
                                <div class="user-option p-3 hover:bg-blue-50/80 cursor-pointer flex items-center justify-between transition-colors {{ old('user_id') == $user->id ? 'bg-blue-50' : '' }}"
                                     data-id="{{ $user->id }}"
                                     data-name="{{ $user->name }}"
                                     data-npm="{{ $user->npm ?? '' }}"
                                     data-email="{{ $user->email }}"
                                     data-label="{{ $user->name }}{{ $user->npm ? ' (' . $user->npm . ')' : '' }}"
                                     data-search="{{ strtolower($user->name . ' ' . $user->npm . ' ' . $user->email) }}">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">
                                                @if($user->npm)
                                                    <span class="font-mono font-medium text-blue-600">NPM: {{ $user->npm }}</span>
                                                @else
                                                    <span class="text-slate-400">Pengunjung</span>
                                                @endif
                                                &bull; <span class="text-slate-400">{{ $user->email }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <span class="user-check-icon text-blue-600 {{ old('user_id') == $user->id ? '' : 'hidden' }} shrink-0 ml-2">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-slate-400">Belum ada anggota pengunjung terdaftar.</div>
                            @endforelse
                            <div id="user-empty-state" class="hidden p-4 text-center text-xs text-slate-400">
                                <i class="fas fa-search-minus mr-1"></i> Tidak ada anggota yang cocok dengan kata kunci
                            </div>
                        </div>

                        @error('user_id')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- BUKU (SEARCHABLE COMBOBOX) -->
                    <div class="relative" id="book-combobox">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-book text-blue-600 text-xs"></i>
                            <span>Buku yang Dipinjam</span>
                            <span class="text-rose-500">*</span>
                        </label>

                        <!-- Hidden value for form submission -->
                        <input type="hidden" name="book_id" id="selected-book-id" value="{{ old('book_id') }}" required>

                        <!-- Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-search text-sm"></i>
                            </div>
                            <input type="text" id="book-search-input" autocomplete="off"
                                placeholder="Ketik judul buku, penulis, atau ISBN..."
                                class="w-full pl-10 pr-16 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium cursor-pointer">

                            <!-- Trailing Buttons (Clear + Dropdown Toggle) -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1">
                                <button type="button" id="book-clear-btn" class="hidden text-slate-400 hover:text-slate-600 p-1.5 rounded-md transition-colors" title="Hapus pilihan">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <button type="button" id="book-toggle-btn" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-md transition-colors">
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="book-chevron"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Dropdown Options Menu -->
                        <div id="book-dropdown" class="hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl z-50 max-h-64 overflow-y-auto divide-y divide-slate-100">
                            @forelse($books as $book)
                                <div class="book-option p-3 hover:bg-blue-50/80 cursor-pointer flex items-center justify-between transition-colors {{ old('book_id') == $book->id ? 'bg-blue-50' : '' }}"
                                     data-id="{{ $book->id }}"
                                     data-title="{{ $book->title }}"
                                     data-author="{{ $book->author }}"
                                     data-isbn="{{ $book->isbn ?? '' }}"
                                     data-stock="{{ $book->stock }}"
                                     data-label="{{ $book->title }} - {{ $book->author }} (Stok: {{ $book->stock }})"
                                     data-search="{{ strtolower($book->title . ' ' . $book->author . ' ' . $book->isbn . ' ' . $book->category) }}">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if(!empty($book->image))
                                            <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="w-9 h-12 object-cover rounded-md shrink-0 shadow-2xs border border-slate-200">
                                        @else
                                            <div class="w-9 h-12 rounded-md bg-slate-100 text-slate-400 flex items-center justify-center shrink-0 border border-slate-200">
                                                <i class="fas fa-book text-sm"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $book->title }}</p>
                                            <p class="text-xs text-slate-500 truncate">
                                                <span>Penulis: {{ $book->author }}</span>
                                                @if($book->isbn)
                                                    &bull; <span>ISBN: {{ $book->isbn }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0 ml-2">
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Stok: {{ $book->stock }}
                                        </span>
                                        <span class="book-check-icon text-blue-600 {{ old('book_id') == $book->id ? '' : 'hidden' }}">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-slate-400">Tidak ada stok buku yang tersedia saat ini.</div>
                            @endforelse
                            <div id="book-empty-state" class="hidden p-4 text-center text-xs text-slate-400">
                                <i class="fas fa-search-minus mr-1"></i> Tidak ada buku yang cocok dengan kata kunci
                            </div>
                        </div>

                        @error('book_id')
                            <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- TANGGAL PINJAM & TENGGAT -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                <i class="fas fa-calendar-alt text-blue-600 text-xs"></i>
                                <span>Tgl Pinjam</span>
                                <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="loan_date" required value="{{ old('loan_date', now()->format('Y-m-d')) }}"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 font-medium">
                            @error('loan_date')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                                <i class="fas fa-calendar-check text-blue-600 text-xs"></i>
                                <span>Tgl Tenggat</span>
                                <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="due_date" required value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 font-medium">
                            @error('due_date')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- CATATAN -->
                    <div>
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-sticky-note text-blue-600 text-xs"></i>
                            <span>Catatan (Opsional)</span>
                        </label>
                        <textarea name="notes" rows="3" placeholder="Tambahkan catatan peminjaman jika diperlukan..."
                            class="w-full px-3.5 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium">{{ old('notes') }}</textarea>
                    </div>

                    <!-- FORM ACTIONS -->
                    <div class="pt-4 border-t border-slate-200/80 flex flex-col-reverse sm:flex-row justify-end items-center gap-3">
                        <a href="{{ route('admin.loans.index') }}" 
                           class="w-full sm:w-auto px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium rounded-xl border border-slate-300 shadow-2xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-times text-xs text-slate-400"></i>
                            <span>Batal</span>
                        </a>

                        <button type="submit" 
                                class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 active:scale-98 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-save"></i>
                            <span>Simpan Peminjaman</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        /**
         * Reusable Searchable Combobox Component
         */
        function setupSearchableCombobox(config) {
            const container = document.getElementById(config.containerId);
            const searchInput = document.getElementById(config.searchInputId);
            const hiddenInput = document.getElementById(config.hiddenInputId);
            const dropdown = document.getElementById(config.dropdownId);
            const toggleBtn = document.getElementById(config.toggleBtnId);
            const clearBtn = document.getElementById(config.clearBtnId);
            const chevron = document.getElementById(config.chevronId);
            const emptyState = document.getElementById(config.emptyStateId);
            const options = container.querySelectorAll('.' + config.optionClass);

            if (!container || !searchInput || !hiddenInput || !dropdown) return;

            let isOpen = false;

            function openDropdown() {
                dropdown.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
                isOpen = true;
            }

            function closeDropdown() {
                dropdown.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
                isOpen = false;

                // Reset filter visibility on close
                options.forEach(opt => opt.classList.remove('hidden'));
                if (emptyState) emptyState.classList.add('hidden');
            }

            function filterOptions(query) {
                const term = query.toLowerCase().trim();
                let matchCount = 0;

                options.forEach(opt => {
                    const searchData = opt.getAttribute('data-search') || '';
                    if (!term || searchData.includes(term)) {
                        opt.classList.remove('hidden');
                        matchCount++;
                    } else {
                        opt.classList.add('hidden');
                    }
                });

                if (emptyState) {
                    if (matchCount === 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        emptyState.classList.add('hidden');
                    }
                }
            }

            function selectOption(opt) {
                const id = opt.getAttribute('data-id');
                const label = opt.getAttribute('data-label');

                hiddenInput.value = id;
                searchInput.value = label;

                // Update checkmark indicators
                options.forEach(o => {
                    const checkIcon = o.querySelector('.' + config.checkIconClass);
                    if (checkIcon) {
                        if (o.getAttribute('data-id') === id) {
                            checkIcon.classList.remove('hidden');
                            o.classList.add('bg-blue-50');
                        } else {
                            checkIcon.classList.add('hidden');
                            o.classList.remove('bg-blue-50');
                        }
                    }
                });

                if (clearBtn) clearBtn.classList.remove('hidden');
                closeDropdown();
            }

            function clearSelection() {
                hiddenInput.value = '';
                searchInput.value = '';
                if (clearBtn) clearBtn.classList.add('hidden');

                options.forEach(o => {
                    const checkIcon = o.querySelector('.' + config.checkIconClass);
                    if (checkIcon) checkIcon.classList.add('hidden');
                    o.classList.remove('bg-blue-50');
                    o.classList.remove('hidden');
                });

                if (emptyState) emptyState.classList.add('hidden');
                searchInput.focus();
                openDropdown();
            }

            // Input Events
            searchInput.addEventListener('focus', function() {
                openDropdown();
                filterOptions(this.value);
            });

            searchInput.addEventListener('click', function() {
                openDropdown();
            });

            searchInput.addEventListener('input', function() {
                openDropdown();
                filterOptions(this.value);

                if (this.value.trim().length > 0) {
                    if (clearBtn) clearBtn.classList.remove('hidden');
                } else {
                    hiddenInput.value = '';
                    if (clearBtn) clearBtn.classList.add('hidden');
                }
            });

            // Toggle Button Event
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (isOpen) {
                        closeDropdown();
                    } else {
                        searchInput.focus();
                        openDropdown();
                    }
                });
            }

            // Clear Button Event
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    clearSelection();
                });
            }

            // Option Click Events
            options.forEach(opt => {
                opt.addEventListener('click', function() {
                    selectOption(this);
                });
            });

            // Close on click outside
            document.addEventListener('click', function(e) {
                if (!container.contains(e.target)) {
                    if (isOpen) {
                        closeDropdown();

                        // If user typed something but didn't pick an option, restore previous selection or clear
                        if (!hiddenInput.value) {
                            searchInput.value = '';
                            if (clearBtn) clearBtn.classList.add('hidden');
                        } else {
                            // Find option corresponding to hiddenInput.value and restore label
                            const selectedOpt = Array.from(options).find(o => o.getAttribute('data-id') === hiddenInput.value);
                            if (selectedOpt) {
                                searchInput.value = selectedOpt.getAttribute('data-label');
                            }
                        }
                    }
                }
            });

            // Initialize from old input if exists
            if (hiddenInput.value) {
                const initialOpt = Array.from(options).find(o => o.getAttribute('data-id') === hiddenInput.value);
                if (initialOpt) {
                    searchInput.value = initialOpt.getAttribute('data-label');
                    if (clearBtn) clearBtn.classList.remove('hidden');
                }
            }
        }

        // Setup Peminjam Combobox
        setupSearchableCombobox({
            containerId: 'user-combobox',
            searchInputId: 'user-search-input',
            hiddenInputId: 'selected-user-id',
            dropdownId: 'user-dropdown',
            toggleBtnId: 'user-toggle-btn',
            clearBtnId: 'user-clear-btn',
            chevronId: 'user-chevron',
            emptyStateId: 'user-empty-state',
            optionClass: 'user-option',
            checkIconClass: 'user-check-icon'
        });

        // Setup Buku Combobox
        setupSearchableCombobox({
            containerId: 'book-combobox',
            searchInputId: 'book-search-input',
            hiddenInputId: 'selected-book-id',
            dropdownId: 'book-dropdown',
            toggleBtnId: 'book-toggle-btn',
            clearBtnId: 'book-clear-btn',
            chevronId: 'book-chevron',
            emptyStateId: 'book-empty-state',
            optionClass: 'book-option',
            checkIconClass: 'book-check-icon'
        });

        // Client-side validation on form submit to ensure selections were made
        const form = document.getElementById('loan-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const userVal = document.getElementById('selected-user-id').value;
                const bookVal = document.getElementById('selected-book-id').value;

                if (!userVal) {
                    e.preventDefault();
                    const userInput = document.getElementById('user-search-input');
                    userInput.focus();
                    userInput.classList.add('border-rose-500', 'ring-2', 'ring-rose-500/20');
                    alert('Silakan pilih nama peminjam dari daftar pilihan.');
                    return false;
                }

                if (!bookVal) {
                    e.preventDefault();
                    const bookInput = document.getElementById('book-search-input');
                    bookInput.focus();
                    bookInput.classList.add('border-rose-500', 'ring-2', 'ring-rose-500/20');
                    alert('Silakan pilih buku yang ingin dipinjam dari daftar pilihan.');
                    return false;
                }
            });
        }
    });
    </script>
    @endpush
@endsection
