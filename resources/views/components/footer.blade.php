    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-20 sm:mt-28 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 sm:pt-20 pb-10 sm:pb-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 mb-12">
                <!-- Brand & Deskripsi (4 cols) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center space-x-3.5">
                        <div class="w-12 h-12 bg-blue-600 bg-library-primary rounded-xl flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-xl leading-tight">Perpustakaan</h3>
                            <p class="text-xs sm:text-sm text-gray-400">Sistem Informasi Perpustakaan</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed pr-2">
                        Sistem Informasi Perpustakaan Digital terpadu untuk memfasilitasi pencarian katalog buku, peminjaman mandiri, dan pencatatan presensi kehadiran civitas akademika.
                    </p>
                </div>
                
                <!-- Tautan Cepat (2 cols) -->
                <div class="lg:col-span-2">
                    <h4 class="text-white font-semibold text-base mb-5">Tautan Cepat</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('books.collection') }}" class="text-gray-400 hover:text-white transition-colors">Koleksi Buku</a></li>
                        <li><a href="{{ Auth::check() ? route('my-loans') : route('login') }}" class="text-gray-400 hover:text-white transition-colors">Peminjaman</a></li>
                        <li><a href="{{ Auth::check() ? route('my-attendance') : route('login') }}" class="text-gray-400 hover:text-white transition-colors">Presensi Kunjungan</a></li>
                        <li><a href="{{ Auth::check() ? route('profile') : route('login') }}" class="text-gray-400 hover:text-white transition-colors">Profil & Kartu Anggota</a></li>
                    </ul>
                </div>
                
                <!-- Jam Layanan (3 cols) -->
                <div class="lg:col-span-3">
                    <h4 class="text-white font-semibold text-base mb-5">Jam Layanan</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between items-center text-gray-300">
                            <span class="text-gray-400">Senin – Jumat</span>
                            <span class="font-medium text-white">08.00 – 16.30 WIB</span>
                        </li>
                        <li class="flex justify-between items-center text-gray-300">
                            <span class="text-gray-400">Sabtu</span>
                            <span class="font-medium text-white">09.00 – 13.00 WIB</span>
                        </li>
                        <li class="flex justify-between items-center text-gray-300">
                            <span class="text-gray-400">Minggu & Libur</span>
                            <span class="font-medium text-red-400">Tutup</span>
                        </li>
                    </ul>
                    <p class="text-xs text-gray-400 mt-4 leading-relaxed">
                        * Layanan katalog online dan reservasi buku digital tetap dapat diakses 24 jam.
                    </p>
                </div>
                
                <!-- Kontak & Lokasi (3 cols) -->
                <div class="lg:col-span-3">
                    <h4 class="text-white font-semibold text-base mb-5">Kontak & Lokasi</h4>
                    <ul class="space-y-3 text-sm text-gray-400 mb-5">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-gray-400 mt-1 shrink-0 text-sm"></i>
                            <span class="text-xs sm:text-sm leading-relaxed">Jl. Sariasih No. 54, Sarijadi, Kec. Sukasari, Kota Bandung 40151</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-gray-400 shrink-0 text-sm"></i>
                            <a href="mailto:perpustakaan@ulbi.ac.id" class="text-xs sm:text-sm hover:text-white transition-colors">perpustakaan@ulbi.ac.id</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-gray-400 shrink-0 text-sm"></i>
                            <span class="text-xs sm:text-sm">(022) 2014057</span>
                        </li>
                    </ul>

                    <div>
                        <div class="flex items-center space-x-2.5">
                            <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white rounded-xl flex items-center justify-center transition-colors" title="Facebook">
                                <i class="fab fa-facebook-f text-sm"></i>
                            </a>
                            <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white rounded-xl flex items-center justify-center transition-colors" title="Instagram">
                                <i class="fab fa-instagram text-sm"></i>
                            </a>
                            <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white rounded-xl flex items-center justify-center transition-colors" title="Twitter / X">
                                <i class="fab fa-twitter text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800/80 pt-8 text-center text-sm">
                <p class="text-gray-300">&copy; {{ date('Y') }} Perpustakaan. All rights reserved.</p>
                <p class="mt-2 text-gray-400 text-xs sm:text-sm">Sistem Informasi Perpustakaan Digital</p>
            </div>
        </div>
    </footer>
