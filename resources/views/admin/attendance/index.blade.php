@extends('layouts.admin')

@section('title', 'Riwayat Presensi Anggota')
@section('subtitle', 'Arsip dan catatan kehadiran pengunjung perpustakaan')

@section('content')

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengunjung Hari Ini</p>
                <h3 class="text-2xl font-bold text-violet-600 mt-1">{{ $totalToday }} <span class="text-sm font-normal text-slate-400">Orang</span></h3>
            </div>
            <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 shrink-0">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Minggu Ini</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalWeek }} <span class="text-sm font-normal text-slate-400">Kunjungan</span></h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-calendar-week text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Bulan Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalMonth }} <span class="text-sm font-normal text-slate-400">Kunjungan</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-4 sm:p-5 mb-6">
        <form method="GET" action="{{ route('admin.attendance.index') }}"
              class="flex flex-col sm:flex-row gap-3 items-end">

            <div class="flex-1 w-full">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    <i class="fas fa-calendar mr-1 text-violet-500"></i> Filter Tanggal
                </label>
                <input type="date" id="attendance-date" name="date" value="{{ $date }}"
                       class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500 bg-white cursor-pointer">
            </div>

            <div class="flex-1 w-full">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    <i id="search-icon" class="fas fa-search mr-1 text-violet-500"></i> Cari Nama
                </label>
                <div class="relative">
                    <input type="text" id="attendance-name" name="name" value="{{ $name }}" autocomplete="off"
                           placeholder="Ketik nama anggota untuk langsung mencari..."
                           class="w-full pl-3 pr-8 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <button type="button" id="clear-attendance-btn" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 {{ $name ? '' : 'hidden' }}" title="Hapus nama">
                        <i class="fas fa-times-circle text-xs"></i>
                    </button>
                </div>
            </div>

            <input type="hidden" name="filter" value="1">

            <div id="reset-btn-container" class="{{ (request()->has('filter') || request()->hasAny(['date', 'name'])) ? '' : 'hidden' }} flex gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.attendance.index') }}" id="reset-filter-btn"
                   class="flex-1 sm:flex-none px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-lg transition-colors flex items-center justify-center gap-1.5">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div id="attendance-table-wrapper" class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80">
        <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-600 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-clipboard-list text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Riwayat Presensi</h3>
                    <p class="text-xs text-slate-500">
                        Menampilkan data tanggal
                        <strong class="text-violet-600">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</strong>
                        @if($name) · cari: "<em>{{ $name }}</em>" @endif
                    </p>
                </div>
            </div>
            <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs font-bold rounded-full">
                {{ $logs->total() }} Data
            </span>
        </div>

        @if($logs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Anggota</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 hidden sm:table-cell">NPM</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 hidden md:table-cell">Program Studi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Jam Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($logs as $index => $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-xs text-slate-400 font-mono">
                                {{ $logs->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $log->user?->getAvatarUrl() }}"
                                         alt="{{ $log->user?->name }}"
                                         class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                                    <div>
                                        <p class="font-semibold text-slate-800 text-xs">{{ $log->user?->name ?? '(Akun Dihapus)' }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $log->user?->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <span class="text-xs font-mono text-slate-600">{{ $log->user?->npm ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <span class="text-xs text-slate-600 truncate max-w-[160px] block">{{ $log->user?->prodi ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs text-slate-700">
                                    {{ $log->scan_date->translatedFormat('l') }}<br>
                                    <span class="text-slate-500">{{ $log->scan_date->format('d/m/Y') }}</span>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-semibold whitespace-nowrap">
                                    <i class="fas fa-clock mr-1"></i>{{ $log->scanned_at->format('H:i') }} WIB
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($logs->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-slate-200">
                {{ $logs->links() }}
            </div>
            @endif

        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-slate-400 text-2xl"></i>
                </div>
                <h4 class="text-sm font-semibold text-slate-600 mb-1">Tidak Ada Data Presensi</h4>
                <p class="text-xs text-slate-400">
                    Tidak ada pengunjung yang check-in pada tanggal
                    <strong>{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</strong>.
                </p>
                @if($name)
                    <p class="text-xs text-slate-400 mt-1">Dengan filter nama: "<em>{{ $name }}</em>"</p>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        var dateInput = document.getElementById('attendance-date');
        var nameInput = document.getElementById('attendance-name');
        var clearBtn = document.getElementById('clear-attendance-btn');
        var resetContainer = document.getElementById('reset-btn-container');
        var searchIcon = document.getElementById('search-icon');
        var tableWrapper = document.getElementById('attendance-table-wrapper');

        var debounceTimer = null;
        var activeController = null;

        function updateResetVisibility() {
            var today = new Date().toISOString().slice(0, 10);
            var hasFilter = (nameInput && nameInput.value.trim().length > 0) || (dateInput && dateInput.value !== today);
            if (resetContainer) {
                if (hasFilter) resetContainer.classList.remove('hidden');
                else resetContainer.classList.add('hidden');
            }
            if (clearBtn && nameInput) {
                if (nameInput.value.trim().length > 0) clearBtn.classList.remove('hidden');
                else clearBtn.classList.add('hidden');
            }
        }

        function performSearch(pageUrl) {
            updateResetVisibility();

            if (searchIcon) searchIcon.className = 'fas fa-circle-notch fa-spin mr-1 text-violet-500';
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
                url = new URL('{{ route('admin.attendance.index') }}', window.location.origin);
                var d = dateInput ? dateInput.value : '';
                var n = nameInput ? nameInput.value.trim() : '';
                if (d) url.searchParams.set('date', d);
                if (n) url.searchParams.set('name', n);
                url.searchParams.set('filter', '1');
            }

            fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: activeController.signal
            })
            .then(function(res) { return res.text(); })
            .then(function(html) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var newWrapper = doc.getElementById('attendance-table-wrapper');
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
                if (searchIcon) searchIcon.className = 'fas fa-search mr-1 text-violet-500';
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

        if (nameInput) {
            nameInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(performSearch, 300);
            });
            nameInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    performSearch();
                }
            });
        }

        if (dateInput) {
            dateInput.addEventListener('change', function() {
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (nameInput) {
                    nameInput.value = '';
                    clearBtn.classList.add('hidden');
                    nameInput.focus();
                }
                clearTimeout(debounceTimer);
                performSearch();
            });
        }

        bindPaginationLinks();
    })();
</script>
@endpush
