@extends('layouts.petugas')

@section('title', 'Scanner Presensi Pengunjung')
@section('subtitle', 'Scan kartu anggota digital perpustakaan untuk mencatat kehadiran pengunjung')

@section('content')

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-violet-600 to-indigo-700 rounded-xl p-5 shadow-md flex items-center justify-between text-white transition-all duration-200 hover:shadow-lg">
            <div>
                <p class="text-xs font-semibold text-violet-200 uppercase tracking-wider">Pengunjung Hari Ini</p>
                <h3 class="text-2xl font-bold mt-1" id="stat-today-attendance">
                    {{ $todayAttendance }} <span class="text-sm font-normal text-violet-200">Orang</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kunjungan Minggu Ini</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-1">
                    {{ $totalWeek }} <span class="text-sm font-normal text-slate-400">Pengunjung</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 shrink-0">
                <i class="fas fa-calendar-week text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between transition-all duration-200 hover:shadow-md">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kunjungan Bulan Ini</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                    {{ $totalMonth }} <span class="text-sm font-normal text-slate-400">Pengunjung</span>
                </h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </div>

    {{-- MAIN GRID: SCANNER + ATTENDANCE LIST --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ══ PANEL SCANNER PRESENSI ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-gradient-to-r from-violet-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-id-card text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Scanner Kartu Anggota Digital</h3>
                        <p class="text-xs text-slate-500">Arahkan kamera ke barcode kartu anggota atau input kode</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs rounded-full font-semibold">
                    1x Per Hari
                </span>
            </div>

            <div class="p-4 sm:p-6">
                {{-- Toggle Kamera --}}
                <button onclick="toggleCamera()" id="btn-camera"
                    class="w-full py-3.5 mb-4 border-2 border-dashed border-violet-300 rounded-xl text-violet-700 text-sm font-semibold hover:bg-violet-50 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-camera" id="camera-icon"></i>
                    <span id="camera-label">Aktifkan Kamera Scanner</span>
                </button>

                {{-- Area Kamera --}}
                <div id="camera-container" style="display:none;" class="mb-4">
                    <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900 shadow-inner"></div>
                    <p class="text-xs text-slate-500 text-center mt-2 flex items-center justify-center gap-1.5">
                        <i class="fas fa-info-circle text-violet-500"></i> Arahkan kamera ke QR Code Kartu Anggota Pengunjung
                    </p>
                </div>

                {{-- Input Manual --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        <i class="fas fa-keyboard mr-1 text-slate-500"></i> Input Barcode Anggota Manual:
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="manual-code"
                            class="flex-1 px-3.5 py-2.5 text-sm font-mono border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Contoh: MEMBER-5-ABCD1234"
                            autocomplete="off">
                        <button onclick="submitManual()" id="btn-submit"
                            class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-1.5 shadow-sm">
                            <i class="fas fa-check-circle"></i> Check-In
                        </button>
                    </div>
                </div>

                {{-- Hasil Scan Alert Box --}}
                <div id="scan-result" class="mt-4 p-4 rounded-xl hidden transition-all duration-300">
                    <div id="scan-result-title" class="font-semibold text-sm flex items-center gap-2 mb-1"></div>
                    <div id="scan-result-body" class="text-xs leading-relaxed"></div>
                    <div id="scan-result-user" class="hidden mt-3 pt-3 border-t"></div>
                </div>

            </div>
        </div>

        {{-- ══ DAFTAR PENGUNJUNG HADIR HARI INI ══ --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200/80 flex flex-col">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-user-check text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Pengunjung Hadir Hari Ini</h3>
                        <p class="text-xs text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs rounded-full font-bold" id="badge-attendance-count">
                    {{ $todayAttendance }} Orang
                </span>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left" id="table-attendance">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Anggota</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600 hidden sm:table-cell">NPM / Prodi</th>
                            <th class="px-4 py-3 text-xs font-semibold text-slate-600">Jam Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs" id="attendance-tbody">
                        @forelse($recentAttendances as $attendance)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $attendance->user?->getAvatarUrl() }}"
                                             alt="{{ $attendance->user?->name }}"
                                             class="w-8 h-8 rounded-lg object-cover flex-shrink-0 border border-slate-200">
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $attendance->user?->name ?? '-' }}</p>
                                            <p class="text-[11px] text-slate-400 sm:hidden">{{ $attendance->user?->npm ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <p class="text-slate-700 font-mono font-medium">{{ $attendance->user?->npm ?? '-' }}</p>
                                    <p class="text-[11px] text-slate-400 truncate max-w-[150px]">{{ $attendance->user?->prodi ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1">
                                        <i class="fas fa-clock text-[10px]"></i> {{ $attendance->scanned_at->format('H:i') }} WIB
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr id="attendance-empty">
                                <td colspan="3" class="p-8 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                        <i class="fas fa-user-clock text-xl"></i>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium">Belum ada pengunjung yang check-in hari ini.</p>
                                    <p class="text-xs text-slate-400 mt-1">Scan kartu anggota pengunjung untuk mencatat kehadiran.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($todayAttendance > 25)
                <div class="px-4 py-3 text-center border-t border-slate-100 bg-slate-50">
                    <a href="{{ route('petugas.attendance.history') }}" class="text-xs text-violet-600 hover:text-violet-800 font-semibold">
                        Lihat seluruh {{ $todayAttendance }} presensi di Halaman Riwayat →
                    </a>
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
            processMemberCode(decodedText);
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
    const code = document.getElementById('manual-code').value.trim();
    if (!code) {
        showResult(false, 'Kode barcode tidak boleh kosong!');
        return;
    }
    processMemberCode(code);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('manual-code').addEventListener('keydown', e => {
        if (e.key === 'Enter') submitManual();
    });
});

async function processMemberCode(code) {
    const btn = document.getElementById('btn-submit');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.disabled = true;

    if (code.startsWith('PINJAM-') || code.startsWith('KEMBALI-')) {
        showResult(false, '⚠️ Barcode ini adalah Tiket Sirkulasi Buku (Pinjam/Kembali).',
            'Silakan gunakan <a href="{{ route("petugas.scanner.sirkulasi") }}" class="text-indigo-600 font-bold underline">Scanner Sirkulasi</a> atau gunakan <a href="{{ route("petugas.dashboard") }}" class="text-amber-600 font-bold underline">Scanner Beranda (Auto)</a>.');
        btn.innerHTML = originalText;
        btn.disabled = false;
        return;
    }

    if (!code.startsWith('MEMBER-')) {
        showResult(false, '❌ Format barcode tidak valid.', 'Kode kartu anggota perpustakaan harus berawalan <strong class="font-mono text-violet-600">MEMBER-</strong>.');
        btn.innerHTML = originalText;
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

        showResult(data.success, data.message, '', data.user, data.already_in);
        document.getElementById('manual-code').value = '';

        if (data.success && data.user) {
            prependAttendanceRow(data.user);
            incrementAttendanceCounter();
        }

    } catch (e) {
        showResult(false, 'Terjadi kesalahan koneksi saat memproses presensi.');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

function showResult(success, title, body = '', user = null, alreadyIn = false) {
    const box      = document.getElementById('scan-result');
    const titleEl  = document.getElementById('scan-result-title');
    const bodyEl   = document.getElementById('scan-result-body');
    const userEl   = document.getElementById('scan-result-user');

    let borderColor, bgColor, textColor, icon;
    if (success) {
        textColor = 'text-emerald-800';
        icon = '<i class="fas fa-check-circle text-emerald-600 text-base"></i>';
        borderColor = 'border-emerald-200';
        bgColor = 'bg-emerald-50';
    } else if (alreadyIn) {
        textColor = 'text-amber-800';
        icon = '<i class="fas fa-exclamation-triangle text-amber-600 text-base"></i>';
        borderColor = 'border-amber-200';
        bgColor = 'bg-amber-50';
    } else {
        textColor = 'text-rose-800';
        icon = '<i class="fas fa-times-circle text-rose-600 text-base"></i>';
        borderColor = 'border-rose-200';
        bgColor = 'bg-rose-50';
    }

    box.className = `mt-4 p-4 rounded-xl ${bgColor} border ${borderColor} shadow-sm block`;
    titleEl.className = `font-bold text-sm flex items-center gap-2 ${textColor} mb-1`;
    titleEl.innerHTML = icon + ' ' + title;

    if (body) {
        bodyEl.style.display = 'block';
        bodyEl.innerHTML = body;
    } else {
        bodyEl.style.display = 'none';
    }

    if (user) {
        userEl.className = `mt-3 pt-3 border-t ${borderColor} flex items-center gap-3`;
        userEl.innerHTML = `
            <img src="${user.avatar}" alt="${user.name}" class="w-11 h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-800 text-sm leading-tight">${user.name}</p>
                <p class="text-xs text-slate-500 font-mono mt-0.5">${user.npm || '-'} &bull; ${user.prodi || 'Anggota'}</p>
                <p class="text-[11px] text-emerald-700 font-semibold mt-1">
                    <i class="fas fa-clock mr-1"></i> Jam Masuk: ${user.scanned_at || '-'}
                </p>
            </div>
        `;
        userEl.style.display = 'flex';
    } else {
        userEl.style.display = 'none';
    }

    clearTimeout(window._resAttTimer);
    window._resAttTimer = setTimeout(() => {
        box.classList.add('hidden');
    }, 10000);
}

function prependAttendanceRow(user) {
    const tbody = document.getElementById('attendance-tbody');
    const empty = document.getElementById('attendance-empty');
    if (empty) empty.style.display = 'none';
    if (!tbody) return;

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-slate-50 transition-colors bg-emerald-50/80';
    tr.innerHTML = `
        <td class="px-4 py-3">
            <div class="flex items-center gap-3">
                <img src="${user.avatar}" alt="${user.name}" class="w-8 h-8 rounded-lg object-cover flex-shrink-0 border border-slate-200">
                <div>
                    <p class="font-semibold text-slate-800">${user.name}</p>
                    <p class="text-[11px] text-slate-400 sm:hidden">${user.npm || '-'}</p>
                </div>
            </div>
        </td>
        <td class="px-4 py-3 hidden sm:table-cell">
            <p class="text-slate-700 font-mono font-medium">${user.npm || '-'}</p>
            <p class="text-[11px] text-slate-400 truncate max-w-[150px]">${user.prodi || ''}</p>
        </td>
        <td class="px-4 py-3 whitespace-nowrap">
            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-semibold inline-flex items-center gap-1">
                <i class="fas fa-clock text-[10px]"></i> ${user.scanned_at || 'Baru Saja'}
            </span>
        </td>
    `;

    tbody.prepend(tr);
    setTimeout(() => tr.classList.remove('bg-emerald-50/80'), 3000);
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
        stat.innerHTML = (current + 1) + ' <span class="text-sm font-normal text-violet-200">Orang</span>';
    }
}
</script>
@endpush
