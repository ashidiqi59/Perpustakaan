@extends('layouts.petugas')

@section('title', 'Scanner Barcode')
@section('subtitle', 'Scan barcode peminjaman & pengembalian buku')

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
    @if(session('warning'))
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-triangle text-amber-500 text-base shrink-0"></i>
            <span>{{ session('warning') }}</span>
        </div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('scan_success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('scan_success') }}
        </div>
    @endif
    @if(session('scan_error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            {{ session('scan_error') }}
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Pinjam</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $pendingLoans }} <span class="text-sm font-normal text-slate-400">Transaksi</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Kembali</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $pendingReturns }} <span class="text-sm font-normal text-slate-400">Transaksi</span></h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-undo-alt text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Scan Pinjam Hari Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $todayLoanScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-box-open text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Scan Kembali Hari Ini</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $todayReturnScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-redo text-xl"></i>
            </div>
        </div>

        {{-- Card baru: Pengunjung Hari Ini --}}
        <div class="bg-gradient-to-br from-violet-600 to-indigo-700 rounded-xl p-5 shadow-md flex items-center justify-between transition-all duration-200 hover:shadow-lg">
            <div>
                <p class="text-xs font-semibold text-violet-200 uppercase tracking-wider">Pengunjung Hari Ini</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $todayAttendance }} <span class="text-sm font-normal text-violet-300">Orang</span></h3>
            </div>
            <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
    </div>

    {{-- MAIN GRID: SCANNER + HISTORY --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ══ PANEL SCANNER ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-500 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-qrcode text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Scanner QR Code</h3>
                    <p class="text-xs text-slate-500">Scan atau input token barcode pengunjung</p>
                </div>
            </div>
            <div class="p-4 sm:p-6">

                {{-- Auto Detect Badge --}}
                <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 border border-indigo-200 text-indigo-600 text-xs font-semibold rounded-full">
                        <i class="fas fa-magic text-xs"></i> Auto Detect
                    </span>
                    <span class="text-xs text-slate-400 ml-2">Token terdeteksi otomatis</span>
                </div>

                {{-- Toggle Kamera --}}
                <button onclick="toggleCamera()" id="btn-camera"
                    class="w-full py-3 mb-4 border-2 border-dashed border-indigo-300 rounded-xl text-indigo-600 text-sm font-medium hover:bg-indigo-50 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-camera" id="camera-icon"></i>
                    <span id="camera-label">Aktifkan Kamera Scanner</span>
                </button>

                {{-- Area Kamera --}}
                <div id="camera-container" style="display:none;" class="mb-4">
                    <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900"></div>
                    <p class="text-xs text-slate-400 text-center mt-2">
                        <i class="fas fa-info-circle"></i> Arahkan kamera ke QR barcode pengunjung
                    </p>
                </div>

                {{-- Input Manual --}}
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">
                        <i class="fas fa-keyboard mr-1"></i> Atau masukkan token manual:
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="manual-token"
                            class="flex-1 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: PINJAM-12-1234567890-ABCD1234..."
                            autocomplete="off">
                        <button onclick="submitManual()" id="btn-submit"
                            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5">
                            <i class="fas fa-search"></i> Scan
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Token <span class="font-mono text-indigo-500 font-semibold">PINJAM-</span> untuk pinjam,
                        <span class="font-mono text-indigo-500 font-semibold">KEMBALI-</span> untuk pengembalian
                    </p>
                </div>

                {{-- Hasil Scan --}}
                <div id="scan-result" class="mt-4 p-4 rounded-xl hidden">
                    <div id="scan-result-title" class="font-semibold text-sm flex items-center gap-2 mb-1"></div>
                    <div id="scan-result-body" class="text-xs text-slate-600 leading-relaxed"></div>
                </div>

            </div>
        </div>

        {{-- ══ AKTIVITAS SCAN TERBARU ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center gap-3">
                <div class="w-9 h-9 bg-green-500 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-history text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Aktivitas Scan Terbaru</h3>
                    <p class="text-xs text-slate-500">20 scan terakhir yang diproses</p>
                </div>
            </div>

            @if($recentScans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Pengunjung</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 hidden md:table-cell">Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentScans as $scan)
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
                                        <p class="font-medium text-slate-800 text-xs">{{ $scan->user?->name ?? '-' }}</p>
                                        <p class="text-xs text-slate-400">{{ $scan->user?->npm ?? '' }}</p>
                                    </td>
                                    <td class="px-4 py-3 hidden md:table-cell">
                                        <p class="text-xs text-slate-700 truncate max-w-[140px]">{{ $scan->book?->title ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($isReturnScan)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium whitespace-nowrap">
                                                <i class="fas fa-undo"></i> Kembali
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full font-medium whitespace-nowrap">
                                                <i class="fas fa-book"></i> Pinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-400 whitespace-nowrap">
                                        {{ $scanTime ? $scanTime->diffForHumans() : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-inbox text-slate-400 text-xl"></i>
                    </div>
                    <p class="text-sm text-slate-500">Belum ada aktivitas scan hari ini.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- PANEL PRESENSI ANGGOTA                                                --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    <div class="mt-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-600 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Presensi / Check-In Anggota</h3>
                    <p class="text-xs text-slate-500">Scan kartu anggota saat pengunjung tiba di perpustakaan</p>
                </div>
            </div>
            <a href="{{ route('petugas.attendance.history') }}"
               class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-violet-600 bg-violet-50 hover:bg-violet-100 border border-violet-200 rounded-lg transition-colors">
                <i class="fas fa-list"></i> Riwayat Lengkap
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ── SCANNER KARTU ANGGOTA ── --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-violet-100">
                <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center gap-3"
                     style="background: linear-gradient(135deg, #7C3AED10, #4F46E510);">
                    <div class="w-9 h-9 bg-violet-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-qrcode text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">Scanner Kartu Anggota</h3>
                        <p class="text-xs text-slate-500">Scan barcode <span class="font-mono text-violet-600 font-bold">MEMBER-</span> untuk check-in</p>
                    </div>
                </div>
                <div class="p-4 sm:p-6">

                    {{-- Badge --}}
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-50 border border-violet-200 text-violet-600 text-xs font-semibold rounded-full">
                            <i class="fas fa-id-card text-xs"></i> Kartu Anggota Mode
                        </span>
                        <span class="text-xs text-slate-400 ml-2">1x check-in per hari per anggota</span>
                    </div>

                    {{-- Toggle Kamera --}}
                    <button onclick="toggleMemberCamera()" id="btn-member-camera"
                        class="w-full py-3 mb-4 border-2 border-dashed border-violet-300 rounded-xl text-violet-600 text-sm font-medium hover:bg-violet-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-camera" id="member-camera-icon"></i>
                        <span id="member-camera-label">Aktifkan Kamera Scanner</span>
                    </button>

                    {{-- Area Kamera --}}
                    <div id="member-camera-container" style="display:none;" class="mb-4">
                        <div id="member-qr-reader" class="rounded-xl overflow-hidden bg-slate-900"></div>
                        <p class="text-xs text-slate-400 text-center mt-2">
                            <i class="fas fa-info-circle"></i> Arahkan kamera ke QR Code kartu anggota
                        </p>
                    </div>

                    {{-- Input Manual --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1.5">
                            <i class="fas fa-keyboard mr-1"></i> Atau masukkan kode manual:
                        </label>
                        <div class="flex gap-2">
                            <input type="text" id="member-token-input"
                                class="flex-1 px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500"
                                placeholder="Contoh: MEMBER-5-ABCD1234"
                                autocomplete="off">
                            <button onclick="submitMemberScan()" id="btn-member-submit"
                                class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5">
                                <i class="fas fa-check-circle"></i> Check-In
                            </button>
                        </div>
                        <p class="text-xs text-slate-400 mt-1.5">
                            Kode dimulai dengan <span class="font-mono text-violet-500 font-semibold">MEMBER-</span>
                        </p>
                    </div>

                    {{-- Hasil Scan --}}
                    <div id="member-scan-result" class="mt-4 hidden">
                        {{-- Diisi oleh JS --}}
                    </div>

                </div>
            </div>

            {{-- ── DAFTAR CHECK-IN HARI INI ── --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-emerald-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-clipboard-check text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-slate-800">Check-In Hari Ini</h3>
                            <p class="text-xs text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs font-bold rounded-full">
                        {{ $todayAttendance }} Orang
                    </span>
                </div>

                @if($recentAttendances->count() > 0)
                    <div id="attendance-list" class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Anggota</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 hidden sm:table-cell">NPM / Prodi</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600">Jam Masuk</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="attendance-tbody">
                                @foreach($recentAttendances as $attendance)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <img src="{{ $attendance->user?->getAvatarUrl() }}"
                                                 alt="{{ $attendance->user?->name }}"
                                                 class="w-7 h-7 rounded-lg object-cover flex-shrink-0">
                                            <p class="font-medium text-slate-800 text-xs">{{ $attendance->user?->name ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 hidden sm:table-cell">
                                        <p class="text-xs text-slate-600 font-mono">{{ $attendance->user?->npm ?? '-' }}</p>
                                        <p class="text-[10px] text-slate-400 truncate max-w-[120px]">{{ $attendance->user?->prodi ?? '' }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-semibold whitespace-nowrap">
                                            <i class="fas fa-clock mr-1"></i>{{ $attendance->scanned_at->format('H:i') }} WIB
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($todayAttendance > 10)
                        <div class="px-4 py-3 text-center border-t border-slate-100">
                            <a href="{{ route('petugas.attendance.history') }}" class="text-xs text-violet-600 hover:underline font-medium">
                                Lihat semua {{ $todayAttendance }} pengunjung →
                            </a>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="p-8 text-center" id="attendance-empty">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-users text-slate-400 text-xl"></i>
                        </div>
                        <p class="text-sm text-slate-500">Belum ada pengunjung yang check-in hari ini.</p>
                        <p class="text-xs text-slate-400 mt-1">Scan kartu anggota untuk mencatat kehadiran.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection

@push('styles')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@push('scripts')
<script>
// ── STATE ──
let cameraActive = false;
let html5QrCode = null;

// ── CAMERA ──
function toggleCamera() {
    cameraActive ? stopCamera() : startCamera();
}

function startCamera() {
    document.getElementById('camera-container').style.display = 'block';
    document.getElementById('camera-icon').className = 'fas fa-stop-circle';
    document.getElementById('camera-label').textContent = 'Matikan Kamera';
    cameraActive = true;

    html5QrCode = new Html5Qrcode("qr-reader");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
            stopCamera();
            processToken(decodedText);
        },
        () => {}
    ).catch(err => {
        showResult(false, 'Gagal akses kamera: ' + err);
        stopCamera();
    });
}

function stopCamera() {
    if (html5QrCode) { html5QrCode.stop().catch(() => {}); html5QrCode = null; }
    document.getElementById('camera-container').style.display = 'none';
    document.getElementById('camera-icon').className = 'fas fa-camera';
    document.getElementById('camera-label').textContent = 'Aktifkan Kamera Scanner';
    cameraActive = false;
}

// ── MANUAL INPUT ──
function submitManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) { showResult(false, 'Token tidak boleh kosong!'); return; }
    processToken(token);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('manual-token').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitManual();
    });
});

// ── PROCESS TOKEN ──
async function processToken(token) {
    const btn = document.getElementById('btn-submit');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    let type;
    if (token.startsWith('PINJAM-'))        type = 'loan';
    else if (token.startsWith('KEMBALI-'))  type = 'return';
    else {
        showResult(false, '❌ Format token tidak dikenali. Pastikan dimulai dengan PINJAM- atau KEMBALI-');
        btn.innerHTML = '<i class="fas fa-search"></i> Scan'; btn.disabled = false;
        return;
    }

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

        if (data.success) {
            let body = '';
            if (data.loan) {
                body = `<strong>Buku:</strong> ${data.loan.book}<br>
                        <strong>Peminjam:</strong> ${data.loan.user} (${data.loan.npm || '-'})<br>
                        <strong>Tenggat:</strong> ${data.loan.due_date}`;
            }
            showResult(true, data.message, body);
            document.getElementById('manual-token').value = '';
            setTimeout(() => location.reload(), 3000);
        } else {
            let body = '';
            if (data.loan) {
                body = `<strong>Buku:</strong> ${data.loan.book}<br>
                        <strong>Peminjam:</strong> ${data.loan.user}<br>
                        <strong>Status:</strong> ${data.loan.status}`;
            }
            showResult(false, data.message, body);
        }
    } catch (e) {
        showResult(false, 'Terjadi kesalahan koneksi. Coba lagi.');
    } finally {
        btn.innerHTML = '<i class="fas fa-search"></i> Scan';
        btn.disabled = false;
    }
}

// ── SHOW RESULT ──
function showResult(success, title, body = '') {
    const box   = document.getElementById('scan-result');
    const titleEl = document.getElementById('scan-result-title');
    const bodyEl  = document.getElementById('scan-result-body');

    box.className = success
        ? 'mt-4 p-4 rounded-xl bg-green-50 border border-green-200'
        : 'mt-4 p-4 rounded-xl bg-red-50 border border-red-200';

    const icon = success
        ? '<i class="fas fa-check-circle text-green-500"></i>'
        : '<i class="fas fa-times-circle text-red-500"></i>';

    titleEl.className = success ? 'font-semibold text-sm flex items-center gap-2 mb-1 text-green-700' : 'font-semibold text-sm flex items-center gap-2 mb-1 text-red-700';
    titleEl.innerHTML = icon + ' ' + title;
    bodyEl.innerHTML  = body;

    clearTimeout(window._resultTimer);
    window._resultTimer = setTimeout(() => { box.className = box.className + ' hidden'; }, 8000);
}
</script>

<script>
// ══════════════════════════════════════════════
// MEMBER BARCODE SCANNER (Presensi/Check-In)
// ══════════════════════════════════════════════

let memberCameraActive = false;
let memberQrCode = null;

function toggleMemberCamera() {
    memberCameraActive ? stopMemberCamera() : startMemberCamera();
}

function startMemberCamera() {
    document.getElementById('member-camera-container').style.display = 'block';
    document.getElementById('member-camera-icon').className = 'fas fa-stop-circle';
    document.getElementById('member-camera-label').textContent = 'Matikan Kamera';
    memberCameraActive = true;

    memberQrCode = new Html5Qrcode("member-qr-reader");
    memberQrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
            stopMemberCamera();
            processMemberCode(decodedText);
        },
        () => {}
    ).catch(err => {
        showMemberResult(false, 'Gagal akses kamera: ' + err);
        stopMemberCamera();
    });
}

function stopMemberCamera() {
    if (memberQrCode) { memberQrCode.stop().catch(() => {}); memberQrCode = null; }
    document.getElementById('member-camera-container').style.display = 'none';
    document.getElementById('member-camera-icon').className = 'fas fa-camera';
    document.getElementById('member-camera-label').textContent = 'Aktifkan Kamera Scanner';
    memberCameraActive = false;
}

function submitMemberScan() {
    const code = document.getElementById('member-token-input').value.trim();
    if (!code) { showMemberResult(false, 'Kode tidak boleh kosong!'); return; }
    processMemberCode(code);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('member-token-input').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitMemberScan();
    });
});

async function processMemberCode(code) {
    const btn = document.getElementById('btn-member-submit');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    if (!code.startsWith('MEMBER-')) {
        showMemberResult(false, '❌ Format kode tidak valid. Gunakan kartu anggota perpustakaan.');
        btn.innerHTML = '<i class="fas fa-check-circle"></i> Check-In';
        btn.disabled = false;
        return;
    }

    try {
        const res = await fetch('{{ route("petugas.api.scan-member") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ code }),
        });
        const data = await res.json();

        showMemberResult(data.success, data.message, data.user, data.already_in);
        document.getElementById('member-token-input').value = '';

        // Jika berhasil check-in, tambahkan baris baru ke tabel tanpa reload
        if (data.success && data.user) {
            prependAttendanceRow(data.user);
        }

    } catch (e) {
        showMemberResult(false, 'Terjadi kesalahan koneksi. Coba lagi.');
    } finally {
        btn.innerHTML = '<i class="fas fa-check-circle"></i> Check-In';
        btn.disabled = false;
    }
}

function showMemberResult(success, message, user = null, alreadyIn = false) {
    const box = document.getElementById('member-scan-result');

    let color, icon, borderColor, bgColor;
    if (success) {
        color = 'text-emerald-700'; icon = 'fas fa-check-circle text-emerald-500';
        borderColor = 'border-emerald-200'; bgColor = 'bg-emerald-50';
    } else if (alreadyIn) {
        color = 'text-amber-700'; icon = 'fas fa-exclamation-circle text-amber-500';
        borderColor = 'border-amber-200'; bgColor = 'bg-amber-50';
    } else {
        color = 'text-red-700'; icon = 'fas fa-times-circle text-red-500';
        borderColor = 'border-red-200'; bgColor = 'bg-red-50';
    }

    let userHtml = '';
    if (user) {
        userHtml = `
        <div class="mt-3 flex items-center gap-3 pt-3 border-t ${borderColor}">
            <img src="${user.avatar}" alt="${user.name}" class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
            <div>
                <p class="text-sm font-bold ${color}">${user.name}</p>
                <p class="text-xs text-slate-500">${user.npm || ''} ${user.prodi ? '· ' + user.prodi : ''}</p>
                ${user.scanned_at ? `<p class="text-xs text-slate-400 mt-0.5"><i class="fas fa-clock mr-1"></i>${user.scanned_at}</p>` : ''}
            </div>
        </div>`;
    }

    box.className = `mt-4 p-4 rounded-xl ${bgColor} border ${borderColor}`;
    box.innerHTML = `
        <div class="flex items-start gap-2">
            <i class="${icon} mt-0.5 flex-shrink-0"></i>
            <p class="text-sm font-semibold ${color}">${message}</p>
        </div>
        ${userHtml}
    `;

    clearTimeout(window._memberResultTimer);
    window._memberResultTimer = setTimeout(() => { box.classList.add('hidden'); }, 10000);
}

function prependAttendanceRow(user) {
    // Sembunyikan empty state jika ada
    const empty = document.getElementById('attendance-empty');
    if (empty) empty.style.display = 'none';

    const tbody = document.getElementById('attendance-tbody');
    if (!tbody) return;

    const now = new Date();
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-slate-50 transition-colors bg-emerald-50 animate-pulse';
    tr.innerHTML = `
        <td class="px-4 py-3">
            <div class="flex items-center gap-2.5">
                <img src="${user.avatar}" alt="${user.name}" class="w-7 h-7 rounded-lg object-cover flex-shrink-0">
                <p class="font-medium text-slate-800 text-xs">${user.name}</p>
            </div>
        </td>
        <td class="px-4 py-3 hidden sm:table-cell">
            <p class="text-xs text-slate-600 font-mono">${user.npm || '-'}</p>
            <p class="text-[10px] text-slate-400 truncate max-w-[120px]">${user.prodi || ''}</p>
        </td>
        <td class="px-4 py-3">
            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-semibold whitespace-nowrap">
                <i class="fas fa-clock mr-1"></i>${user.scanned_at ? user.scanned_at : timeStr}
            </span>
        </td>
    `;
    tbody.prepend(tr);

    // Stop pulse animation after 2 seconds
    setTimeout(() => { tr.classList.remove('bg-emerald-50', 'animate-pulse'); }, 2000);
}
</script>
@endpush
