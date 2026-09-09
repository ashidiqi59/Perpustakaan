@extends('layouts.petugas')

@section('title', 'Scanner Barcode Utama')
@section('subtitle', 'Smart Scanner serbaguna: otomatis mendeteksi Presensi, Peminjaman, & Pengembalian')

@section('content')

    {{-- ALERT MESSAGES --}}
    @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-info-circle text-blue-500 text-base shrink-0"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle text-rose-500 text-base shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">
        <div class="bg-gradient-to-br from-violet-600 to-indigo-700 rounded-xl p-4 sm:p-5 shadow-md text-white col-span-2 sm:col-span-1">
            <p class="text-[11px] font-semibold text-violet-200 uppercase tracking-wider">Pengunjung Hari Ini</p>
            <h3 class="text-2xl font-bold mt-1" id="stat-today-attendance">
                {{ $todayAttendance }} <span class="text-xs font-normal text-violet-200">Orang</span>
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Scan Pinjam Hari Ini</p>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1" id="stat-today-loans">
                {{ $todayLoanScans }} <span class="text-xs font-normal text-slate-400">Buku</span>
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Scan Kembali Hari Ini</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-1" id="stat-today-returns">
                {{ $todayReturnScans }} <span class="text-xs font-normal text-slate-400">Buku</span>
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Pinjam</p>
            <h3 class="text-2xl font-bold text-amber-500 mt-1" id="stat-pending-loans">
                {{ $pendingLoans }} <span class="text-xs font-normal text-slate-400">Tiket</span>
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-slate-200/80 col-span-2 sm:col-span-1 lg:col-span-1">
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Kembali</p>
            <h3 class="text-2xl font-bold text-indigo-600 mt-1" id="stat-pending-returns">
                {{ $pendingReturns }} <span class="text-xs font-normal text-slate-400">Tiket</span>
            </h3>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- ══ SMART UNIVERSAL SCANNER (1 SCANNER UNTUK SEMUA JENIS BARCODE) ══ --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gradient-to-r from-amber-500/10 via-indigo-500/10 to-violet-500/10">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center text-slate-900 shadow-sm font-bold text-lg">
                    <i class="fas fa-qrcode"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-slate-800">Scanner Barcode Utama</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Cukup arahkan barcode apa saja ke scanner ini, sistem akan otomatis mengenali jenisnya
                    </p>
                </div>
            </div>

            {{-- Format Badges --}}
            <div class="flex flex-wrap items-center gap-1.5 text-xs font-medium">
                <span class="px-2.5 py-1 bg-violet-100 text-violet-700 rounded-lg text-[11px] font-semibold border border-violet-200" title="Check-In Presensi">
                    <i class="fas fa-id-card mr-1"></i> MEMBER-
                </span>
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[11px] font-semibold border border-emerald-200" title="Peminjaman Buku">
                    <i class="fas fa-book mr-1"></i> PINJAM-
                </span>
                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-lg text-[11px] font-semibold border border-blue-200" title="Pengembalian Buku">
                    <i class="fas fa-undo mr-1"></i> KEMBALI-
                </span>
            </div>
        </div>

        <div class="p-5 sm:p-6">
            <div class="max-w-2xl mx-auto">

                {{-- Toggle Kamera Button --}}
                <button onclick="toggleCamera()" id="btn-camera"
                    class="w-full py-4 mb-4 border-2 border-dashed border-amber-400 bg-amber-50/40 hover:bg-amber-50 rounded-2xl text-slate-800 text-sm font-bold transition-all duration-200 flex items-center justify-center gap-2.5 shadow-xs">
                    <i class="fas fa-camera text-amber-600 text-lg" id="camera-icon"></i>
                    <span id="camera-label">Aktifkan Kamera Scanner</span>
                </button>

                {{-- Camera Viewport --}}
                <div id="camera-container" style="display:none;" class="mb-4">
                    <div id="qr-reader" class="rounded-2xl overflow-hidden bg-slate-900 shadow-inner"></div>
                    <p class="text-xs text-slate-500 text-center mt-2.5 flex items-center justify-center gap-1.5">
                        <i class="fas fa-info-circle text-amber-600"></i> Kamera aktif. Arahkan ke kartu anggota atau tiket barcode peminjaman/pengembalian.
                    </p>
                </div>

                {{-- Manual Input Bar --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        <i class="fas fa-keyboard mr-1 text-slate-500"></i> Atau Masukkan Kode Barcode Manual:
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="manual-token"
                            class="flex-1 px-4 py-3 text-sm font-mono border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all shadow-xs"
                            placeholder="Contoh: MEMBER-5-..., PINJAM-1-..., atau KEMBALI-1-..."
                            autocomplete="off">
                        <button onclick="submitManual()" id="btn-submit"
                            class="px-6 py-3 bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-slate-900 font-bold text-sm rounded-xl transition-all shadow-sm flex items-center gap-2 shrink-0">
                            <i class="fas fa-magic"></i> Proses
                        </button>
                    </div>
                </div>

                {{-- Unified Scan Result Feedback Box --}}
                <div id="scan-result" class="mt-4 p-4 rounded-xl hidden transition-all duration-300">
                    <div id="scan-result-title" class="font-bold text-sm flex items-center gap-2 mb-1.5"></div>
                    <div id="scan-result-body" class="text-xs leading-relaxed"></div>
                    <div id="scan-result-card" class="hidden mt-3 pt-3 border-t"></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- ══ DUA TABEL LIVE: SIRKULASI TERAKHIR & PRESENSI HARI INI ══          --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ── TABEL 1: AKTIVITAS SIRKULASI BUKU TERBARU ── --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80 flex flex-col">
            <div class="px-4 sm:px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-book-reader text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Sirkulasi Buku Terbaru</h3>
                        <p class="text-xs text-slate-500">Aktivitas pinjam & kembali terkini</p>
                    </div>
                </div>
                <a href="{{ route('petugas.scanner.sirkulasi') }}"
                   class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left" id="table-circulation">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3 hidden sm:table-cell">Buku</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs" id="circulation-tbody">
                        @forelse($recentScans as $scan)
                            @php
                                $isReturnScan = $scan->return_barcode_scanned_at !== null
                                    && ($scan->loan_barcode_scanned_at === null
                                        || $scan->return_barcode_scanned_at >= $scan->loan_barcode_scanned_at);
                                $scanTime = $isReturnScan
                                    ? $scan->return_barcode_scanned_at
                                    : $scan->loan_barcode_scanned_at;
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-800">{{ $scan->user?->name ?? '-' }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono">{{ $scan->user?->npm ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <p class="text-slate-700 font-medium line-clamp-1 max-w-[150px]">{{ $scan->book?->title ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($isReturnScan)
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]">
                                            <i class="fas fa-undo text-[9px]"></i> Kembali
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]">
                                            <i class="fas fa-book text-[9px]"></i> Pinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                    <i class="fas fa-clock mr-1 text-slate-400"></i>{{ $scanTime ? $scanTime->format('H:i') . ' WIB' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr id="circulation-empty">
                                <td colspan="4" class="p-6 text-center text-slate-400">
                                    <i class="fas fa-inbox text-2xl mb-2 text-slate-300 block"></i>
                                    <p class="text-xs text-slate-500">Belum ada aktivitas sirkulasi hari ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── TABEL 2: PRESENSI PENGUNJUNG HARI INI ── --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80 flex flex-col">
            <div class="px-4 sm:px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-violet-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-users text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Check-In Hari Ini</h3>
                        <p class="text-xs text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs rounded-full font-bold" id="badge-attendance-count">
                        {{ $todayAttendance }} Orang
                    </span>
                    <a href="{{ route('petugas.scanner.presensi') }}"
                       class="text-xs font-semibold text-violet-600 hover:text-violet-800 flex items-center gap-1">
                        Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left" id="table-attendance">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600">
                        <tr>
                            <th class="px-4 py-3">Anggota</th>
                            <th class="px-4 py-3 hidden sm:table-cell">NPM / Prodi</th>
                            <th class="px-4 py-3">Jam Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs" id="attendance-tbody">
                        @forelse($recentAttendances as $attendance)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $attendance->user?->getAvatarUrl() }}"
                                             alt="{{ $attendance->user?->name }}"
                                             class="w-7 h-7 rounded-lg object-cover flex-shrink-0 border border-slate-200">
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $attendance->user?->name ?? '-' }}</p>
                                            <p class="text-[10px] text-slate-400 sm:hidden">{{ $attendance->user?->npm ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <p class="text-slate-700 font-mono font-medium">{{ $attendance->user?->npm ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ $attendance->user?->prodi ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]">
                                        <i class="fas fa-clock text-[9px]"></i> {{ $attendance->scanned_at->format('H:i') }} WIB
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr id="attendance-empty">
                                <td colspan="3" class="p-6 text-center text-slate-400">
                                    <i class="fas fa-users text-2xl mb-2 text-slate-300 block"></i>
                                    <p class="text-xs text-slate-500">Belum ada pengunjung yang check-in hari ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('styles')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@push('scripts')
<script>
let cameraActive = false;
let html5QrCode = null;

// ── CAMERA CONTROLS ──
function toggleCamera() {
    cameraActive ? stopCamera() : startCamera();
}

function startCamera() {
    document.getElementById('camera-container').style.display = 'block';
    document.getElementById('camera-icon').className = 'fas fa-stop-circle text-rose-600';
    document.getElementById('camera-label').textContent = 'Matikan Kamera Scanner';
    cameraActive = true;

    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
            stopCamera();
            processSmartBarcode(decodedText);
        },
        () => {}
    ).catch(err => {
        showFeedback(false, 'Gagal mengaktifkan kamera: ' + err);
        stopCamera();
    });
}

function stopCamera() {
    if (html5QrCode) {
        html5QrCode.stop().catch(() => {});
        html5QrCode = null;
    }
    document.getElementById('camera-container').style.display = 'none';
    document.getElementById('camera-icon').className = 'fas fa-camera text-amber-600';
    document.getElementById('camera-label').textContent = 'Aktifkan Kamera Scanner';
    cameraActive = false;
}

// ── MANUAL INPUT ──
function submitManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) {
        showFeedback(false, 'Kode barcode tidak boleh kosong!');
        return;
    }
    processSmartBarcode(token);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('manual-token').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitManual();
    });
});

