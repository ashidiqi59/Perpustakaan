@props([
    'user' => null,
    'memberBarcode' => null,
])

@php
    $user = $user ?? auth()->user();
    $memberBarcode = $memberBarcode ?? ($user ? $user->memberBarcode : null);
@endphp

@if($user && $memberBarcode)
<!-- ══════════════════════════════════════════════════ -->
<!-- COMPONENT: MODAL KARTU ANGGOTA & QR PRESENSI      -->
<!-- ══════════════════════════════════════════════════ -->

<!-- MODAL 1: TAMPILAN KARTU PENUH DIPERBESAR -->
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

                    {{-- QR Code di Kartu Besar (Klik ini untuk buka modal QR scanner) --}}
                    <div class="flex flex-col items-center flex-shrink-0 cursor-pointer group"
                         onclick="closeCardModal(); openQrModal();"
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

<!-- MODAL 2: KHUSUS QR CODE PRESENSI (SCAN PETUGAS) -->
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
