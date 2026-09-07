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
        <div class="max-w-5xl mx-auto px-4 sm:px-6">

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
                <div class="gradient-header h-28 sm:h-36 relative"></div>
                <div class="px-6 pb-6 pt-0 relative">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between -mt-14 sm:-mt-16 mb-4 gap-4">
                        <div class="flex flex-col sm:flex-row items-center sm:items-end space-y-3 sm:space-y-0 sm:space-x-5 text-center sm:text-left">
                            <div class="relative">
                                <img src="{{ $user->getAvatarUrl() }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover ring-4 ring-white shadow-md bg-white">
                                @if($user->isGoogleUser())
                                    <span class="absolute -bottom-1 -right-1 bg-white p-1 rounded-full shadow border border-gray-100" title="Akun Google">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <div class="pt-2">
                                <div class="flex items-center justify-center sm:justify-start space-x-2">
                                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Status Badges -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 pt-2 sm:pt-0">
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

                        <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-5">
                            @csrf
                            @method('PUT')

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

    <!-- Footer minimal -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        <p>&copy; {{ date('Y') }} Perpustakaan. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
