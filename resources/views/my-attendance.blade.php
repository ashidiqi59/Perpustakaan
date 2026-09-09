<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan | Riwayat Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #F9FAFB; color: #1F2937; }
        .library-primary { color: #2563EB; }

        /* QR Modal */
        .qr-modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(6px);
            z-index: 1000;
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.2s ease;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

        .qr-modal {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            max-width: 360px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.3s ease;
            box-shadow: 0 30px 80px rgba(0,0,0,0.35);
        }

        /* Status pill */
        .status-hadir { background: #dcfce7; color: #166534; }

        /* Card security & pattern */
        .card-security-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 16px 16px;
        }

        /* Hapus render duplikat QR Code */
        .qr-box canvas,
        #qr-modal-big canvas,
        #qr-modal-card canvas {
            display: none !important;
        }
        .qr-box img,
        #qr-modal-big img,
        #qr-modal-card img {
            display: block !important;
            margin: 0 auto !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
        }
    </style>
</head>
<body>
    <x-page-loader />
    @include('components.navbar')

    <!-- Sub-Navbar / Breadcrumb -->
    @include('components.sub-navbar', ['title' => 'Riwayat Kunjungan', 'maxWidth' => 'max-w-6xl'])

    <div class="min-h-screen pt-6 sm:pt-8 pb-12 sm:pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-2 flex items-center gap-3">
                    <i class="fas fa-calendar-check library-primary"></i>
                    <span>Riwayat Kunjungan</span>
                </h1>
                <p class="text-xs sm:text-base text-gray-600">Catatan kehadiran Anda di perpustakaan</p>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- ── MINI KARTU ANGGOTA + STATS ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                {{-- Mini Kartu Anggota (Elegan & Konsisten) --}}
                @if($memberBarcode)
                <div class="md:col-span-1 relative overflow-hidden rounded-2xl p-5 cursor-pointer group transition-all duration-300 hover:-translate-y-1 text-white select-none"
                     style="background: linear-gradient(135deg, #0A192F 0%, #0F2D59 45%, #1B4582 85%, #0B1C38 100%);
                            box-shadow: 0 16px 36px -10px rgba(11, 28, 56, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.12);"
                     onclick="openCardModal()" title="Klik untuk memperbesar kartu">

                    {{-- Watermark & Texture --}}
                    <div class="absolute inset-0 card-security-pattern pointer-events-none opacity-40"></div>
                    <div class="absolute -right-8 -bottom-8 w-44 h-44 pointer-events-none opacity-[0.06] text-white">
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full transform rotate-6">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>

                    {{-- Top bar --}}
                    <div class="relative z-10 flex items-center justify-between pb-3 mb-3 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center text-blue-200 text-xs">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <span class="text-[9px] uppercase tracking-[0.2em] font-semibold text-blue-200/80">Kartu Anggota</span>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-500/15 border border-emerald-400/30 text-emerald-300">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="relative z-10 flex items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}"
                                 class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/20 shadow flex-shrink-0">
                            <div class="min-w-0">
                                <p class="text-white font-bold text-sm truncate">{{ $user->name }}</p>
                                @if($user->npm)
                                    <p class="text-blue-200 text-xs font-mono">{{ $user->npm }}</p>
                                @endif
                                <p class="text-blue-100/60 text-[11px] truncate">{{ $user->prodi ?? 'Pengunjung' }}</p>
                            </div>
                        </div>

                        {{-- Tombol Klik QR --}}
                        <div class="flex-shrink-0" onclick="event.stopPropagation(); openQrModal();" title="Klik untuk perbesar QR presensi">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-md flex items-center justify-center text-slate-900 group-hover:scale-105 transition-transform hover:ring-2 hover:ring-blue-400">
                                <i class="fas fa-qrcode text-lg text-slate-800"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="relative z-10 pt-2.5 border-t border-white/10 flex items-center justify-between text-[10px]">
                        <span class="text-blue-200/70 font-mono font-semibold">{{ $memberBarcode->barcode_code }}</span>
                        <span class="text-blue-200/50 uppercase tracking-wider flex items-center gap-1">
                            Perbesar <i class="fas fa-expand text-[8px]"></i>
                        </span>
                    </div>
                </div>
                @endif

                {{-- Stats --}}
                <div class="md:col-span-2 grid grid-cols-3 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-day text-violet-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalMonth }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Bulan Ini</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-week text-indigo-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalWeek }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Minggu Ini</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-3">
                            <i class="fas fa-trophy text-emerald-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalAll }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Total Kunjungan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── TABEL RIWAYAT ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Header tabel --}}
                <div class="px-5 sm:px-7 py-5 border-b border-gray-100 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-list-ul text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">Semua Kunjungan</h2>
                            <p class="text-xs text-gray-500">{{ $logs->total() }} total kunjungan tercatat</p>
                        </div>
                    </div>
                </div>

                @if($logs->count() > 0)

                    {{-- Desktop Table --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Check-In</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($logs as $i => $log)
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <td class="px-6 py-4 text-xs text-gray-400 font-mono">
                                        {{ $logs->firstItem() + $i }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0
                                                @php
                                                    $dow = $log->scan_date->dayOfWeek; // 0=Sun, 5=Fri, 6=Sat
                                                    $bgClass = match(true) {
                                                        $dow === 0 || $dow === 6 => 'bg-violet-100',
                                                        $dow === 5              => 'bg-amber-100',
                                                        default                 => 'bg-blue-100',
                                                    };
                                                @endphp
                                                {{ $bgClass }}">
                                                <i class="fas fa-calendar-day text-xs
                                                    {{ $dow === 0 || $dow === 6 ? 'text-violet-500' : ($dow === 5 ? 'text-amber-500' : 'text-blue-500') }}"></i>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-800">
                                                {{ $log->scan_date->translatedFormat('l') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $log->scan_date->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg">
                                            <i class="fas fa-clock text-xs text-indigo-500"></i>
                                            {{ $log->scanned_at->format('H:i') }} WIB
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-100">
                                            <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i> Hadir
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="sm:hidden divide-y divide-gray-50">
                        @foreach($logs as $i => $log)
                        <div class="px-5 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-door-open text-indigo-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $log->scan_date->translatedFormat('l, d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        <i class="fas fa-clock mr-1"></i>{{ $log->scanned_at->format('H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-100">
                                Hadir
                            </span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($logs->hasPages())
                    <div class="px-5 sm:px-7 py-4 border-t border-gray-100">
                        {{ $logs->links() }}
                    </div>
                    @endif

                @else
                    {{-- Empty State --}}
                    <div class="py-20 text-center px-6">
                        <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-calendar-times text-indigo-300 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Riwayat Kunjungan</h3>
                        <p class="text-sm text-gray-400 max-w-sm mx-auto">
                            Tunjukkan QR Code kartu anggota Anda kepada petugas saat tiba di perpustakaan untuk mencatat kehadiran.
                        </p>
                        <a href="{{ route('profile') }}"
                           class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md">
                            <i class="fas fa-id-card"></i> Lihat Kartu Anggota
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- MODAL 1: TAMPILAN KARTU PENUH DIPERBESAR          --}}
    {{-- ══════════════════════════════════════════════════ --}}
    @if($memberBarcode)
    <div id="card-modal"
         class="fixed inset-0 z-[999] hidden items-center justify-center p-3 sm:p-6 bg-slate-950/80 backdrop-blur-md"
         onclick="if(event.target === this) closeCardModal();">

        <div id="card-modal-inner"
             class="w-full max-w-xl transition-all duration-300 transform scale-95 opacity-0"
             onclick="event.stopPropagation()">

            {{-- Kartu Versi Besar --}}
            <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl p-5 sm:p-8 text-white shadow-2xl"
                 style="background: linear-gradient(135deg, #0A192F 0%, #0F2D59 45%, #1B4582 85%, #0B1C38 100%);
                        box-shadow: 0 25px 60px -15px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.18);">

                {{-- Background watermark --}}
                <div class="absolute inset-0 card-security-pattern pointer-events-none opacity-50"></div>
                <div class="absolute -right-16 -bottom-16 w-80 h-80 pointer-events-none opacity-[0.07] text-white">
                    <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full transform rotate-6">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="absolute top-0 right-1/4 w-64 h-64 rounded-full bg-blue-400/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col justify-between">
                    {{-- Header Kartu Besar --}}
                    <div class="flex items-center justify-between pb-3.5 sm:pb-5 border-b border-white/15">
                        <div class="flex items-center gap-2.5 sm:gap-3.5">
                            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-blue-200 shadow-inner">
                                <i class="fas fa-book-reader text-sm sm:text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[9px] sm:text-[10px] uppercase tracking-[0.2em] sm:tracking-[0.25em] font-bold text-blue-200/80 leading-none">Kartu Tanda Anggota Digital</p>
                                <h3 class="text-white font-extrabold text-base sm:text-xl tracking-wide mt-1 sm:mt-1.5 leading-none">Perpustakaan</h3>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[11px] sm:text-xs font-semibold bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 backdrop-blur-sm">
                                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                Aktif
                            </span>
                            <button type="button"
                                    id="btn-close-card-modal"
                                    onclick="event.stopPropagation(); closeCardModal();"
                                    class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 active:scale-90 text-white flex items-center justify-center transition-all cursor-pointer touch-manipulation z-20 ml-1"
                                    aria-label="Tutup Kartu">
                                <i class="fas fa-times text-xs sm:text-sm pointer-events-none"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Isi Kartu Besar: Foto, Biodata & QR Code --}}
                    <div class="py-4 sm:py-6 flex items-center justify-between gap-3 sm:gap-5">
                        <div class="flex items-center gap-3 sm:gap-5 min-w-0 flex-1">
                            {{-- Foto Member --}}
                            <div class="relative flex-shrink-0">
                                <img src="{{ $user->getAvatarUrl() }}"
                                     alt="{{ $user->name }}"
                                     class="w-14 h-14 sm:w-24 sm:h-24 rounded-xl sm:rounded-2xl object-cover ring-2 sm:ring-4 ring-white/20 shadow-xl">
                                <span class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] sm:text-xs ring-2 ring-[#0A192F]" title="Terverifikasi">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>

                            {{-- Teks Biodata (Responsif, tidak terpotong) --}}
                            <div class="min-w-0 flex-1">
                                <span class="inline-block px-2 py-0.5 sm:px-2.5 sm:py-0.5 rounded text-[9px] sm:text-[10px] font-semibold uppercase tracking-wider bg-white/10 text-blue-200 mb-1 sm:mb-1.5">
                                    {{ $user->role === 'pengunjung' ? 'Anggota Pengunjung' : ucfirst($user->role) }}
                                </span>
                                <h4 class="text-sm sm:text-2xl font-bold text-white tracking-tight leading-snug break-words">
                                    {{ $user->name }}
                                </h4>
                                <div class="mt-1 sm:mt-1.5 space-y-0.5 sm:space-y-1 text-xs sm:text-sm text-blue-100/80">
                                    @if($user->npm)
                                        <p class="font-mono flex items-center gap-1.5 sm:gap-2 text-blue-200">
                                            <i class="fas fa-id-badge text-[10px] sm:text-xs opacity-75"></i>
                                            <span>{{ $user->npm }}</span>
                                        </p>
                                    @endif
                                    @if($user->prodi)
                                        <p class="flex items-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs truncate text-blue-100/70">
                                            <i class="fas fa-graduation-cap text-[10px] sm:text-xs opacity-75"></i>
                                            <span class="truncate">{{ $user->prodi }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- QR Code di Kartu Besar --}}
                        <div class="flex flex-col items-center flex-shrink-0 cursor-pointer group"
                             onclick="openQrModal();"
                             title="Klik untuk fokus QR Code scan">
                            <div class="p-1.5 sm:p-2 bg-white rounded-xl sm:rounded-2xl shadow-xl transition-transform group-hover:scale-105">
                                <div id="qr-modal-card" class="qr-box flex items-center justify-center bg-white rounded-lg sm:rounded-xl overflow-hidden w-[72px] h-[72px] sm:w-[96px] sm:h-[96px]">
                                    <img src="{{ $memberBarcode->getQrCodeDataUri(150) }}"
                                         alt="QR Code"
                                         class="w-[72px] h-[72px] sm:w-[96px] sm:h-[96px] object-contain rounded-md sm:rounded-lg shadow-sm"
                                         loading="eager"
                                         onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($memberBarcode->barcode_code) }}&format=png&margin=1'">
                                </div>
                            </div>
                            <span class="text-[8px] sm:text-[9px] uppercase tracking-wider text-blue-200/70 font-semibold mt-1 sm:mt-1.5 flex items-center gap-1 group-hover:text-white transition-colors">
                                <i class="fas fa-expand text-[7px] sm:text-[8px]"></i> Perbesar QR
                            </span>
                        </div>
                    </div>

                    {{-- Footer Kartu Besar --}}
                    <div class="pt-3.5 sm:pt-4 border-t border-white/15 flex items-end justify-between text-[9px] sm:text-[10px]">
                        <div>
                            <p class="uppercase tracking-[0.2em] sm:tracking-[0.22em] font-semibold text-blue-200/60">Nomor Identitas Anggota</p>
                            <p class="text-xs sm:text-base font-mono font-bold tracking-wider text-white mt-0.5">
                                {{ $memberBarcode->barcode_code }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="uppercase tracking-[0.2em] sm:tracking-[0.22em] font-semibold text-blue-200/60">Terdaftar Sejak</p>
                            <p class="text-[11px] sm:text-sm font-medium text-blue-100 mt-0.5">
                                {{ $user->created_at->translatedFormat('d F Y') ?? $user->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════ --}}
    {{-- MODAL 2: KHUSUS QR CODE PRESENSI (SCAN PETUGAS)   --}}
    {{-- ══════════════════════════════════════════════════ --}}
    <div id="qr-modal"
         class="fixed inset-0 z-[1000] hidden items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
         onclick="if(event.target === this) closeQrModal();">

        <div id="qr-modal-inner"
             class="w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 transition-all duration-300 transform scale-95 opacity-0"
             onclick="event.stopPropagation()">

            {{-- Header Modal QR --}}
            <div class="p-6 text-white relative overflow-hidden"
                 style="background: linear-gradient(135deg, #0A192F 0%, #0F2D59 50%, #1B4582 100%);">
                <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-blue-400/10 blur-2xl"></div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-blue-200 text-xs">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <span class="text-xs font-bold tracking-wide uppercase">Presensi Perpustakaan</span>
                    </div>
                    <button type="button"
                            id="btn-close-qr-modal"
                            onclick="event.stopPropagation(); closeQrModal();"
                            class="w-9 h-9 sm:w-8 sm:h-8 rounded-full bg-white/20 hover:bg-white/30 active:scale-90 text-white flex items-center justify-center transition-all cursor-pointer touch-manipulation z-20 shadow-sm"
                            aria-label="Tutup Presensi">
                        <i class="fas fa-times text-sm pointer-events-none"></i>
                    </button>
                </div>

                <div class="flex items-center gap-3.5">
                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}"
                         class="w-12 h-12 rounded-xl object-cover ring-2 ring-white/20 shadow-md flex-shrink-0">
                    <div class="min-w-0">
                        <h4 class="font-bold text-base text-white truncate">{{ $user->name }}</h4>
                        @if($user->npm)
                            <p class="text-xs text-blue-200 font-mono">{{ $user->npm }}</p>
                        @endif
                        <p class="text-[11px] text-blue-100/70 truncate">{{ $user->prodi ?? 'Anggota Perpustakaan' }}</p>
                    </div>
                </div>
            </div>

            {{-- Badan Modal QR: QR Code Tunggal, Besar & Jelas --}}
            <div class="p-6 text-center">
                <div class="inline-block p-4 bg-white rounded-2xl border border-gray-100 shadow-inner mb-4">
                    <div id="qr-modal-big" class="qr-box flex items-center justify-center bg-white rounded-xl" style="width: 180px; height: 180px;">
                        <img src="{{ $memberBarcode->getQrCodeDataUri(240) }}"
                             alt="QR Code Presensi"
                             class="w-[180px] h-[180px] object-contain rounded-lg shadow-sm"
                             loading="eager"
                             onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($memberBarcode->barcode_code) }}&format=png&margin=2'">
                    </div>
                </div>

                <div class="mb-4">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 block mb-1">Kode Anggota</span>
                    <span class="font-mono text-sm font-bold text-gray-800 bg-gray-100 px-3.5 py-1.5 rounded-lg inline-block border border-gray-200 tracking-wider">
                        {{ $memberBarcode->barcode_code }}
                    </span>
                </div>

                <p class="text-xs text-gray-500 leading-relaxed max-w-xs mx-auto mb-5">
                    Arahkan QR Code ini ke kamera atau pemindai petugas untuk verifikasi kunjungan harian.
                </p>

                <button type="button"
                        onclick="event.stopPropagation(); closeQrModal();"
                        class="w-full py-3 px-4 bg-gray-900 hover:bg-black active:scale-[0.98] text-white text-sm font-semibold rounded-xl transition-all shadow-sm cursor-pointer touch-manipulation">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <script>
        // ── BUKA MODAL KARTU PENUH ──
        function openCardModal() {
            const modal = document.getElementById('card-modal');
            if (!modal) return;
            const inner = document.getElementById('card-modal-inner');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                if (inner) {
                    inner.classList.remove('scale-95', 'opacity-0');
                    inner.classList.add('scale-100', 'opacity-100');
                }
            });
        }

        function closeCardModal() {
            const modal = document.getElementById('card-modal');
            if (!modal) return;
            const inner = document.getElementById('card-modal-inner');

            if (inner) {
                inner.classList.remove('scale-100', 'opacity-100');
                inner.classList.add('scale-95', 'opacity-0');
            }

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                const qrModal = document.getElementById('qr-modal');
                if (!qrModal || qrModal.classList.contains('hidden')) {
                    document.body.style.overflow = '';
                }
            }, 180);
        }

        // ── BUKA MODAL QR PRESENSI KHUSUS ──
        function openQrModal() {
            const modal = document.getElementById('qr-modal');
            if (!modal) return;
            const inner = document.getElementById('qr-modal-inner');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                if (inner) {
                    inner.classList.remove('scale-95', 'opacity-0');
                    inner.classList.add('scale-100', 'opacity-100');
                }
            });
        }

        function closeQrModal() {
            const modal = document.getElementById('qr-modal');
            if (!modal) return;
            const inner = document.getElementById('qr-modal-inner');

            if (inner) {
                inner.classList.remove('scale-100', 'opacity-100');
                inner.classList.add('scale-95', 'opacity-0');
            }

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                const cardModal = document.getElementById('card-modal');
                if (!cardModal || cardModal.classList.contains('hidden')) {
                    document.body.style.overflow = '';
                }
            }, 180);
        }

        // Pasang event listener langsung ke tombol close untuk memastikan klik mobile selalu terdeteksi
        document.addEventListener('DOMContentLoaded', function() {
            const btnCloseQr = document.getElementById('btn-close-qr-modal');
            if (btnCloseQr) {
                btnCloseQr.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeQrModal();
                });
            }

            const btnCloseCard = document.getElementById('btn-close-card-modal');
            if (btnCloseCard) {
                btnCloseCard.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeCardModal();
                });
            }
        });

        // ESC key handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const qrModal = document.getElementById('qr-modal');
                const cardModal = document.getElementById('card-modal');
                if (qrModal && !qrModal.classList.contains('hidden')) {
                    closeQrModal();
                } else if (cardModal && !cardModal.classList.contains('hidden')) {
                    closeCardModal();
                }
            }
        });
    </script>
    @endif

</body>
</html>
