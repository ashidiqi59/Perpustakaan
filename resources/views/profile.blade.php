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

    <main class="flex-grow pt-20 sm:pt-24 pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-library-primary transition-colors flex items-center">
                            <i class="fas fa-home mr-1.5"></i>Beranda
                        </a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
                    <li class="font-semibold text-gray-800">Profil & Biodata</li>
                </ol>
            </nav>

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 flex items-start space-x-3 shadow-sm">
                    <i class="fas fa-check-circle text-emerald-600 text-lg mt-0.5"></i>
                    <div>
                        <p class="font-semibold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-5 py-4 rounded-xl mb-6 flex items-start space-x-3 shadow-sm">
                    <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5"></i>
                    <div>
                        <p class="font-semibold text-sm">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 flex items-start space-x-3 shadow-sm">
                    <i class="fas fa-exclamation-circle text-red-600 text-lg mt-0.5"></i>
                    <div>
                        <p class="font-semibold text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

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
                                <form action="{{ route('profile.avatar.remove') }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto kustom dan kembali ke foto bawaan?')">
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
                /* Card shine sweep animation */
                @keyframes cardShine {
                    0%   { transform: translateX(-100%) skewX(-15deg); }
                    100% { transform: translateX(250%) skewX(-15deg); }
                }
                .member-card-wrap { cursor: pointer; }
                .member-card-wrap:hover .card-shine-sweep { animation: cardShine 0.7s ease forwards; }
                .member-card-wrap:hover .member-card { transform: translateY(-3px); box-shadow: 0 28px 60px rgba(15,40,84,0.55); }
                .member-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }

                /* Chip SVG glow */
                .chip-glow { filter: drop-shadow(0 2px 6px rgba(255,255,255,0.2)); }

                /* Modal */
                #card-modal { transition: opacity 0.25s ease; }
                #card-modal.show { opacity: 1; pointer-events: all; }
                #card-modal-inner { transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), opacity 0.25s ease; }
                #card-modal.show #card-modal-inner { transform: scale(1) translateY(0); opacity: 1; }

                /* QR inside card sizing fix */
                #qr-member-card img, #qr-member-card canvas { border-radius: 6px !important; display: block !important; }
                #qr-modal-big img, #qr-modal-big canvas { border-radius: 10px !important; display: block !important; }
            </style>

            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white shadow-md">
                        <i class="fas fa-id-card text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Kartu Anggota Digital</h2>
                        <p class="text-xs text-gray-500">Klik kartu untuk melihat QR Code lengkap · Tunjukkan kepada petugas saat tiba</p>
                    </div>
                </div>

                {{-- ── KARTU YANG BISA DIKLIK ── --}}
                <div class="member-card-wrap inline-block w-full max-w-xl select-none" onclick="openCardModal()">
                    <div class="member-card relative overflow-hidden rounded-3xl shadow-2xl"
                         style="background: linear-gradient(135deg, #0D1F4E 0%, #162C7A 35%, #1E3A8A 60%, #12235F 100%); min-height: 210px;">

                        {{-- Background texture rings --}}
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-[0.07]"
                                 style="background: radial-gradient(circle, #93C5FD, transparent);"></div>
                            <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full opacity-[0.07]"
                                 style="background: radial-gradient(circle, #A5B4FC, transparent);"></div>
                            <div class="absolute top-1/2 left-1/3 w-96 h-96 rounded-full opacity-[0.04]"
                                 style="background: radial-gradient(circle, #BFDBFE, transparent); transform: translate(-50%,-50%);"></div>
                            {{-- Shine sweep element --}}
                            <div class="card-shine-sweep absolute inset-0 w-1/3"
                                 style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
                                        transform: translateX(-100%) skewX(-15deg);"></div>
                        </div>

                        <div class="relative z-10 p-5 sm:p-6 flex flex-col" style="min-height: 210px;">
                            {{-- Top: logo chip + status --}}
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    {{-- EMV Chip SVG --}}
                                    <svg class="chip-glow w-10 h-8" viewBox="0 0 50 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="1" y="1" width="48" height="36" rx="5" fill="url(#chipGrad)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                                        <rect x="17" y="1" width="16" height="36" fill="rgba(255,255,255,0.07)"/>
                                        <rect x="1" y="13" width="48" height="12" fill="rgba(255,255,255,0.07)"/>
                                        <line x1="17" y1="1" x2="17" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="33" y1="1" x2="33" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="1" y1="13" x2="49" y2="13" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="1" y1="25" x2="49" y2="25" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <rect x="20" y="16" width="10" height="6" rx="1.5" fill="rgba(255,255,255,0.25)"/>
                                        <defs>
                                            <linearGradient id="chipGrad" x1="0" y1="0" x2="50" y2="38" gradientUnits="userSpaceOnUse">
                                                <stop offset="0%" stop-color="#C8A84B"/>
                                                <stop offset="50%" stop-color="#F0D080"/>
                                                <stop offset="100%" stop-color="#A87820"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                    <div>
                                        <p class="text-white/45 text-[9px] uppercase tracking-[0.2em] font-semibold leading-none">Kartu Anggota</p>
                                        <p class="text-white text-sm font-bold leading-tight mt-0.5">Perpustakaan</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold"
                                          style="background: rgba(52,211,153,0.15); border: 1px solid rgba(52,211,153,0.3); color: #6EE7B7;">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                        Aktif
                                    </span>
                                    {{-- Small QR hint --}}
                                    <div class="hidden sm:flex items-center gap-1 text-white/30 text-[9px] uppercase tracking-wider">
                                        <i class="fas fa-expand-alt text-[8px]"></i> Klik lihat QR
                                    </div>
                                </div>
                            </div>

                            {{-- Middle: Photo + Info + QR --}}
                            <div class="flex items-center gap-4 flex-1">
                                {{-- Photo with ring --}}
                                <div class="relative flex-shrink-0">
                                    <img src="{{ $user->getAvatarUrl() }}"
                                         alt="{{ $user->name }}"
                                         class="w-[60px] h-[60px] sm:w-[70px] sm:h-[70px] rounded-2xl object-cover"
                                         style="box-shadow: 0 0 0 2px rgba(255,255,255,0.2), 0 0 0 4px rgba(255,255,255,0.05);">
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-white font-bold text-xl leading-tight truncate"
                                        style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">{{ $user->name }}</h3>
                                    @if($user->npm)
                                        <p class="text-blue-200/80 text-xs mt-1 font-mono tracking-wide">{{ $user->npm }}</p>
                                    @endif
                                    @if($user->prodi)
                                        <p class="text-white/45 text-xs mt-0.5 truncate">{{ $user->prodi }}</p>
                                    @endif
                                </div>

                                {{-- QR Code mini (desktop) --}}
                                <div class="flex-shrink-0 hidden sm:flex flex-col items-center gap-1.5">
                                    <div id="qr-member-card"
                                         class="rounded-xl overflow-hidden"
                                         style="padding: 6px; background: white; width: 108px; height: 108px;"
                                         title="QR Code check-in perpustakaan"></div>
                                </div>
                            </div>

                            {{-- QR mobile --}}
                            <div class="sm:hidden mt-4 flex justify-center">
                                <div id="qr-member-card-mobile"
                                     class="rounded-xl overflow-hidden"
                                     style="padding: 6px; background: white; width: 120px; height: 120px;"></div>
                            </div>

                            {{-- Footer --}}
                            <div class="flex items-end justify-between mt-4 pt-3.5" style="border-top: 1px solid rgba(255,255,255,0.08);">
                                <div>
                                    <p class="text-white/25 text-[8px] uppercase tracking-[0.2em] mb-0.5">Member ID</p>
                                    <p class="text-white/50 text-[10px] font-mono tracking-wider">{{ $memberBarcode->barcode_code }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <p class="text-white/25 text-[8px] uppercase tracking-widest">Since {{ $user->created_at->format('Y') }}</p>
                                    {{-- Mastercard-style circles --}}
                                    <div class="flex">
                                        <div class="w-5 h-5 rounded-full opacity-50" style="background:#EB001B;"></div>
                                        <div class="w-5 h-5 rounded-full opacity-50 -ml-2.5" style="background:#F79E1B;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hint di bawah kartu --}}
                    <p class="text-center text-xs text-gray-400 mt-2.5 flex items-center justify-center gap-1.5">
                        <i class="fas fa-hand-pointer text-gray-300"></i>
                        Klik kartu untuk melihat QR Code lengkap
                    </p>
                </div>
            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- MODAL KARTU PENUH                          --}}
            {{-- ══════════════════════════════════════════ --}}
            <div id="card-modal"
                 class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                 style="background: rgba(0,0,0,0.75); backdrop-filter: blur(10px);
                        opacity: 0; pointer-events: none;"
                 onclick="closeCardModal(event)">

                <div id="card-modal-inner"
                     class="w-full max-w-sm"
                     style="transform: scale(0.85) translateY(20px); opacity: 0;">

                    {{-- Kartu Full di Modal --}}
                    <div class="relative overflow-hidden rounded-3xl shadow-2xl mb-4"
                         style="background: linear-gradient(135deg, #0D1F4E 0%, #162C7A 35%, #1E3A8A 60%, #12235F 100%);">

                        {{-- BG blobs --}}
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-[0.08]"
                                 style="background: radial-gradient(circle, #93C5FD, transparent);"></div>
                            <div class="absolute -bottom-16 -left-16 w-56 h-56 rounded-full opacity-[0.08]"
                                 style="background: radial-gradient(circle, #A5B4FC, transparent);"></div>
                        </div>

                        <div class="relative z-10 p-6">
                            {{-- Header modal kartu --}}
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-3">
                                    <svg class="chip-glow w-10 h-8" viewBox="0 0 50 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="1" y="1" width="48" height="36" rx="5" fill="url(#chipGrad2)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                                        <rect x="17" y="1" width="16" height="36" fill="rgba(255,255,255,0.07)"/>
                                        <rect x="1" y="13" width="48" height="12" fill="rgba(255,255,255,0.07)"/>
                                        <line x1="17" y1="1" x2="17" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="33" y1="1" x2="33" y2="37" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="1" y1="13" x2="49" y2="13" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <line x1="1" y1="25" x2="49" y2="25" stroke="rgba(255,255,255,0.15)" stroke-width="0.8"/>
                                        <rect x="20" y="16" width="10" height="6" rx="1.5" fill="rgba(255,255,255,0.25)"/>
                                        <defs>
                                            <linearGradient id="chipGrad2" x1="0" y1="0" x2="50" y2="38" gradientUnits="userSpaceOnUse">
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

                            {{-- Photo + name --}}
                            <div class="flex items-center gap-4 mb-5">
                                <img src="{{ $user->getAvatarUrl() }}"
                                     alt="{{ $user->name }}"
                                     class="w-16 h-16 rounded-2xl object-cover flex-shrink-0"
                                     style="box-shadow: 0 0 0 2px rgba(255,255,255,0.2), 0 0 0 4px rgba(255,255,255,0.05);">
                                <div class="min-w-0">
                                    <h3 class="text-white font-bold text-lg leading-tight truncate">{{ $user->name }}</h3>
                                    @if($user->npm)
                                        <p class="text-blue-200/80 text-xs mt-1 font-mono">{{ $user->npm }}</p>
                                    @endif
                                    @if($user->prodi)
                                        <p class="text-white/45 text-xs mt-0.5">{{ $user->prodi }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- QR Code Besar (center) --}}
                            <div class="flex flex-col items-center mb-5">
                                <div id="qr-modal-big"
                                     class="rounded-2xl overflow-hidden"
                                     style="padding: 10px; background: white; width: 200px; height: 200px;"></div>
                                <p class="text-white/30 text-[9px] uppercase tracking-widest mt-2">Scan untuk Check-In</p>
                            </div>

                            {{-- Footer kartu modal --}}
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
                    <button onclick="closeCardModal()"
                            class="w-full py-3 rounded-2xl text-white text-sm font-semibold transition-all"
                            style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.15);"
                            onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const code = '{{ $memberBarcode->barcode_code }}';

                    // QR kecil dalam kartu (desktop)
                    new QRCode(document.getElementById('qr-member-card'), {
                        text: code, width: 96, height: 96,
                        colorDark: '#0D1F4E', colorLight: '#FFFFFF',
                        correctLevel: QRCode.CorrectLevel.M
                    });

                    // QR kecil mobile
                    const mobileEl = document.getElementById('qr-member-card-mobile');
                    if (mobileEl) {
                        new QRCode(mobileEl, {
                            text: code, width: 108, height: 108,
                            colorDark: '#0D1F4E', colorLight: '#FFFFFF',
                            correctLevel: QRCode.CorrectLevel.M
                        });
                    }
                });

                let qrBigRendered = false;

                function openCardModal() {
                    const modal = document.getElementById('card-modal');
                    const inner = document.getElementById('card-modal-inner');
                    modal.style.opacity = '0';
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

                    if (!qrBigRendered) {
                        new QRCode(document.getElementById('qr-modal-big'), {
                            text: '{{ $memberBarcode->barcode_code }}',
                            width: 180, height: 180,
                            colorDark: '#0D1F4E', colorLight: '#FFFFFF',
                            correctLevel: QRCode.CorrectLevel.M
                        });
                        qrBigRendered = true;
                    }
                }

                function closeCardModal(e) {
                    if (e && e.target !== document.getElementById('card-modal') && e.target !== document.getElementById('card-modal')) {
                        if (!e.target.closest('#card-modal > div') === false) return;
                    }
                    const modal = document.getElementById('card-modal');
                    const inner = document.getElementById('card-modal-inner');
                    modal.style.opacity = '0';
                    inner.style.transform = 'scale(0.9) translateY(10px)';
                    inner.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.display = 'none';
                        document.body.style.overflow = '';
                    }, 250);
                }

                // Close on ESC
                document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCardModal(); });
                // Close on backdrop click
                document.getElementById('card-modal').addEventListener('click', function(e) {
                    if (e.target === this) closeCardModal();
                });
            </script>
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
                                    <span>Simpan Perubahan Biodata</span>
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