// ── SMART UNIVERSAL BARCODE PROCESSOR ──
async function processSmartBarcode(rawToken) {
    const token = rawToken.trim();
    const btn = document.getElementById('btn-submit');
    const originalBtn = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    // 1. AUTO DETECT: PRESENSI ANGGOTA (MEMBER-)
    if (token.startsWith('MEMBER-')) {
        try {
            const res = await fetch('{{ route("petugas.api.scan-member") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ code: token }),
            });
            const data = await res.json();

            showFeedback(
                data.success,
                data.message,
                '',
                data.user,
                data.already_in,
                'member'
            );
            document.getElementById('manual-token').value = '';

            if (data.success && data.user) {
                prependAttendanceRow(data.user);
                incrementAttendanceCounter();
            }
        } catch (e) {
            showFeedback(false, 'Terjadi kesalahan koneksi saat memproses presensi.');
        } finally {
            btn.innerHTML = originalBtn;
            btn.disabled = false;
        }
        return;
    }

    // 2. AUTO DETECT: SIRKULASI (PINJAM- ATAU KEMBALI-)
    if (token.startsWith('PINJAM-') || token.startsWith('KEMBALI-')) {
        const type = token.startsWith('PINJAM-') ? 'loan' : 'return';
        try {
            const res = await fetch('{{ route("petugas.api.scan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ token, type }),
            });
            const data = await res.json();

            showFeedback(
                data.success,
                data.message,
                '',
                data.loan,
                false,
                data.type || type
            );
            document.getElementById('manual-token').value = '';

            if (data.success && data.loan) {
                prependCirculationRow(data);
                incrementCirculationCounter(data.type || type);
            }
        } catch (e) {
            showFeedback(false, 'Terjadi kesalahan koneksi saat memproses sirkulasi buku.');
        } finally {
            btn.innerHTML = originalBtn;
            btn.disabled = false;
        }
        return;
    }

    // 3. FORMAT TIDAK DIKENALI
    showFeedback(
        false,
        'Format barcode tidak dikenali!',
        'Sistem otomatis mendukung 3 jenis barcode:<br>' +
        '&bull; <strong class="font-mono text-violet-600">MEMBER-...</strong> untuk Presensi Anggota<br>' +
        '&bull; <strong class="font-mono text-emerald-600">PINJAM-...</strong> untuk Peminjaman Buku<br>' +
        '&bull; <strong class="font-mono text-blue-600">KEMBALI-...</strong> untuk Pengembalian Buku'
    );
    btn.innerHTML = originalBtn;
    btn.disabled = false;
}

