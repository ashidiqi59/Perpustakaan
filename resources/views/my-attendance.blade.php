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

        /* Card shine effect */
        .card-shine {
            background: linear-gradient(135deg, #0F2854 0%, #1B3A8F 45%, #1E3A8A 65%, #0F2854 100%);
        }
    </style>
</head>
<body>
    <x-page-loader />
    @include('components.navbar')

    <div class="min-h-screen pt-20 sm:pt-24 pb-12 sm:pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-2 flex items-center gap-3">
                            <i class="fas fa-calendar-check library-primary"></i>
                            <span>Riwayat Kunjungan</span>
                        </h1>
                        <p class="text-xs sm:text-base text-gray-600">Catatan kehadiran Anda di perpustakaan</p>
                    </div>
                    <a href="{{ route('profile') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-id-card text-indigo-500"></i> Lihat Kartu Anggota
                    </a>
                </div>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- ── MINI KARTU ANGGOTA + STATS ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                {{-- Mini Kartu Anggota --}}
                @if($memberBarcode)
                <div class="md:col-span-1 relative overflow-hidden rounded-2xl shadow-lg card-shine p-5 cursor-pointer group"
                     onclick="openQrModal()" title="Klik untuk lihat QR Code">

                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-10"
                         style="background: radial-gradient(circle, #60A5FA, transparent); transform: translate(30%, -30%);"></div>

                    <div class="relative z-10 flex items-center gap-3 mb-4">
                        <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}"
                             class="w-11 h-11 rounded-xl object-cover ring-2 ring-white/30 flex-shrink-0">
                        <div class="min-w-0">
                            <p class="text-white font-bold text-sm truncate">{{ $user->name }}</p>
                            @if($user->npm)
                                <p class="text-blue-200 text-xs font-mono">{{ $user->npm }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-white/40 text-[9px] uppercase tracking-widest">Kartu Anggota</p>
                            <p class="text-white/70 text-[10px] font-mono mt-0.5">{{ $memberBarcode->barcode_code }}</p>
                        </div>
                        <div class="w-8 h-8 bg-white/15 group-hover:bg-white/25 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-qrcode text-white text-sm"></i>
                        </div>
                    </div>

                    <div class="relative z-10 mt-3 pt-3 border-t border-white/10">
                        <span class="flex items-center gap-1.5 text-emerald-300 text-[10px] font-semibold">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                            Anggota Aktif · Member Since {{ $user->created_at->format('Y') }}
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

    {{-- ── MODAL KARTU ANGGOTA (sama dengan profil) ── --}}
    @if($memberBarcode)
    <style>
        .chip-glow2 { filter: drop-shadow(0 2px 6px rgba(255,255,255,0.2)); }
        #qr-modal { transition: opacity 0.25s ease; }
        #qr-modal-inner { transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), opacity 0.25s ease; }
        #qr-modal-canvas img, #qr-modal-canvas canvas { border-radius: 10px !important; display: block !important; }
    </style>
    <div id="qr-modal"
         class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         style="background: rgba(0,0,0,0.75); backdrop-filter: blur(10px); opacity: 0; pointer-events: none;"
         onclick="closeQrModal(event)">

        <div id="qr-modal-inner"
             class="w-full max-w-sm"
             style="transform: scale(0.85) translateY(20px); opacity: 0;">

            {{-- Kartu Premium --}}
            <div class="relative overflow-hidden rounded-3xl shadow-2xl mb-4"
                 style="background: linear-gradient(135deg, #0D1F4E 0%, #162C7A 35%, #1E3A8A 60%, #12235F 100%);">

                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-[0.08]"
                         style="background: radial-gradient(circle, #93C5FD, transparent);"></div>
                    <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full opacity-[0.08]"
                         style="background: radial-gradient(circle, #A5B4FC, transparent);"></div>
                </div>

                <div class="relative z-10 p-6">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <svg class="chip-glow2 w-10 h-8" viewBox="0 0 50 38" fill="none">
                                <rect x="1" y="1" width="48" height="36" rx="5" fill="url(#cg3)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                                <rect x="17" y="1" width="16" height="36" fill="rgba(255,255,255,0.07)"/>
                                <rect x="1" y="13" width="48" height="12" fill="rgba(255,255,255,0.07)"/>
                                <line x1="17" y1="1" x2="17" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                <line x1="33" y1="1" x2="33" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                <line x1="1" y1="13" x2="49" y2="13" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                <line x1="1" y1="25" x2="49" y2="25" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                <rect x="20" y="16" width="10" height="6" rx="1.5" fill="rgba(255,255,255,0.25)"/>
                                <defs>
                                    <linearGradient id="cg3" x1="0" y1="0" x2="50" y2="38" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#C8A84B"/>
                                        <stop offset="50%" stop-color="#F0D080"/>
                                        <stop offset="100%" stop-color="#A87820"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div>
                                <p class="text-white/45 text-[9px] uppercase tracking-[0.2em] font-semibold">Kartu Anggota</p>
                                <p class="text-white text-sm font-bold">Perpustakaan</p>
                            </div>
                        </div>
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold"
                              style="background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.3); color: #6EE7B7;">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                            Aktif
                        </span>
                    </div>

                    {{-- Photo + info --}}
                    <div class="flex items-center gap-4 mb-5">
                        <img src="{{ $user->getAvatarUrl() }}"
                             alt="{{ $user->name }}"
                             class="w-14 h-14 rounded-2xl object-cover flex-shrink-0"
                             style="box-shadow: 0 0 0 2px rgba(255,255,255,0.2), 0 0 0 4px rgba(255,255,255,0.05);">
                        <div class="min-w-0">
                            <p class="text-white font-bold text-base leading-tight truncate">{{ $user->name }}</p>
                            @if($user->npm)
                                <p class="text-blue-200/80 text-xs mt-1 font-mono">{{ $user->npm }}</p>
                            @endif
                            @if($user->prodi)
                                <p class="text-white/45 text-xs mt-0.5 truncate">{{ $user->prodi }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- QR Besar --}}
                    <div class="flex flex-col items-center mb-5">
                        <div id="qr-modal-canvas"
                             class="rounded-2xl overflow-hidden"
                             style="padding: 10px; background: white; width: 200px; height: 200px;"></div>
                        <p class="text-white/30 text-[9px] uppercase tracking-widest mt-2">Scan untuk Check-In</p>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-end justify-between pt-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                        <div>
                            <p class="text-white/25 text-[8px] uppercase tracking-widest mb-0.5">Member ID</p>
                            <p class="text-white/55 text-[10px] font-mono tracking-wider">{{ $memberBarcode->barcode_code }}</p>
                            <p class="text-white/25 text-[8px] uppercase tracking-widest mt-1">Since {{ $user->created_at->format('Y') }}</p>
                        </div>
                        <div class="flex">
                            <div class="w-6 h-6 rounded-full opacity-50" style="background:#EB001B;"></div>
                            <div class="w-6 h-6 rounded-full opacity-50 -ml-3" style="background:#F79E1B;"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol tutup --}}
            <button onclick="closeQrModal()"
                    class="w-full py-3 rounded-2xl text-white text-sm font-semibold transition-all"
                    style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.15);"
                    onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                <i class="fas fa-times mr-2"></i>Tutup
            </button>
        </div>
    </div>

    <script>
        let qrModalRendered = false;

        function openQrModal() {
            const modal = document.getElementById('qr-modal');
            const inner = document.getElementById('qr-modal-inner');
            modal.style.pointerEvents = 'all';
            modal.style.display = 'flex';
            requestAnimationFrame(() => {
                modal.style.transition = 'opacity 0.25s ease';
                modal.style.opacity = '1';
                inner.style.transition = 'transform 0.35s cubic-bezier(.34,1.56,.64,1), opacity 0.25s ease';
                inner.style.transform = 'scale(1) translateY(0)';
                inner.style.opacity = '1';
            });
            document.body.style.overflow = 'hidden';

            if (!qrModalRendered) {
                new QRCode(document.getElementById('qr-modal-canvas'), {
                    text: '{{ $memberBarcode->barcode_code }}',
                    width: 180,
                    height: 180,
                    colorDark: '#0D1F4E',
                    colorLight: '#FFFFFF',
                    correctLevel: QRCode.CorrectLevel.M
                });
                qrModalRendered = true;
            }
        }

        function closeQrModal(e) {
            if (e && e.target !== document.getElementById('qr-modal')) return;
            const modal = document.getElementById('qr-modal');
            const inner = document.getElementById('qr-modal-inner');
            modal.style.opacity = '0';
            inner.style.transform = 'scale(0.9) translateY(10px)';
            inner.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.pointerEvents = 'none';
                document.body.style.overflow = '';
            }, 250);
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeQrModal(); });
    </script>
    @endif

</body>
</html>
