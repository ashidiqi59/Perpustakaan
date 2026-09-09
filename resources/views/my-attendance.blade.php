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

    {{-- Modal Kartu Penuh & Modal QR Presensi (Reusable Component) --}}
    @include('components.member-card-modals')

</body>
</html>