// ── FEEDBACK ALERT COMPONENT ──
function showFeedback(success, title, body = '', entityData = null, alreadyIn = false, mode = 'generic') {
    const box      = document.getElementById('scan-result');
    const titleEl  = document.getElementById('scan-result-title');
    const bodyEl   = document.getElementById('scan-result-body');
    const cardEl   = document.getElementById('scan-result-card');

    let borderColor, bgColor, textColor, icon;
    if (success) {
        textColor = 'text-emerald-800';
        icon = '<i class="fas fa-check-circle text-emerald-600 text-lg"></i>';
        borderColor = 'border-emerald-200';
        bgColor = 'bg-emerald-50';
    } else if (alreadyIn) {
        textColor = 'text-amber-800';
        icon = '<i class="fas fa-exclamation-triangle text-amber-600 text-lg"></i>';
        borderColor = 'border-amber-200';
        bgColor = 'bg-amber-50';
    } else {
        textColor = 'text-rose-800';
        icon = '<i class="fas fa-times-circle text-rose-600 text-lg"></i>';
        borderColor = 'border-rose-200';
        bgColor = 'bg-rose-50';
    }

    box.className = `mt-4 p-4 rounded-2xl ${bgColor} border ${borderColor} shadow-sm block`;
    titleEl.className = `font-bold text-sm sm:text-base flex items-center gap-2 ${textColor} mb-1`;
    titleEl.innerHTML = icon + ' ' + title;

    if (body) {
        bodyEl.style.display = 'block';
        bodyEl.innerHTML = body;
    } else {
        bodyEl.style.display = 'none';
    }

    // Detail card rendering
    if (entityData) {
        cardEl.className = `mt-3 pt-3 border-t ${borderColor} flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-700`;
        cardEl.style.display = 'flex';

        if (mode === 'member') {
            // Visitor Check-In Card
            cardEl.innerHTML = `
                <div class="flex items-center gap-3">
                    <img src="${entityData.avatar}" alt="${entityData.name}" class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                    <div>
                        <p class="font-bold text-slate-900 text-sm">${entityData.name}</p>
                        <p class="text-xs text-slate-500 font-mono">${entityData.npm || '-'} &bull; ${entityData.prodi || 'Anggota'}</p>
                    </div>
                </div>
                <div class="flex sm:flex-col sm:items-end justify-between">
                    <span class="px-2.5 py-1 bg-violet-100 text-violet-800 rounded-full font-bold text-[11px]">PRESENSI ANGGOTA</span>
                    <span class="text-slate-500 text-[11px] mt-0.5"><i class="fas fa-clock mr-1"></i>${entityData.scanned_at || 'Baru Saja'}</span>
                </div>
            `;
        } else {
            // Book Loan or Return Card
            const isReturn = mode === 'return';
            cardEl.innerHTML = `
                <div class="space-y-1 min-w-0">
                    <div class="font-bold text-slate-900 text-sm truncate max-w-sm"><i class="fas fa-book text-indigo-500 mr-1.5"></i>${entityData.book}</div>
                    <div class="text-xs text-slate-600">Peminjam: <strong>${entityData.user}</strong> (${entityData.npm || '-'})</div>
                    ${entityData.due_date ? `<div class="text-[11px] text-slate-500">Tenggat: ${entityData.due_date}</div>` : ''}
                </div>
                <div class="flex sm:flex-col sm:items-end justify-between">
                    <span class="px-2.5 py-1 ${isReturn ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800'} rounded-full font-bold text-[11px]">
                        ${isReturn ? 'PENGEMBALIAN BUKU' : 'PEMINJAMAN AKTIF'}
                    </span>
                    <span class="text-slate-500 text-[11px] mt-0.5">Sirkulasi Berhasil</span>
                </div>
            `;
        }
    } else {
        cardEl.style.display = 'none';
    }

    clearTimeout(window._smartScanTimer);
    window._smartScanTimer = setTimeout(() => {
        box.classList.add('hidden');
    }, 12000);
}

