<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petugas Scanner | Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;1,14..32,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- html5-qrcode library for camera scanning -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0a0e1a;
            --bg-card: #111827;
            --bg-card2: #1a2235;
            --accent: #6366f1;
            --accent2: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: rgba(255,255,255,0.08);
            --glow: rgba(99,102,241,0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(17,24,39,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text);
        }
        .navbar-brand .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .navbar-brand .brand-name {
            font-weight: 700;
            font-size: 1rem;
        }
        .navbar-brand .brand-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
        }
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .badge-role {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .btn-logout {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
            border: 1px solid rgba(239,68,68,0.3);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.25); }

        /* ── LAYOUT ── */
        .main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--text), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
        }
        .page-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .stat-icon.violet  { background: rgba(99,102,241,0.2); color: var(--accent); }
        .stat-icon.success { background: rgba(16,185,129,0.2); color: var(--success); }
        .stat-icon.warning { background: rgba(245,158,11,0.2); color: var(--warning); }
        .stat-icon.danger  { background: rgba(239,68,68,0.2); color: var(--danger); }
        .stat-label { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 2px; }
        .stat-value { font-size: 1.6rem; font-weight: 800; }

        /* ── GRID 2 COL ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

        /* ── CARD ── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .card-header-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .card-header h2 { font-size: 1rem; font-weight: 700; }
        .card-header p  { font-size: 0.78rem; color: var(--text-muted); }
        .card-body { padding: 1.5rem; }

        /* ── SCANNER ── */
        .scan-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 1.25rem;
        }
        .scan-tab {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .scan-tab.active {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-color: transparent;
            color: white;
        }

        /* Camera scanner */
        #qr-reader {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
        }
        #qr-reader video { border-radius: 12px; }
        #qr-reader img { display: none; }

        /* Manual input */
        .manual-section { margin-top: 1rem; }
        .manual-section label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .input-group {
            display: flex;
            gap: 8px;
        }
        .input-token {
            flex: 1;
            background: var(--bg-card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            color: var(--text);
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-token:focus { border-color: var(--accent); }
        .btn-scan {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            font-family: 'Inter', sans-serif;
        }
        .btn-scan:hover { opacity: 0.9; }
        .btn-scan:active { transform: scale(0.98); }

        /* Toggle camera button */
        .btn-camera {
            width: 100%;
            background: var(--bg-card2);
            border: 1px dashed rgba(99,102,241,0.4);
            border-radius: 12px;
            padding: 14px;
            color: var(--accent);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-camera:hover { background: rgba(99,102,241,0.1); }

        /* Result box */
        .scan-result {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 12px;
            display: none;
            animation: slideIn 0.3s ease;
        }
        .scan-result.success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); }
        .scan-result.error   { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); }
        .scan-result-title {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .scan-result.success .scan-result-title { color: var(--success); }
        .scan-result.error .scan-result-title   { color: var(--danger); }
        .scan-result-body { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; }
        .scan-result-body strong { color: var(--text); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── SCAN HISTORY TABLE ── */
        .history-table {
            width: 100%;
            border-collapse: collapse;
        }
        .history-table th {
            text-align: left;
            padding: 10px 14px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }
        .history-table td {
            padding: 12px 14px;
            font-size: 0.83rem;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }
        .history-table tr:last-child td { border-bottom: none; }
        .history-table tr:hover td { background: rgba(255,255,255,0.02); }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-pinjam  { background: rgba(99,102,241,0.2); color: #a5b4fc; }
        .badge-kembali { background: rgba(16,185,129,0.2); color: #6ee7b7; }

        /* Alert banners */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.875rem;
            animation: slideIn 0.3s ease;
        }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
        .alert-error   { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; }
        .alert i { margin-top: 2px; }

        /* Pulse animation for pending counts */
        .pulse-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--warning);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
            margin-right: 4px;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* Scrollable table */
        .table-wrap { overflow-x: auto; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.4; }
        .empty-state p { font-size: 0.875rem; }

        /* Spinner */
        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<!-- ══ NAVBAR ══ -->
<nav class="navbar">
    <a href="{{ route('petugas.dashboard') }}" class="navbar-brand">
        <div class="logo-icon">📚</div>
        <div>
            <div class="brand-name">Perpustakaan</div>
            <div class="brand-sub">Scanner Dashboard</div>
        </div>
    </a>
    <div class="navbar-right">
        <span class="badge-role">
            <i class="fas fa-user-shield" style="margin-right:4px"></i>
            {{ auth()->user()->role === 'admin' ? 'Admin' : 'Petugas' }}
        </span>
        <span style="color:var(--text-muted); font-size:0.85rem">{{ auth()->user()->name }}</span>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn-logout" style="color:#6366f1; background:rgba(99,102,241,0.15); border-color:rgba(99,102,241,0.3);">
                <i class="fas fa-tachometer-alt"></i> Admin Panel
            </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
    </div>
</nav>

<!-- ══ MAIN CONTENT ══ -->
<main class="main">

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-qrcode" style="font-size:1.4rem"></i> Scanner Barcode</h1>
        <p>Scan barcode peminjaman & pengembalian buku perpustakaan</p>
    </div>

    <!-- Alerts from redirect -->
    @if(session('scan_success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('scan_success') }}</div>
        </div>
    @endif
    @if(session('scan_error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('scan_error') }}</div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-label"><span class="pulse-dot"></span>Menunggu Konfirmasi Pinjam</div>
                <div class="stat-value">{{ $pendingLoans }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon violet"><i class="fas fa-undo-alt"></i></div>
            <div>
                <div class="stat-label"><span class="pulse-dot"></span>Menunggu Konfirmasi Kembali</div>
                <div class="stat-value">{{ $pendingReturns }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-box-open"></i></div>
            <div>
                <div class="stat-label">Scan Pinjam Hari Ini</div>
                <div class="stat-value">{{ $todayLoanScans }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-redo"></i></div>
            <div>
                <div class="stat-label">Scan Kembali Hari Ini</div>
                <div class="stat-value">{{ $todayReturnScans }}</div>
            </div>
        </div>
    </div>

    <!-- Two Column: Scanner + History -->
    <div class="two-col">

        <!-- ══ SCANNER PANEL ══ -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon"><i class="fas fa-qrcode"></i></div>
                <div>
                    <h2>Scanner QR Code</h2>
                    <p>Scan atau input token barcode pengunjung</p>
                </div>
            </div>
            <div class="card-body">

                <!-- Mode Tabs -->
                <div class="scan-tabs">
                    <button class="scan-tab active" onclick="setMode('auto')" id="tab-auto">
                        <i class="fas fa-magic"></i> Auto Detect
                    </button>
                    <button class="scan-tab" onclick="setMode('loan')" id="tab-loan">
                        <i class="fas fa-book"></i> Pinjam
                    </button>
                    <button class="scan-tab" onclick="setMode('return')" id="tab-return">
                        <i class="fas fa-undo"></i> Kembali
                    </button>
                </div>

                <!-- Camera Toggle -->
                <button class="btn-camera" onclick="toggleCamera()" id="btn-camera">
                    <i class="fas fa-camera" id="camera-icon"></i>
                    <span id="camera-label">Aktifkan Kamera Scanner</span>
                </button>

                <!-- Camera Scanner Area -->
                <div id="camera-container" style="display:none; margin-bottom:1rem;">
                    <div id="qr-reader"></div>
                    <p style="font-size:0.75rem; color:var(--text-muted); text-align:center; margin-top:8px;">
                        <i class="fas fa-info-circle"></i> Arahkan kamera ke barcode QR pengunjung
                    </p>
                </div>

                <!-- Manual Input -->
                <div class="manual-section">
                    <label><i class="fas fa-keyboard" style="margin-right:4px"></i> Atau masukkan token manual:</label>
                    <div class="input-group">
                        <input type="text" class="input-token" id="manual-token"
                               placeholder="Contoh: PINJAM-12-1234567890-ABCD1234..."
                               autocomplete="off">
                        <button class="btn-scan" onclick="submitManual()" id="btn-submit">
                            <i class="fas fa-search"></i> Scan
                        </button>
                    </div>
                    <p style="font-size:0.72rem; color:var(--text-muted); margin-top:6px;">
                        Token PINJAM dimulai dengan <code style="color:var(--accent)">PINJAM-</code>, token KEMBALI dimulai dengan <code style="color:var(--accent)">KEMBALI-</code>
                    </p>
                </div>

                <!-- Scan Result -->
                <div class="scan-result" id="scan-result">
                    <div class="scan-result-title" id="scan-result-title"></div>
                    <div class="scan-result-body" id="scan-result-body"></div>
                </div>

            </div>
        </div>

        <!-- ══ RECENT ACTIVITY ══ -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon" style="background:linear-gradient(135deg,var(--success),#059669)">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h2>Aktivitas Scan Terbaru</h2>
                    <p>20 scan terakhir yang diproses</p>
                </div>
            </div>
            <div class="table-wrap">
                @if($recentScans->count() > 0)
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Pengunjung</th>
                                <th>Buku</th>
                                <th>Tipe</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentScans as $scan)
                                @php
                                    $isLoanScan   = $scan->loan_barcode_scanned_at !== null;
                                    $isReturnScan = $scan->return_barcode_scanned_at !== null;
                                    $scanTime     = $isReturnScan
                                        ? ($isLoanScan
                                            ? max($scan->loan_barcode_scanned_at, $scan->return_barcode_scanned_at)
                                            : $scan->return_barcode_scanned_at)
                                        : $scan->loan_barcode_scanned_at;
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:600; font-size:0.82rem">{{ $scan->user?->name ?? '-' }}</div>
                                        <div style="font-size:0.72rem; color:var(--text-muted)">{{ $scan->user?->npm ?? '' }}</div>
                                    </td>
                                    <td style="max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">
                                        {{ $scan->book?->title ?? '-' }}
                                    </td>
                                    <td>
                                        @if($isReturnScan && $scan->return_barcode_scanned_at >= ($scan->loan_barcode_scanned_at ?? '1970-01-01'))
                                            <span class="badge badge-kembali"><i class="fas fa-undo"></i> Kembali</span>
                                        @else
                                            <span class="badge badge-pinjam"><i class="fas fa-book"></i> Pinjam</span>
                                        @endif
                                    </td>
                                    <td style="color:var(--text-muted); font-size:0.78rem; white-space:nowrap">
                                        {{ $scanTime ? $scanTime->diffForHumans() : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada aktivitas scan hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</main>

<script>
// ── STATE ──
let currentMode = 'auto';
let cameraActive = false;
let html5QrCode = null;

// ── MODE TABS ──
function setMode(mode) {
    currentMode = mode;
    ['auto', 'loan', 'return'].forEach(m => {
        document.getElementById('tab-' + m).classList.toggle('active', m === mode);
    });
}

// ── CAMERA ──
function toggleCamera() {
    if (cameraActive) {
        stopCamera();
    } else {
        startCamera();
    }
}

function startCamera() {
    document.getElementById('camera-container').style.display = 'block';
    document.getElementById('camera-icon').className = 'fas fa-stop-circle';
    document.getElementById('camera-label').textContent = 'Matikan Kamera';
    cameraActive = true;

    html5QrCode = new Html5Qrcode("qr-reader");
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    html5QrCode.start(
        { facingMode: "environment" },
        config,
        (decodedText) => {
            // Auto-stop after scan
            stopCamera();
            processToken(decodedText);
        },
        (error) => { /* ignore errors during scan */ }
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

// ── MANUAL INPUT ──
function submitManual() {
    const token = document.getElementById('manual-token').value.trim();
    if (!token) {
        showResult(false, 'Token tidak boleh kosong!');
        return;
    }
    processToken(token);
}

// Allow Enter key
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('manual-token').addEventListener('keydown', (e) => {
        if (e.key === 'Enter') submitManual();
    });
});

// ── PROCESS TOKEN ──
async function processToken(token) {
    const btn = document.getElementById('btn-submit');
    btn.innerHTML = '<span class="spinner"></span> Memproses...';
    btn.disabled = true;

    // Determine type
    let type = currentMode;
    if (type === 'auto') {
        if (token.startsWith('PINJAM-'))   type = 'loan';
        else if (token.startsWith('KEMBALI-')) type = 'return';
        else {
            showResult(false, '❌ Format token tidak dikenali. Pastikan token dimulai dengan PINJAM- atau KEMBALI-');
            btn.innerHTML = '<i class="fas fa-search"></i> Scan';
            btn.disabled = false;
            return;
        }
    }

    try {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const res = await fetch('{{ route("petugas.api.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ token, type }),
        });

        const data = await res.json();

        if (data.success) {
            let body = data.message;
            if (data.loan) {
                body += `<br><strong>Buku:</strong> ${data.loan.book}<br>
                         <strong>Peminjam:</strong> ${data.loan.user} (${data.loan.npm || '-'})<br>
                         <strong>Tenggat:</strong> ${data.loan.due_date}`;
            }
            showResult(true, data.message, body);
            document.getElementById('manual-token').value = '';
            // Auto-reload after 3s to refresh stats
            setTimeout(() => location.reload(), 3000);
        } else {
            let body = data.message;
            if (data.loan) {
                body += `<br><strong>Buku:</strong> ${data.loan.book}<br>
                         <strong>Peminjam:</strong> ${data.loan.user}<br>
                         <strong>Status saat ini:</strong> ${data.loan.status}`;
            }
            showResult(false, data.message, body);
        }
    } catch (err) {
        showResult(false, 'Terjadi kesalahan koneksi. Coba lagi.');
    } finally {
        btn.innerHTML = '<i class="fas fa-search"></i> Scan';
        btn.disabled = false;
    }
}

// ── SHOW RESULT ──
function showResult(success, title, body = '') {
    const box = document.getElementById('scan-result');
    const titleEl = document.getElementById('scan-result-title');
    const bodyEl  = document.getElementById('scan-result-body');

    box.className = 'scan-result ' + (success ? 'success' : 'error');
    box.style.display = 'block';

    const icon = success
        ? '<i class="fas fa-check-circle"></i>'
        : '<i class="fas fa-times-circle"></i>';

    titleEl.innerHTML = icon + ' ' + title;
    bodyEl.innerHTML  = body || '';

    // Auto-hide after 8s
    clearTimeout(window._resultTimer);
    window._resultTimer = setTimeout(() => {
        box.style.display = 'none';
    }, 8000);
}
</script>

</body>
</html>
