@extends('layouts.petugas')

@section('title', 'Scanner Barcode')
@section('subtitle', 'Scan barcode peminjaman & pengembalian buku')

@section('content')

    {{-- ALERT MESSAGES --}}
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
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-yellow-400">
            <div class="flex justify-between items-center">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-slate-500">Menunggu Konfirmasi Pinjam</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $pendingLoans }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-clock text-yellow-500 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-center">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-slate-500">Menunggu Konfirmasi Kembali</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $pendingReturns }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-undo-alt text-indigo-500 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-slate-500">Scan Pinjam Hari Ini</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $todayLoanScans }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-box-open text-green-500 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-amber-500">
            <div class="flex justify-between items-center">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm text-slate-500">Scan Kembali Hari Ini</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $todayReturnScans }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-redo text-amber-500 text-lg sm:text-xl"></i>
                </div>
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
@endpush