// ── PREPEND ROW HELPERS ──
function prependAttendanceRow(user) {
    const tbody = document.getElementById('attendance-tbody');
    const empty = document.getElementById('attendance-empty');
    if (empty) empty.style.display = 'none';
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-slate-50 transition-colors bg-violet-50/80';
    tr.innerHTML = `
        <td class="px-4 py-3">
            <div class="flex items-center gap-2.5">
                <img src="${user.avatar}" alt="${user.name}" class="w-7 h-7 rounded-lg object-cover flex-shrink-0 border border-slate-200">
                <div>
                    <p class="font-semibold text-slate-800">${user.name}</p>
                    <p class="text-[10px] text-slate-400 sm:hidden">${user.npm || '-'}</p>
                </div>
            </div>
        </td>
        <td class="px-4 py-3 hidden sm:table-cell">
            <p class="text-slate-700 font-mono font-medium">${user.npm || '-'}</p>
            <p class="text-[10px] text-slate-400 truncate max-w-[120px]">${user.prodi || ''}</p>
        </td>
        <td class="px-4 py-3 whitespace-nowrap">
            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]">
                <i class="fas fa-clock text-[9px]"></i> ${user.scanned_at || 'Baru Saja'}
            </span>
        </td>
    `;
    tbody.prepend(tr);
    setTimeout(() => tr.classList.remove('bg-violet-50/80'), 3000);
}

