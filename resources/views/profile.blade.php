<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan | Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background-color: #F9FAFB;
            color: #1F2937;
        }
        .library-primary {
            color: #2563EB;
        }
        .bg-library-primary {
            background-color: #2563EB;
        }
        .bg-library-light {
            background-color: #EFF6FF;
        }
        .gradient-header {
            background: linear-gradient(135deg, #0F2854 0%, #1E40AF 100%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <x-page-loader />
    @include('components.navbar')

    <!-- Sub-Navbar / Breadcrumb -->
    @include('components.sub-navbar', ['title' => 'Profil & Biodata', 'maxWidth' => 'max-w-6xl'])

    <main class="flex-grow pt-6 sm:pt-8 pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            @if(isset($errors) && $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
                    <div class="flex items-center space-x-2 font-semibold text-sm mb-2">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                        <span>Mohon periksa kesalahan pengisian formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 pl-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Warning Callout if profile is incomplete -->
            @if(!$user->isProfileComplete())
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 p-5 rounded-r-xl mb-8 shadow-sm">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-id-card text-amber-600 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-amber-900">Biodata Anda Belum Lengkap!</h3>
                            <p class="text-sm text-amber-800 mt-1">
                                Anda telah berhasil login melalui Google. Untuk dapat melakukan peminjaman buku perpustakaan, mohon lengkapi biodata Anda terutama <strong>Nomor Pokok Mahasiswa (NPM)</strong> pada formulir di bawah ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Overview Header Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <!-- Blue Header Banner (Proporsional seimbang 50/50 dengan area putih) -->
                <div class="gradient-header h-20 sm:h-24 relative"></div>

                <!-- White Area Card -->
                <div class="px-6 sm:px-8 pb-6 pt-0 relative">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-4">
                        <div class="flex flex-col sm:flex-row items-center sm:items-center space-y-3 sm:space-y-0 sm:space-x-5 text-center sm:text-left">
                            
                            <!-- Avatar Wrapper (Setengah Biru, Setengah Putih) -->
                            <div class="-mt-12 sm:-mt-14 relative group cursor-pointer flex-shrink-0" onclick="document.getElementById('avatar-input').click()">
                                <img id="avatar-preview" 
                                     src="{{ $user->getAvatarUrl() }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover ring-4 ring-white shadow-xl bg-white transition-transform group-hover:scale-[1.02]">
                                
                                <!-- Hover camera overlay -->
                                <div class="absolute inset-0 bg-black/40 rounded-2xl flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <i class="fas fa-camera text-lg mb-1"></i>
                                    <span class="text-[9px] font-semibold tracking-wider uppercase">Ganti Foto</span>
                                </div>

                                <!-- Camera icon badge on bottom-right -->
                                <div class="absolute -bottom-1 -right-1 bg-blue-600 group-hover:bg-blue-700 text-white w-7 h-7 rounded-xl shadow-md border-2 border-white flex items-center justify-center transition-colors">
                                    <i class="fas fa-camera text-[10px]"></i>
                                </div>

                                @if($user->isGoogleUser())
                                    <span class="absolute -top-1 -right-1 bg-white p-1 rounded-full shadow border border-gray-100" title="Akun Google">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>

                            <!-- User Info (100% di area putih, jelas dan kontras tinggi) -->
                            <div class="pt-4 sm:pt-5">
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center justify-center sm:justify-start">
                                    <i class="far fa-envelope mr-1.5 text-gray-400"></i>
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>

                        <!-- Status Badges & Delete Custom Avatar Option (di area putih) -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 pt-2 sm:pt-4">
                            @if(!empty($user->avatar) && !str_starts_with($user->avatar, 'http'))
                                <form action="{{ route('profile.avatar.remove') }}" method="POST" class="inline" data-confirm="Hapus foto kustom dan kembali ke foto bawaan?" data-confirm-title="Hapus Foto Kustom" data-confirm-btn="Ya, Hapus Foto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 transition-colors border border-gray-200">
                                        <i class="fas fa-trash-alt mr-1 text-[10px]"></i> Hapus Foto Kustom
                                    </button>
                                </form>
                            @endif

                            @if($user->isProfileComplete())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <i class="fas fa-check-circle mr-1.5"></i> Biodata Lengkap
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 animate-pulse">
                                    <i class="fas fa-exclamation-triangle mr-1.5"></i> Biodata Belum Lengkap
                                </span>
                            @endif

                            @if($user->isGoogleUser())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    <i class="fab fa-google mr-1.5 text-blue-600"></i> Akun Google
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════════════════ --}}
            {{-- KARTU ANGGOTA DIGITAL (hanya untuk pengunjung)                   --}}
            {{-- ══════════════════════════════════════════════════════════════════ --}}
            @if($user->isPengunjung() && $memberBarcode)

            {{-- QR Code library (qrcodejs - browser native) --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

            <style>
                .member-card-container {
                    perspective: 1000px;
                }
                .member-card {
                    background: linear-gradient(135deg, #0A192F 0%, #0F2D59 45%, #1B4582 85%, #0B1C38 100%);
                    box-shadow: 0 16px 36px -10px rgba(11, 28, 56, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.12);
                    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
                }
                .member-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 24px 48px -12px rgba(11, 28, 56, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.2);
                }

                /* Subtle security line grid texture */
                .card-security-pattern {
                    background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
                    background-size: 16px 16px;
                }

                /* Hapus render duplikat QR Code (hanya tampilkan img, sembunyikan canvas) */
                .qr-box canvas,
                #qr-member-card canvas,
                #qr-member-card-mobile canvas,
                #qr-modal-big canvas,
                #qr-modal-card canvas {
                    display: none !important;
                }
                .qr-box img,
                #qr-member-card img,
                #qr-member-card-mobile img,
                #qr-modal-big img,
                #qr-modal-card img {
                    display: block !important;
                    margin: 0 auto !important;
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: contain !important;
                }
            </style>

            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-sm">
                            <i class="fas fa-id-card text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-gray-900">Kartu Anggota Digital</h2>
                            <p class="text-xs text-gray-500">Klik kartu untuk perbesar kartu · Klik QR untuk perbesar QR presensi</p>
                        </div>
                    </div>
                </div>

                {{-- ── KARTU DIGITAL ANGGOTA ── --}}
                <div class="member-card-container w-full max-w-xl">
                    {{-- Tampilan Mobile: Persis seperti di Halaman Kunjungan --}}
                    <div class="sm:hidden relative overflow-hidden rounded-2xl p-5 cursor-pointer group text-white select-none transition-all duration-300 active:scale-[0.99]"
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

                    {{-- Tampilan Desktop (Tampilan Penuh) --}}
                    <div class="hidden sm:block member-card relative overflow-hidden rounded-3xl p-6 sm:p-7 text-white cursor-pointer select-none"
                         onclick="openCardModal()"
                         role="button"
                         tabindex="0"
                         title="Klik kartu untuk melihat tampilan penuh">

                        {{-- Background Art & Watermark --}}
                        <div class="absolute inset-0 card-security-pattern pointer-events-none opacity-40"></div>
                        <div class="absolute -right-12 -bottom-12 w-64 h-64 pointer-events-none opacity-[0.06] text-white">
                            <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full transform rotate-6">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="absolute top-0 right-1/4 w-48 h-48 rounded-full bg-blue-400/10 blur-3xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col justify-between" style="min-height: 200px;">
                            {{-- Header Kartu: Logo Lembaga & Status --}}
                            <div class="flex items-center justify-between pb-4 border-b border-white/10">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-blue-200">
                                        <i class="fas fa-book-reader text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-[0.22em] font-semibold text-blue-200/70 leading-none">Kartu Tanda Anggota</p>
                                        <h3 class="text-white font-bold text-base tracking-wide mt-1 leading-none">Perpustakaan</h3>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 backdrop-blur-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Aktif
                                    </span>
                                </div>
                            </div>

                            {{-- Isi Kartu: Foto, Biodata & QR Code --}}
                            <div class="py-4 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    {{-- Foto Member --}}
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $user->getAvatarUrl() }}"
                                             alt="{{ $user->name }}"
                                             class="w-20 h-20 rounded-2xl object-cover ring-2 ring-white/20 shadow-md">
                                    </div>

                                    {{-- Teks Biodata --}}
                                    <div class="min-w-0">
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-medium uppercase tracking-wider bg-white/10 text-blue-200 mb-1">
                                            {{ $user->role === 'pengunjung' ? 'Anggota Pengunjung' : ucfirst($user->role) }}
                                        </span>
                                        <h4 class="text-xl font-bold text-white tracking-tight truncate leading-snug">
                                            {{ $user->name }}
                                        </h4>
                                        <div class="mt-1 space-y-0.5 text-xs text-blue-100/75">
                                            @if($user->npm)
                                                <p class="font-mono flex items-center gap-1.5 text-blue-200">
                                                    <i class="fas fa-id-badge text-[10px] opacity-70"></i>
                                                    <span>{{ $user->npm }}</span>
                                                </p>
                                            @endif
                                            @if($user->prodi)
                                                <p class="truncate flex items-center gap-1.5">
                                                    <i class="fas fa-graduation-cap text-[10px] opacity-70"></i>
                                                    <span class="truncate">{{ $user->prodi }}</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- QR Code Desktop: KLIK DI SINI BUKA MODAL QR --}}
                                <div class="flex flex-col items-center flex-shrink-0 cursor-pointer group"
                                     onclick="event.stopPropagation(); openQrModal();"
                                     title="Klik untuk memperbesar QR Code presensi">
                                    <div class="p-2 bg-white rounded-2xl shadow-md transition-transform group-hover:scale-105 group-hover:shadow-lg ring-2 ring-transparent group-hover:ring-blue-400/50">
                                        <div id="qr-member-card" class="qr-box flex items-center justify-center bg-white rounded-xl overflow-hidden" style="width: 88px; height: 88px;">
                                            <img src="{{ $memberBarcode->getQrCodeDataUri(120) }}"
                                                 alt="QR Code"
                                                 class="w-[88px] h-[88px] object-contain rounded-lg shadow-sm"
                                                 loading="eager"
                                                 onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($memberBarcode->barcode_code) }}&format=png&margin=1'">
                                        </div>
                                    </div>
                                    <span class="text-[9px] uppercase tracking-wider text-blue-200/70 group-hover:text-white font-medium mt-1.5 flex items-center gap-1 transition-colors">
                                        <i class="fas fa-qrcode text-[8px]"></i> Klik QR
                                    </span>
                                </div>
                            </div>

                            {{-- Footer Kartu: ID Anggota & Waktu Bergabung --}}
                            <div class="pt-3 border-t border-white/10 flex items-end justify-between">
                                <div>
                                    <p class="text-[8px] uppercase tracking-[0.2em] font-semibold text-blue-200/50">ID Anggota</p>
                                    <p class="text-sm font-mono font-bold tracking-wider text-white/90 mt-0.5">
                                        {{ $memberBarcode->barcode_code }}
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-[8px] uppercase tracking-[0.2em] font-semibold text-blue-200/50">Terdaftar Sejak</p>
                                    <p class="text-[11px] font-medium text-blue-100/80 mt-0.5">
                                        {{ $user->created_at->format('M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Petunjuk interaksi di bawah kartu --}}
                    <div class="mt-2.5 flex items-center justify-center gap-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1.5 cursor-pointer hover:text-gray-600" onclick="openCardModal()">
                            <i class="fas fa-id-card text-gray-400"></i>
                            <span>Klik kartu untuk perbesar kartu</span>
                        </span>
                        <span class="text-gray-300">·</span>
                        <span class="flex items-center gap-1.5 cursor-pointer hover:text-gray-600" onclick="openQrModal()">
                            <i class="fas fa-qrcode text-gray-400"></i>
                            <span>Klik QR untuk presensi</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Modal Kartu Penuh & Modal QR Presensi (Reusable Component) --}}
            @include('components.member-card-modals')
            @endif

            <!-- Two Columns Layout for Forms -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Form Biodata (Span 2) -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <div class="flex items-center space-x-3 pb-6 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-library-primary">
                                <i class="fas fa-user-edit text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Kelengkapan Biodata Mahasiswa</h2>
                                <p class="text-xs text-gray-500">Informasi ini digunakan sebagai identitas peminjaman buku perpustakaan.</p>
                            </div>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                            @csrf
                            @method('PUT')

                            <!-- Foto Profil Upload Section -->
                            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                                <label class="block text-sm font-semibold text-gray-800 mb-1">
                                    Foto Profil
                                </label>
                                <p class="text-xs text-gray-500 mb-3">Pilih foto dari perangkat Anda untuk menggunakan foto profil sendiri.</p>
                                <div class="flex flex-wrap items-center gap-3">
                                    <input type="file" 
                                           name="avatar" 
                                           id="avatar-input" 
                                           accept="image/jpeg,image/png,image/jpg,image/webp" 
                                           class="hidden" 
                                           onchange="previewAvatar(this)">
                                    <label for="avatar-input" 
                                           class="cursor-pointer px-4 py-2 bg-white hover:bg-blue-50 text-library-primary text-xs font-semibold rounded-xl border border-blue-300 shadow-sm transition-all flex items-center space-x-2">
                                        <i class="fas fa-upload"></i>
                                        <span>Pilih Foto Baru</span>
                                    </label>
                                    <span id="avatar-filename" class="text-xs text-gray-500 truncate max-w-xs">Format: JPG, PNG, atau WEBP (Maks. 3MB)</span>
                                </div>
                            </div>

                            <!-- NPM -->
                            <div>
                                <label for="npm" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nomor Pokok Mahasiswa (NPM) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <input type="text" 
                                           name="npm" 
                                           id="npm" 
                                           value="{{ old('npm', $user->npm) }}" 
                                           placeholder="Contoh: 2024101001" 
                                           required 
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-mono">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Wajib diisi dengan NPM resmi kampus Anda.</p>
                            </div>

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           placeholder="Nama lengkap Anda" 
                                           required 
                                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                </div>
                            </div>

                            <!-- Email (Readonly) -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" 
                                           id="email" 
                                           value="{{ $user->email }}" 
                                           readonly 
                                           class="w-full pl-10 pr-24 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-600 cursor-not-allowed">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <span class="text-xs bg-emerald-100 text-emerald-700 font-semibold px-2 py-0.5 rounded-full flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                        </span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Email terikat dengan autentikasi akun dan tidak dapat diubah.</p>
                            </div>

                            <!-- Grid Prodi & Telepon -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Program Studi -->
                                <div>
                                    <label for="prodi" class="block text-sm font-semibold text-gray-700 mb-1">
                                        Program Studi / Jurusan
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <input type="text" 
                                               name="prodi" 
                                               id="prodi" 
                                               list="prodi-list"
                                               value="{{ old('prodi', $user->prodi) }}" 
                                               placeholder="Pilih atau ketik prodi..." 
                                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                        <datalist id="prodi-list">
                                            <option value="Teknik Informatika">
                                            <option value="Sistem Informasi">
                                            <option value="Teknologi Informasi">
                                            <option value="Ilmu Komputer">
                                            <option value="Manajemen Informatika">
                                            <option value="Ilmu Perpustakaan">
                                            <option value="Sains Data">
                                        </datalist>
                                    </div>
                                </div>

                                <!-- Nomor Telepon / WhatsApp -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">
                                        No. WhatsApp / HP
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                        <input type="tel" 
                                               name="phone" 
                                               id="phone" 
                                               value="{{ old('phone', $user->phone) }}" 
                                               placeholder="081234567890" 
                                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Domisili -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Alamat Domisili
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-3.5 flex items-start pointer-events-none text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <textarea name="address" 
                                              id="address" 
                                              rows="3" 
                                              placeholder="Alamat lengkap tempat tinggal saat ini..." 
                                              class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('address', $user->address) }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4 flex justify-end">
                                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Keamanan & Info Akun (Span 1) -->
                <div class="space-y-8">
                    
                    <!-- Password Setup Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                                <i class="fas fa-shield-alt text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Keamanan Password</h3>
                                <p class="text-xs text-gray-500">
                                    {{ empty($user->password) ? 'Atur password login mandiri' : 'Ganti password akun' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 mt-4 leading-relaxed">
                            @if(empty($user->password))
                                Anda mendaftar melalui akun Google. Anda dapat mengatur password di sini agar bisa masuk menggunakan NPM/Email & Password secara manual.
                            @else
                                Perbarui password Anda secara berkala untuk menjaga keamanan akun.
                            @endif
                        </p>

                        <form action="{{ route('profile.password') }}" method="POST" class="mt-5 space-y-4">
                            @csrf
                            @method('PUT')

                            @if(!empty($user->password))
                                <div>
                                    <label for="current_password" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Password Saat Ini
                                    </label>
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password" 
                                           required 
                                           class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-purple-500">
                                </div>
                            @endif

                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Password Baru
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       placeholder="Minimal 6 karakter" 
                                       required 
                                       class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Konfirmasi Password
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       placeholder="Ulangi password baru" 
                                       required 
                                       class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-purple-500">
                            </div>

                            <button type="submit" class="w-full mt-2 py-2.5 px-4 bg-gray-900 hover:bg-black text-white font-medium text-xs rounded-xl shadow transition-all flex items-center justify-center space-x-1.5">
                                <i class="fas fa-key"></i>
                                <span>{{ empty($user->password) ? 'Atur Password Baru' : 'Perbarui Password' }}</span>
                            </button>
                        </form>
                    </div>

                    <!-- Quick Shortcuts / Peminjaman Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-center space-x-3 mb-3">
                            <i class="fas fa-book-reader text-library-primary text-xl"></i>
                            <h4 class="font-bold text-gray-900 text-sm">Peminjaman Buku</h4>
                        </div>
                        <p class="text-xs text-gray-600 mb-4 leading-relaxed">
                            Lihat daftar riwayat buku yang sedang Anda pinjam atau yang telah dikembalikan.
                        </p>
                        <a href="{{ route('my-loans') }}" class="inline-flex items-center text-xs font-semibold text-library-primary hover:text-blue-800 transition-colors">
                            <span>Buka Riwayat Peminjaman</span>
                            <i class="fas fa-arrow-right ml-1.5 text-[10px]"></i>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </main>

    @include('components.footer')

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const filenameElem = document.getElementById('avatar-filename');
                if (filenameElem) {
                    filenameElem.innerText = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
                    filenameElem.classList.add('text-blue-600', 'font-medium');
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('avatar-preview');
                    if (previewImg) {
                        previewImg.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
