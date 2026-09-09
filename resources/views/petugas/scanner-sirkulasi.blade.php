@extends('layouts.petugas')

@section('title', 'Scanner Peminjaman & Pengembalian')
@section('subtitle', 'Scan dan validasi sirkulasi buku (Barcode PINJAM & KEMBALI)')

@section('content')

    {{-- ALERT NOTIFICATIONS --}}
    @if(session('scan_success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-base shrink-0"></i>
            <span>{{ session('scan_success') }}</span>
        </div>
    @endif
    @if(session('scan_error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-4 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle text-rose-500 text-base shrink-0"></i>
            <span>{{ session('scan_error') }}</span>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Pinjam</p>
                <h3 class="text-2xl font-bold text-amber-500 mt-1" id="stat-pending-loans">{{ $pendingLoans }} <span class="text-sm font-normal text-slate-400">Transaksi</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Kembali</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1" id="stat-pending-returns">{{ $pendingReturns }} <span class="text-sm font-normal text-slate-400">Transaksi</span></h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-undo-alt text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Scan Pinjam Hari Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1" id="stat-today-loans">{{ $todayLoanScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-box-open text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Scan Kembali Hari Ini</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1" id="stat-today-returns">{{ $todayReturnScans }} <span class="text-sm font-normal text-slate-400">Buku</span></h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-redo text-xl"></i>
            </div>
        </div>
    </div>

    {{-- MAIN GRID: SCANNER + ACTIVITY TABLE --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ══ PANEL SCANNER SIRKULASI ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-gradient-to-r from-indigo-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-qrcode text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Scanner Peminjaman & Pengembalian</h3>
                        <p class="text-xs text-slate-500">Scan QR Code tiket pinjam atau kembali pengunjung</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full font-semibold">
                    Mode Sirkulasi
                </span>
            </div>

            <div class="p-4 sm:p-6">
                {{-- Toggle Kamera --}}
                <button onclick="toggleCamera()" id="btn-camera"
                    class="w-full py-3.5 mb-4 border-2 border-dashed border-indigo-300 rounded-xl text-indigo-600 text-sm font-semibold hover:bg-indigo-50 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-camera" id="camera-icon"></i>
                    <span id="camera-label">Aktifkan Kamera Scanner</span>
                </button>

                {{-- Area Kamera --}}
                <div id="camera-container" style="display:none;" class="mb-4">
                    <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900 shadow-inner"></div>
                    <p class="text-xs text-slate-500 text-center mt-2 flex items-center justify-center gap-1.5">
                        <i class="fas fa-info-circle text-indigo-500"></i> Arahkan kamera ke barcode PINJAM- atau KEMBALI-
                    </p>
                </div>

                {{-- Input Manual --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        <i class="fas fa-keyboard mr-1 text-slate-500"></i> Input Kode Barcode Manual:
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="manual-token"
                            class="flex-1 px-3.5 py-2.5 text-sm font-mono border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: PINJAM-1-ABC... atau KEMBALI-1-XYZ..."
                            autocomplete="off">
                        <button onclick="submitManual()" id="btn-submit"
                            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-1.5 shadow-sm">
                            <i class="fas fa-search"></i> Proses
                        </button>
                    </div>
                </div>

                {{-- Hasil Scan Alert Box --}}
                <div id="scan-result" class="mt-4 p-4 rounded-xl hidden transition-all duration-300">
                    <div id="scan-result-title" class="font-semibold text-sm flex items-center gap-2 mb-1.5"></div>
                    <div id="scan-result-body" class="text-xs text-slate-700 leading-relaxed bg-white/70 p-3 rounded-lg border border-slate-200"></div>
                </div>

            </div>
        </div>

        {{-- ══ AKTIVITAS SCAN SIRKULASI TERBARU ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80 flex flex-col">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-history text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Aktivitas Scan Sirkulasi</h3>
                        <p class="text-xs text-slate-500">20 peminjaman & pengembalian terakhir</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left" id="table-circulation">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Peminjam</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Buku</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Tipe</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Waktu</th>
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
                                <td class="px-4 py-3">
                                    <p class="text-slate-700 font-medium line-clamp-1 max-w-[180px]">{{ $scan->book?->title ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($isReturnScan)
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold inline-flex items-center gap-1">
                                            <i class="fas fa-undo text-[10px]"></i> Kembali
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1">
                                            <i class="fas fa-book text-[10px]"></i> Pinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                    <i class="fas fa-clock mr-1 text-slate-400"></i>{{ $scanTime ? $scanTime->format('H:i') . ' WIB' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr id="circulation-empty">
                                <td colspan="4" class="p-8 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <i class="fas fa-inbox text-xl"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium">Belum ada aktivitas sirkulasi hari ini.</p>
                                    <p class="text-xs text-slate-400 mt-1">Gunakan scanner di sebelah kiri untuk memproses peminjaman atau pengembalian.</p>
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

function toggleCamera() {
    cameraActive ? stopCamera() : startCamera();
}

function startCamera() {
    document.getElementById('camera-container').style.display = 'block';
    document.getElementById('camera-icon').className = 'fas fa-stop-circle';
    document.getElementById('camera-label').textContent = 'Matikan Kamera Scanner';
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
    if (html5QrCode) {
        html5QrCode.stop().catch(() => {});
        html5QrCode = null;
    }
    document.getElementById('camera-container').style.display = 'none';
    document.getElementById('camera-icon').className = 'fas fa-camera';
    document.getElementById('camera-label').textContent = 'Aktifkan Kamera Scanner';
    cameraActive = false;
}

function submitManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) {
        showResult(false, 'Token barcode tidak boleh kosong!');
        return;
    }
    processToken(token);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('manual-token').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitManual();
    });
});

async function processToken(token) {
    const btn = document.getElementById('btn-submit');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    let type;
    if (token.startsWith('PINJAM-')) {
        type = 'loan';
    } else if (token.startsWith('KEMBALI-')) {
        type = 'return';
    } else if (token.startsWith('MEMBER-')) {
        showResult(false, '⚠️ Barcode ini adalah Kartu Anggota Presensi.',
            'Silakan gunakan <a href="{{ route("petugas.scanner.presensi") }}" class="text-violet-600 font-bold underline">Scanner Presensi</a> atau gunakan <a href="{{ route("petugas.dashboard") }}" class="text-amber-600 font-bold underline">Scanner Beranda (Auto)</a> yang dapat mendeteksi semua tipe barcode.');
        btn.innerHTML = originalText;
        btn.disabled = false;
        return;
    } else {
        showResult(false, '❌ Format token tidak dikenali.', 'Halaman ini khusus untuk scan tiket <strong class="font-mono text-indigo-600">PINJAM-</strong> atau <strong class="font-mono text-indigo-600">KEMBALI-</strong>.');
        btn.innerHTML = originalText;
        btn.disabled = false;
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
                const badge = data.type === 'return'
                    ? '<span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded font-semibold text-[10px]">PENGEMBALIAN BUKU</span>'
                    : '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded font-semibold text-[10px]">PEMINJAMAN AKTIF</span>';

                body = `
                    <div class="space-y-1">
                        <div class="mb-1">${badge}</div>
                        <div><strong>Buku:</strong> ${data.loan.book}</div>
                        <div><strong>Peminjam:</strong> ${data.loan.user} (${data.loan.npm || '-'})</div>
                        <div><strong>Tenggat Kembali:</strong> ${data.loan.due_date}</div>
                    </div>
                `;
            }
            showResult(true, data.message, body);
            document.getElementById('manual-token').value = '';

            // Update row in table immediately
            prependCirculationRow(data);

        } else {
            let body = '';
            if (data.loan) {
                body = `
                    <div class="space-y-1">
                        <div><strong>Buku:</strong> ${data.loan.book}</div>
                        <div><strong>Peminjam:</strong> ${data.loan.user}</div>
                        <div><strong>Status Terakhir:</strong> ${data.loan.status}</div>
                    </div>
                `;
            }
            showResult(false, data.message, body);
        }
    } catch (e) {
        showResult(false, 'Terjadi kesalahan koneksi saat memproses scan barcode.');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

function showResult(success, title, body = '') {
    const box     = document.getElementById('scan-result');
    const titleEl = document.getElementById('scan-result-title');
    const bodyEl  = document.getElementById('scan-result-body');

    box.className = success
        ? 'mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm block'
        : 'mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 shadow-sm block';

    const icon = success
        ? '<i class="fas fa-check-circle text-emerald-600 text-base"></i>'
        : '<i class="fas fa-times-circle text-rose-600 text-base"></i>';

    titleEl.className = success
        ? 'font-bold text-sm flex items-center gap-2 text-emerald-800 mb-1'
        : 'font-bold text-sm flex items-center gap-2 text-rose-800 mb-1';

    titleEl.innerHTML = icon + ' ' + title;

    if (body) {
        bodyEl.style.display = 'block';
        bodyEl.innerHTML = body;
    } else {
        bodyEl.style.display = 'none';
    }

    clearTimeout(window._resCircTimer);
    window._resCircTimer = setTimeout(() => {
        box.classList.add('hidden');
    }, 10000);
}

function prependCirculationRow(data) {
    const tbody = document.getElementById('circulation-tbody');
    const emptyRow = document.getElementById('circulation-empty');
    if (emptyRow) emptyRow.style.display = 'none';
    if (!tbody || !data.loan) return;

    const isReturn = data.type === 'return';
    const now = new Date();
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-slate-50 transition-colors bg-emerald-50/70';
    tr.innerHTML = `
        <td class="px-4 py-3">
            <p class="font-semibold text-slate-800">${data.loan.user}</p>
            <p class="text-[11px] text-slate-400 font-mono">${data.loan.npm || '-'}</p>
        </td>
        <td class="px-4 py-3">
            <p class="text-slate-700 font-medium line-clamp-1 max-w-[180px]">${data.loan.book}</p>
        </td>
        <td class="px-4 py-3 whitespace-nowrap">
            ${isReturn
                ? '<span class="px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-semibold inline-flex items-center gap-1"><i class="fas fa-undo text-[10px]"></i> Kembali</span>'
                : '<span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1"><i class="fas fa-book text-[10px]"></i> Pinjam</span>'
            }
        </td>
        <td class="px-4 py-3 text-slate-500 whitespace-nowrap font-medium text-emerald-700">
            <i class="fas fa-clock mr-1 text-emerald-600"></i>${timeStr}
        </td>
    `;

    tbody.prepend(tr);
    setTimeout(() => tr.classList.remove('bg-emerald-50/70'), 3000);
}
</script>
@endpush
