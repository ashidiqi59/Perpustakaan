<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Admin Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 font-sans">
        <div class="flex h-screen">
            @include('components.sidebar')

            <!-- MAIN CONTENT -->
            <main class="flex-1 flex flex-col overflow-hidden">
                <!-- TOP BAR -->
                <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">Dashboard</h2>
                        <p class="text-sm text-slate-500">Selamat datang, {{ Auth::user()->name }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm rounded-full font-medium">
                            <i class="fas fa-shield-alt mr-1"></i>Admin
                        </span>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- STAT CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Total Buku</p>
                                    <p class="text-2xl font-bold text-slate-800">1,245</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-book text-blue-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Total Users</p>
                                    <p class="text-2xl font-bold text-slate-800">328</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-green-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Peminjaman Aktif</p>
                                    <p class="text-2xl font-bold text-slate-800">56</p>
                                </div>
                                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-hand-holding text-amber-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Terlambat</p>
                                    <p class="text-2xl font-bold text-slate-800">8</p>
                                </div>
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QUICK ACTIONS -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                        <div class="flex flex-wrap gap-3">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Tambah Buku
                            </button>
                            <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Tambah User
                            </button>
                            <button class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors">
                                <i class="fas fa-clipboard-check mr-2"></i>Peminjaman
                            </button>
                            <button class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                                <i class="fas fa-file-export mr-2"></i>Export Laporan
                            </button>
                        </div>
                    </div>

                    <!-- RECENT ACTIVITY -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Peminjaman Terbaru</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-slate-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">Budi Santoso</p>
                                            <p class="text-sm text-slate-500">Throne of Blood</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-amber-600">Dipinjam</span>
                                </div>
                                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-slate-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">Siti Aminah</p>
                                            <p class="text-sm text-slate-500">1984 - George Orwell</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-green-600">Dikembalikan</span>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-slate-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800">Ahmad Rizki</p>
                                            <p class="text-sm text-slate-500">Fahrenheit 451</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-red-600">Terlambat</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Buku Populer</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 py-3 border-b border-slate-100">
                                    <span class="text-lg font-bold text-amber-500">1</span>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">Throne of Blood</p>
                                        <p class="text-sm text-slate-500">Kurosawa • 1957</p>
                                    </div>
                                    <span class="text-sm text-slate-500">45x dipinjam</span>
                                </div>
                                <div class="flex items-center gap-4 py-3 border-b border-slate-100">
                                    <span class="text-lg font-bold text-slate-400">2</span>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">1984</p>
                                        <p class="text-sm text-slate-500">George Orwell</p>
                                    </div>
                                    <span class="text-sm text-slate-500">38x dipinjam</span>
                                </div>
                                <div class="flex items-center gap-4 py-3 border-b border-slate-100">
                                    <span class="text-lg font-bold text-amber-700">3</span>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">Fahrenheit 451</p>
                                        <p class="text-sm text-slate-500">Ray Bradbury</p>
                                    </div>
                                    <span class="text-sm text-slate-500">32x dipinjam</span>
                                </div>
                                <div class="flex items-center gap-4 py-3">
                                    <span class="text-lg font-bold text-slate-400">4</span>
                                    <div class="flex-1">
                                        <p class="font-medium text-slate-800">To Kill a Mockingbird</p>
                                        <p class="text-sm text-slate-500">Harper Lee</p>
                                    </div>
                                    <span class="text-sm text-slate-500">28x dipinjam</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

