@extends('layouts.admin')

@section('title', 'Detail Pengguna')
@section('subtitle', 'Informasi lengkap akun pengguna perpustakaan')

@section('header-actions')
    @if($user->isPengunjung() && $user->memberBarcode)
        <button type="button" 
                onclick="openCardModal()" 
                class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center gap-1.5 sm:gap-2 shadow-sm cursor-pointer">
            <i class="fas fa-id-card"></i>
            <span class="hidden sm:inline">Lihat Kartu Anggota</span>
            <span class="sm:hidden">Kartu</span>
        </button>
    @endif
    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-amber-500 text-slate-900 text-xs sm:text-sm font-medium rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-1 sm:gap-2 shadow-sm">
        <i class="fas fa-edit"></i>
        <span class="hidden sm:inline">Edit Akun</span>
        <span class="sm:hidden">Edit</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2 shadow-sm">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
    <!-- PROFILE OVERVIEW CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-3">
            <!-- LEFT COLUMN: AVATAR & BASIC PROFILE -->
            <div class="p-6 sm:p-8 bg-slate-50/60 border-b lg:border-b-0 lg:border-r border-slate-200 flex flex-col items-center text-center justify-center">
                <div class="relative mb-4">
                    <img src="{{ $user->getAvatarUrl() }}" 
                         alt="{{ $user->name }}" 
                         class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl object-cover shadow-md border-4 border-white">
                    <span class="absolute bottom-1 right-1 w-5 h-5 rounded-full border-2 border-white 
                        {{ $user->role === 'admin' ? 'bg-amber-500' : ($user->role === 'petugas' ? 'bg-blue-500' : 'bg-emerald-500') }}"></span>
                </div>

                <h2 class="text-xl font-bold text-slate-900 mb-1">{{ $user->name }}</h2>
                
                @if($user->isPengunjung())
                    @if($user->npm)
                        <p class="text-xs font-mono text-slate-600 bg-slate-200/70 px-2.5 py-1 rounded-md mb-3 inline-flex items-center gap-1.5">
                            <i class="fas fa-id-card text-slate-500"></i>
                            <span>NPM: {{ $user->npm }}</span>
                        </p>
                    @else
                        <p class="text-xs text-amber-700 bg-amber-50 px-2.5 py-1 rounded-md mb-3 border border-amber-200 inline-flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-amber-500"></i>
                            <span>NPM Belum Diisi</span>
                        </p>
                    @endif
                @else
                    <p class="text-xs font-medium text-slate-600 bg-slate-200/60 px-3 py-1 rounded-md mb-3 inline-flex items-center gap-1.5">
                        <i class="fas {{ $user->isAdmin() ? 'fa-shield-alt text-amber-600' : 'fa-id-badge text-blue-600' }}"></i>
                        <span>{{ $user->isAdmin() ? 'Administrator Sistem' : 'Petugas Layanan & Sirkulasi' }}</span>
                    </p>
                @endif

                <!-- ROLE BADGE -->
                <div class="mb-4">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 shadow-2xs">
                            <i class="fas fa-shield-alt text-amber-600"></i>
                            <span>Admin Perpustakaan</span>
                        </span>
                    @elseif($user->role === 'petugas')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200 shadow-2xs">
                            <i class="fas fa-id-badge text-blue-600"></i>
                            <span>Petugas Perpustakaan</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-2xs">
                            <i class="fas fa-user-graduate text-emerald-600"></i>
                            <span>Pengunjung / Mahasiswa</span>
                        </span>
                    @endif
                </div>

                @if($user->isPengunjung() && $user->memberBarcode)
                    <!-- LIHAT KARTU ANGGOTA BUTTON (KHUSUS MAHASISWA) -->
                    <button type="button" 
                            onclick="openCardModal()" 
                            class="w-full max-w-[220px] mb-3 px-3.5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 hover:shadow-md active:scale-95 cursor-pointer">
                        <i class="fas fa-id-card text-sm"></i>
                        <span>Lihat Kartu Anggota</span>
                    </button>
                @endif

                <!-- GOOGLE OAUTH INDICATOR -->
                @if($user->isGoogleUser())
                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-600 bg-white border border-slate-200 px-2.5 py-1 rounded-full shadow-2xs">
                        <svg viewBox="0 0 24 24" width="14" height="14">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Terhubung ke Akun Google</span>
                    </span>
                @endif
            </div>

            <!-- RIGHT COLUMN: FULL DETAILS GRID -->
            <div class="lg:col-span-2 p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div>
                            @if($user->isPengunjung())
                                <h3 class="text-base sm:text-lg font-bold text-slate-800">Biodata Mahasiswa &amp; Anggota</h3>
                                <p class="text-xs text-slate-500">Rincian profil akademik terdaftar dalam sistem perpustakaan</p>
                            @else
                                <h3 class="text-base sm:text-lg font-bold text-slate-800">Informasi Profil &amp; Kredensial Staf</h3>
                                <p class="text-xs text-slate-500">Rincian akun dinas pengelola dan operator sistem perpustakaan</p>
                            @endif
                        </div>
                        @if($user->isPengunjung())
                            <span class="text-xs font-mono font-bold px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 shadow-2xs inline-flex items-center gap-1.5" title="Nomor Identitas Anggota Perpustakaan">
                                <i class="fas fa-id-card text-blue-500"></i>
                                <span>ID: {{ $user->memberBarcode?->barcode_code ?? ('MEMBER-' . $user->id) }}</span>
                            </span>
                        @else
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">
                                ID: #{{ $user->id }}
                            </span>
                        @endif
                    </div>

                    @if($user->isPengunjung())
                        <!-- BIODATA KHUSUS PENGUNJUNG / MAHASISWA -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- EMAIL -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-envelope text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Email Terdaftar</p>
                                    <p class="text-sm font-semibold text-slate-800 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- NPM -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-id-card text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Nomor Pokok Mahasiswa (NPM)</p>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->npm ?: '-' }}</p>
                                </div>
                            </div>

                            <!-- PROGRAM STUDI -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-graduation-cap text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Program Studi / Jurusan</p>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->prodi ?: '-' }}</p>
                                </div>
                            </div>

                            <!-- NO. HP -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-phone text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">No. Telepon / WhatsApp</p>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->phone ?: '-' }}</p>
                                </div>
                            </div>

                            <!-- STATUS KARTU ANGGOTA / BARCODE -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-id-card text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-slate-500 font-medium">Kartu Anggota Digital</p>
                                    <div class="mt-1 flex flex-wrap items-center gap-2">
                                        @if($user->memberBarcode)
                                            <span class="inline-flex items-center text-teal-700 font-mono text-xs font-semibold bg-teal-50 px-2.5 py-1 rounded-lg border border-teal-200">
                                                <i class="fas fa-check-circle mr-1 text-teal-500"></i>
                                                {{ $user->memberBarcode->barcode_code }}
                                            </span>
                                            <button type="button" 
                                                    onclick="openCardModal()" 
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white shadow-2xs transition-all active:scale-95 cursor-pointer"
                                                    title="Lihat Kartu Anggota Digital">
                                                <i class="fas fa-eye text-[10px]"></i>
                                                <span>Lihat Kartu</span>
                                            </button>
                                        @else
                                            <span class="text-xs text-slate-400">Belum di-generate</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- KEAMANAN PASSWORD -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-lock text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Kata Sandi (Password)</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-mono text-slate-400 select-none tracking-widest">••••••••••••</span>
                                        <span class="text-[11px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded font-medium">Terenkripsi Aman</span>
                                    </div>
                                </div>
                            </div>

                            <!-- ALAMAT -->
                            <div class="flex items-start gap-3 sm:col-span-2">
                                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-slate-500 font-medium">Alamat Domisili</p>
                                    <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $user->address ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- INFORMASI KHUSUS STAF (ADMIN & PETUGAS) - TANPA NPM & PRODI -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- EMAIL RESMI -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-envelope text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Email Akun Staf</p>
                                    <p class="text-sm font-semibold text-slate-800 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- JABATAN OPERASIONAL -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $user->isAdmin() ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas {{ $user->isAdmin() ? 'fa-user-tie' : 'fa-id-badge' }} text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Jabatan Operasional</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        @if($user->isAdmin())
                                            Administrator Utama (Super Admin)
                                        @else
                                            Petugas Pelayanan &amp; Sirkulasi
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- HAK AKSES SISTEM -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-key text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Hak Akses Sistem</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        @if($user->isAdmin())
                                            Akses Penuh Seluruh Sistem &amp; Kelola Akun
                                        @else
                                            Scanner Barcode, Sirkulasi &amp; Validasi Presensi
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- NO. KONTAK / WHATSAPP -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-phone text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">No. Telepon / WhatsApp</p>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->phone ?: '-' }}</p>
                                </div>
                            </div>

                            <!-- STATUS PENUGASAN -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-user-check text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Status Akun</p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Staf Internal Aktif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- KEAMANAN PASSWORD -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-lock text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500 font-medium">Kata Sandi (Password)</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-mono text-slate-400 select-none tracking-widest">••••••••••••</span>
                                        <span class="text-[11px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded font-medium">Terenkripsi Aman</span>
                                    </div>
                                </div>
                            </div>

                            <!-- ALAMAT DINAS / DOMISILI -->
                            <div class="flex items-start gap-3 sm:col-span-2">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-slate-500 font-medium">Domisili / Alamat</p>
                                    <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $user->address ?: '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- METADATA FOOTER -->
                <div class="pt-6 mt-6 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-3">
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-calendar-plus text-slate-400"></i>
                        <span>Bergabung: <strong>{{ $user->created_at ? $user->created_at->format('d F Y H:i') : '-' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-history text-slate-400"></i>
                        <span>Pembaruan Terakhir: <strong>{{ $user->updated_at ? $user->updated_at->format('d F Y H:i') : '-' }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($user->isPengunjung())
        <!-- LOANS SECTION (HANYA DITAMPILKAN UNTUK PENGUNJUNG / MAHASISWA) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-book-reader text-blue-600"></i>
                        <span>Aktivitas Peminjaman Buku</span>
                    </h3>
                    <p class="text-xs text-slate-500">Statistik dan riwayat buku yang pernah dipinjam oleh akun ini</p>
                </div>

                <!-- MINI STATS -->
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                        Total: {{ $loanStats['total'] }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                        Aktif: {{ $loanStats['active'] }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700">
                        Selesai: {{ $loanStats['returned'] }}
                    </span>
                    @if($loanStats['overdue'] > 0)
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-100 text-rose-700">
                            Terlambat: {{ $loanStats['overdue'] }}
                        </span>
                    @endif
                </div>
            </div>

            @if($user->loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-semibold tracking-wider">
                                <th class="py-3 px-4 text-center w-12">No</th>
                                <th class="py-3 px-4">Buku</th>
                                <th class="py-3 px-4">Tgl Pinjam</th>
                                <th class="py-3 px-4">Tenggat / Kembali</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($user->loans as $idx => $loan)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3 px-4 text-center text-xs text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-slate-900 line-clamp-1">{{ $loan->book->title ?? '-' }}</div>
                                        <div class="text-xs text-slate-500 font-mono">{{ $loan->book->isbn ?? '' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-slate-600">
                                        {{ $loan->loan_date ? $loan->loan_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-xs text-slate-600">
                                        @if($loan->return_date)
                                            <span class="text-emerald-600 font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>{{ $loan->return_date->format('d/m/Y') }}
                                            </span>
                                        @elseif($loan->due_date)
                                            <span class="{{ $loan->getActualStatus() === 'terlambat' ? 'text-rose-600 font-semibold' : 'text-slate-600' }}">
                                                {{ $loan->due_date->format('d/m/Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @php $status = $loan->getActualStatus(); @endphp
                                        @if($status === 'peminjaman')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Dipinjam</span>
                                        @elseif($status === 'dikembalikan')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Dikembalikan</span>
                                        @elseif($status === 'menunggu_konfirmasi')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
                                        @elseif($status === 'terlambat')
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-700">Terlambat</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('admin.loans.show', $loan->id) }}" 
                                           class="px-2.5 py-1 bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-600 rounded-lg text-xs font-medium transition-colors inline-flex items-center gap-1"
                                           title="Lihat Detail Transaksi">
                                            <i class="fas fa-eye text-xs"></i>
                                            <span>Lihat</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-slate-400">
                    <i class="fas fa-book-open text-2xl mb-2 text-slate-300 block"></i>
                    <p class="text-sm">Belum ada riwayat peminjaman buku untuk akun ini.</p>
                </div>
            @endif
        </div>
    @else
        <!-- WEWENANG & CAKUPAN TUGAS STAF (ADMIN & PETUGAS) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas {{ $user->isAdmin() ? 'fa-shield-alt text-amber-500' : 'fa-id-badge text-blue-500' }}"></i>
                        <span>Wewenang &amp; Cakupan Akses Fitur</span>
                    </h3>
                    <p class="text-xs text-slate-500">Tanggung jawab operasional dan modul sistem yang dapat diakses oleh akun ini</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ $user->isAdmin() ? 'Otoritas Super Admin' : 'Otoritas Petugas Sirkulasi' }}
                </span>
            </div>

            <div class="p-5 sm:p-6">
                @if($user->isAdmin())
                    <!-- GRID WEWENANG ADMIN -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-amber-600 font-semibold text-sm">
                                <i class="fas fa-users-cog"></i>
                                <span>Kelola Pengguna</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Akses penuh membuat, memperbarui, dan mengelola akun Admin, Petugas, serta Mahasiswa.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-blue-600 font-semibold text-sm">
                                <i class="fas fa-book"></i>
                                <span>Master Data Buku</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Menambah buku baru, edit stok fisik, upload sampul, kelola kategori, dan buku rekomendasi.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-emerald-600 font-semibold text-sm">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Sirkulasi &amp; Peminjaman</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Monitoring dan kontrol seluruh transaksi peminjaman buku, pengembalian, denda, dan keterlambatan.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-purple-600 font-semibold text-sm">
                                <i class="fas fa-qrcode"></i>
                                <span>Scanner &amp; Presensi</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Akses pemindai barcode untuk sirkulasi cepat di meja perpustakaan dan data kehadiran harian.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-indigo-600 font-semibold text-sm">
                                <i class="fas fa-chart-line"></i>
                                <span>Statistik &amp; Laporan</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Melihat ringkasan dasbor perpustakaan, analitik buku terpopuler, dan tren kunjungan anggota.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-slate-700 font-semibold text-sm">
                                <i class="fas fa-shield-alt"></i>
                                <span>Keamanan &amp; Konfigurasi</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Kontrol hak akses dan integritas data seluruh sistem perpustakaan digital.</p>
                        </div>
                    </div>
                @else
                    <!-- GRID WEWENANG PETUGAS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-blue-600 font-semibold text-sm">
                                <i class="fas fa-barcode"></i>
                                <span>Scanner Sirkulasi Meja</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Memindai barcode kartu anggota mahasiswa dan barcode buku saat pelayanan peminjaman fisik.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-emerald-600 font-semibold text-sm">
                                <i class="fas fa-undo-alt"></i>
                                <span>Validasi Pengembalian</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Memverifikasi pengembalian buku fisik, mengecek kondisi buku, dan memperbarui status menjadi selesai.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-purple-600 font-semibold text-sm">
                                <i class="fas fa-clipboard-check"></i>
                                <span>Presensi Kunjungan</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Melakukan scan barcode kartu digital anggota untuk pencatatan buku tamu/presensi harian.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-amber-600 font-semibold text-sm">
                                <i class="fas fa-clock"></i>
                                <span>Cek Peminjaman Aktif</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Memantau transaksi peminjaman yang sedang berjalan serta identifikasi buku yang terlambat kembali.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-teal-600 font-semibold text-sm">
                                <i class="fas fa-search"></i>
                                <span>Pencarian &amp; Cek Stok</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Membantu pengunjung memeriksa ketersediaan eksemplar buku di rak perpustakaan.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2.5 mb-1.5 text-slate-600 font-semibold text-sm">
                                <i class="fas fa-lock"></i>
                                <span>Hak Akses Terfokus</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Akun operasional pelayanan perpustakaan tanpa hak modifikasi akun admin tingkat lanjut.</p>
                        </div>
                    </div>
                @endif

                <!-- FOOTNOTE KEAMANAN STAF -->
                <div class="mt-5 p-3.5 bg-amber-50/70 border border-amber-200/80 rounded-xl flex items-center gap-3 text-xs text-amber-900">
                    <i class="fas fa-shield-alt text-amber-600 text-base shrink-0"></i>
                    <span>
                        <strong>Protokol Keamanan Staf:</strong> Akun ini memiliki hak akses operasional perpustakaan. Seluruh aktivitas pengelolaan terekam dalam sistem demi menjaga akuntabilitas data.
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- ACTION BUTTONS FOOTER -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3">
        @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="w-full sm:w-auto px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.')">
                    <i class="fas fa-trash"></i>
                    <span>Hapus Akun</span>
                </button>
            </form>
        @endif

        <a href="{{ route('admin.users.edit', $user->id) }}" 
           class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-900 text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fas fa-edit"></i>
            <span>Edit Akun</span>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    @if($user->isPengunjung() && $user->memberBarcode)
        @include('components.member-card-modals', ['user' => $user, 'memberBarcode' => $user->memberBarcode])
    @endif
@endsection

@push('styles')
<style>
    .card-security-pattern {
        background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 16px 16px;
    }
    .qr-box canvas,
    #qr-modal-big canvas,
    #qr-modal-card canvas {
        display: none !important;
    }
    .qr-box img,
    #qr-modal-big img,
    #qr-modal-card img {
        display: block !important;
    }
</style>
@endpush