function prependCirculationRow(data) {
    const tbody = document.getElementById('circulation-tbody');
    const empty = document.getElementById('circulation-empty');
    if (empty) empty.style.display = 'none';
    if (!tbody || !data.loan) return;

    const isReturn = data.type === 'return';
    const now = new Date();
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-slate-50 transition-colors bg-indigo-50/80';
    tr.innerHTML = `
        <td class="px-4 py-3">
            <p class="font-semibold text-slate-800">${data.loan.user}</p>
            <p class="text-[11px] text-slate-400 font-mono">${data.loan.npm || '-'}</p>
        </td>
        <td class="px-4 py-3 hidden sm:table-cell">
            <p class="text-slate-700 font-medium line-clamp-1 max-w-[150px]">${data.loan.book}</p>
        </td>
        <td class="px-4 py-3 whitespace-nowrap">
            ${isReturn
                ? '<span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]"><i class="fas fa-undo text-[9px]"></i> Kembali</span>'
                : '<span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1 text-[11px]"><i class="fas fa-book text-[9px]"></i> Pinjam</span>'
            }
        </td>
        <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
            <i class="fas fa-clock mr-1 text-slate-400"></i>${timeStr}
        </td>
    `;
    tbody.prepend(tr);
    setTimeout(() => tr.classList.remove('bg-indigo-50/80'), 3000);
}

function incrementAttendanceCounter() {
    const badge = document.getElementById('badge-attendance-count');
    const stat = document.getElementById('stat-today-attendance');
    if (badge) {
        const current = parseInt(badge.textContent) || 0;
        badge.textContent = (current + 1) + ' Orang';
    }
    if (stat) {
        const current = parseInt(stat.textContent) || 0;
        stat.innerHTML = (current + 1) + ' <span class="text-xs font-normal text-violet-200">Orang</span>';
    }
}

function incrementCirculationCounter(type) {
    if (type === 'loan') {
        const el = document.getElementById('stat-today-loans');
        if (el) {
            const current = parseInt(el.textContent) || 0;
            el.innerHTML = (current + 1) + ' <span class="text-xs font-normal text-slate-400">Buku</span>';
        }
    } else if (type === 'return') {
        const el = document.getElementById('stat-today-returns');
        if (el) {
            const current = parseInt(el.textContent) || 0;
            el.innerHTML = (current + 1) + ' <span class="text-xs font-normal text-slate-400">Buku</span>';
        }
    }
}
</script>
@endpush
