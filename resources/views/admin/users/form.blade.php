@extends('layouts.admin')

@section('title', $action === 'create' ? 'Tambah Akun' : 'Edit User')
@section('subtitle', $action === 'create' ? 'Buat akun petugas atau pengguna baru' : 'Perbarui informasi profil dan hak akses pengguna')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- ALERT MESSAGES -->
        @if(isset($errors) && $errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl mb-6 text-sm flex items-start gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fas fa-exclamation-circle text-base"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-rose-900 mb-1">Periksa kembali formulir Anda:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs sm:text-sm text-rose-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ $action === 'create' ? route('admin.users.store') : route('admin.users.update', $user->id) }}"
              method="POST"
              class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            @csrf
            @if($action !== 'create')
                @method('PUT')
            @endif

            <!-- CARD HEADER / PROFILE OVERVIEW -->
            <div class="p-5 sm:p-7 bg-gradient-to-r from-slate-50 via-slate-50 to-blue-50/40 border-b border-slate-200/80">
                <div class="flex items-center gap-4 sm:gap-5">
                    @if($action === 'edit')
                        <div class="relative shrink-0">
                            <img src="{{ $user->getAvatarUrl() }}" 
                                 alt="{{ $user->name }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0F2854&color=ffffff&bold=true'"
                                 class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover border-2 border-white shadow-sm ring-1 ring-slate-200">
                            <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white 
                                {{ $user->role === 'admin' ? 'bg-amber-500' : ($user->role === 'petugas' ? 'bg-blue-500' : 'bg-emerald-500') }}"></span>
                        </div>
                    @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                            <i class="fas fa-user-plus text-2xl sm:text-3xl"></i>
                        </div>
                    @endif

                    <div class="min-w-0 flex-1">
                        @if($action === 'create')
                            <h3 class="text-lg sm:text-xl font-bold text-slate-800">Buat Akun Baru</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Lengkapi formulir di bawah untuk menambahkan pengguna atau staf baru ke sistem</p>
                        @else
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="text-lg sm:text-xl font-bold text-slate-900 truncate">{{ $user->name }}</h3>
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fas fa-shield-alt text-amber-600 text-[11px]"></i> Admin
                                    </span>
                                @elseif($user->role === 'petugas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fas fa-id-badge text-blue-600 text-[11px]"></i> Petugas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fas fa-user-graduate text-emerald-600 text-[11px]"></i> Pengunjung
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                                <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-slate-400"></i> {{ $user->email }}</span>
                                @if($user->npm && $user->role === 'pengunjung')
                                    <span class="flex items-center gap-1.5"><i class="fas fa-id-card text-slate-400"></i> NPM: {{ $user->npm }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FORM FIELDS BODY -->
            <div class="p-5 sm:p-7 space-y-5">
                
                <!-- ROLE SELECTION / DISPLAY -->
                @if($action === 'edit' && $user?->role === 'admin')
                    <!-- ADMIN ROLE: TERKUNCI (TIDAK BISA DIUBAH) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                            Role Pengguna
                        </label>
                        <div class="p-4 rounded-xl bg-gradient-to-r from-amber-50/90 via-amber-50/50 to-transparent border border-amber-200/90 flex items-start sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 border border-amber-200 text-amber-700 flex items-center justify-center text-lg shrink-0 shadow-2xs">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-slate-800">Administrator Sistem</span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-200/80 text-amber-900 border border-amber-300/50">
                                            <i class="fas fa-lock text-[9px]"></i> Permanen
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">Peran Administrator bersifat permanen dan tidak dapat diubah ke role lain.</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="role" value="admin">
                    </div>
                @else
                    <!-- ROLE SELECTOR (PETUGAS / PENGUNJUNG / CREATE MODE) -->
                    <div>
                        <label for="role-select" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                            <i class="fas fa-user-tag text-blue-600 text-xs"></i>
                            <span>Role Pengguna</span>
                            <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="role" id="role-select" required
                                class="w-full appearance-none pl-4 pr-10 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 font-medium cursor-pointer">
                                <option value="">Pilih Role</option>
                                @if($action === 'create')
                                    <option value="admin" {{ old('role', $user?->role) == 'admin' ? 'selected' : '' }}>Admin (Administrator)</option>
                                @endif
                                <option value="petugas" {{ old('role', $user?->role) == 'petugas' ? 'selected' : '' }}>Petugas (Scanner Barcode & Sirkulasi)</option>
                                <option value="pengunjung" {{ old('role', $user?->role ?? 'pengunjung') == 'pengunjung' ? 'selected' : '' }}>Pengunjung (Mahasiswa / Anggota)</option>
                            </select>
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 flex items-center">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        @if($action === 'create')
                            <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                <span>Pilih <strong>Petugas</strong> untuk akun yang bertugas scan barcode peminjaman & pengembalian.</span>
                            </p>
                        @endif
                    </div>
                @endif

                <!-- NPM (Hanya untuk Pengunjung / Mahasiswa) -->
                <div id="npm-field-group" class="{{ in_array(old('role', $user?->role ?? 'pengunjung'), ['admin', 'petugas']) ? 'hidden' : '' }}">
                    <label for="npm-input" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Nomor Pokok Mahasiswa (NPM) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-id-card text-sm"></i>
                        </div>
                        <input type="text" name="npm" id="npm-input"
                            value="{{ old('npm', $user?->npm) }}"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium"
                            placeholder="Contoh: 714250017">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Wajib diisi untuk akun Pengunjung / Mahasiswa</p>
                </div>

                <!-- NAMA LENGKAP -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input type="text" name="name" id="name"
                            value="{{ old('name', $user?->name) }}" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium"
                            placeholder="Masukkan nama lengkap pengguna">
                    </div>
                </div>

                <!-- EMAIL -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user?->email) }}" required
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400 font-medium"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- PASSWORD SECTION -->
                <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-4 sm:p-5 space-y-3.5 mt-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5 text-slate-800 font-bold text-sm">
                            <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-key"></i>
                            </div>
                            <span>{{ $action === 'create' ? 'Kata Sandi Akun' : 'Ubah Kata Sandi' }}</span>
                        </div>
                        <span class="text-xs font-medium {{ $action === 'create' ? 'text-blue-600 bg-blue-50 border-blue-200' : 'text-slate-500 bg-white border-slate-200' }} px-2.5 py-0.5 rounded-full border">
                            {{ $action === 'create' ? 'Wajib Diisi' : 'Opsional' }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-500">
                        {{ $action === 'create' 
                            ? 'Tentukan password untuk login ke sistem (minimal 6 karakter).' 
                            : 'Kosongkan kedua kolom berikut jika tidak ingin memperbarui kata sandi akun ini.' }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                        <div>
                            <label for="password" class="block text-xs font-medium text-slate-600 mb-1">
                                {{ $action === 'create' ? 'Password Baru *' : 'Password Baru' }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fas fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="password" id="password"
                                    class="w-full pl-9 pr-3.5 py-2 text-sm bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400"
                                    placeholder="{{ $action === 'create' ? 'Min. 6 karakter' : 'Kosongkan jika tetap' }}"
                                    {{ $action === 'create' ? 'required' : '' }}>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-slate-600 mb-1">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <i class="fas fa-check-double text-xs"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full pl-9 pr-3.5 py-2 text-sm bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-slate-800 placeholder:text-slate-400"
                                    placeholder="Ulangi password"
                                    {{ $action === 'create' ? 'required' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FORM ACTIONS BAR -->
            <div class="px-5 py-4 sm:px-7 sm:py-5 bg-slate-50/80 border-t border-slate-200/80 flex flex-col-reverse sm:flex-row justify-end items-center gap-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="w-full sm:w-auto px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-sm font-medium rounded-xl border border-slate-300 shadow-2xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fas fa-arrow-left text-xs text-slate-400"></i>
                    <span>Batal</span>
                </a>

                <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 active:scale-98 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fas fa-{{ $action === 'create' ? 'user-plus' : 'save' }}"></i>
                    <span>{{ $action === 'create' ? 'Buat Akun' : 'Perbarui User' }}</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role-select');
        const npmGroup = document.getElementById('npm-field-group');

        function toggleNpmField() {
            if (!roleSelect || !npmGroup) return;
            const selectedRole = roleSelect.value;
            if (selectedRole === 'admin' || selectedRole === 'petugas') {
                npmGroup.classList.add('hidden');
            } else {
                npmGroup.classList.remove('hidden');
            }
        }

        if (roleSelect) {
            roleSelect.addEventListener('change', toggleNpmField);
            toggleNpmField();
        }
    });
    </script>
    @endpush
@endsection
