<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Detail Peminjaman</title>
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
                        <h2 class="text-xl font-semibold text-slate-800">Detail Peminjaman</h2>
                        <p class="text-sm text-slate-500">Informasi lengkap peminjaman</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.loans.edit', $loan->id) }}" class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-edit"></i>Edit
                        </a>
                        <a href="{{ route('admin.loans.index') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-arrow-left"></i>Kembali
                        </a>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    <div class="max-w-4xl mx-auto space-y-6">
                        <!-- STATUS BADGE -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Status Peminjaman</h3>
                                    @if($loan->getActualStatus() === 'peminjaman')
                                        <span class="px-4 py-2 bg-amber-100 text-amber-700 rounded-full font-medium text-lg">
                                            <i class="fas fa-hourglass-half mr-2"></i>Peminjaman Aktif
                                        </span>
                                    @elseif($loan->getActualStatus() === 'dikembalikan')
                                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-medium text-lg">
                                            <i class="fas fa-check-circle mr-2"></i>Sudah Dikembalikan
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full font-medium text-lg">
                                            <i class="fas fa-exclamation-circle mr-2"></i>Terlambat
                                        </span>
                                    @endif
                                </div>
                                @if($loan->getActualStatus() === 'terlambat')
                                    <div class="text-right">
                                        <p class="text-red-600 font-semibold text-lg">{{ $loan->getDaysLate() }} hari terlambat</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- PEMINJAM INFO -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Peminjam</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Nama</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->user->name }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">NPM</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->user->npm }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Email</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->user->email }}</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Role</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ ucfirst($loan->user->role) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- BUKU INFO -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Buku</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    @if($loan->book->image)
                                        <img src="{{ asset($loan->book->image) }}" alt="{{ $loan->book->title }}"
                                            class="w-32 h-48 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-32 h-48 bg-slate-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-book text-slate-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="border-l-4 border-green-500 pl-4 mb-4">
                                        <p class="text-sm text-slate-500 mb-1">Judul</p>
                                        <p class="text-lg font-semibold text-slate-800">{{ $loan->book->title }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-4 mb-4">
                                        <p class="text-sm text-slate-500 mb-1">Penulis</p>
                                        <p class="text-lg font-semibold text-slate-800">{{ $loan->book->author }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-4 mb-4">
                                        <p class="text-sm text-slate-500 mb-1">ISBN</p>
                                        <p class="text-lg font-semibold text-slate-800">{{ $loan->book->isbn }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <p class="text-sm text-slate-500 mb-1">Penerbit</p>
                                        <p class="text-lg font-semibold text-slate-800">{{ $loan->book->publisher }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TANGGAL & DURASI -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-slate-800 mb-4">Tanggal & Durasi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Tanggal Peminjaman</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->loan_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $loan->loan_date->format('l') }}</p>
                                </div>
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Tanggal Tenggat</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->due_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $loan->due_date->format('l') }}</p>
                                </div>
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <p class="text-sm text-slate-500 mb-1">Durasi Peminjaman</p>
                                    <p class="text-lg font-semibold text-slate-800">{{ $loan->loan_date->diffInDays($loan->due_date) }} hari</p>
                                    <p class="text-xs text-slate-500 mt-1">Standar</p>
                                </div>
                            </div>
                        </div>

                        <!-- PENGEMBALIAN -->
                        @if($loan->return_date)
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Pengembalian</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <p class="text-sm text-slate-500 mb-1">Tanggal Dikembalikan</p>
                                        <p class="text-lg font-semibold text-slate-800">{{ $loan->return_date->format('d/m/Y') }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $loan->return_date->format('l') }}</p>
                                    </div>
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <p class="text-sm text-slate-500 mb-1">Status Pengembalian</p>
                                        @if($loan->return_date->isAfter($loan->due_date))
                                            <p class="text-lg font-semibold text-red-600">Terlambat</p>
                                            <p class="text-xs text-red-500 mt-1">{{ $loan->return_date->diffInDays($loan->due_date) }} hari setelah tenggat</p>
                                        @else
                                            <p class="text-lg font-semibold text-green-600">Tepat Waktu</p>
                                            <p class="text-xs text-green-500 mt-1">{{ $loan->due_date->diffInDays($loan->return_date) }} hari sebelum tenggat</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- CATATAN -->
                        @if($loan->notes)
                            <div class="bg-white rounded-xl shadow-sm p-6">
                                <h3 class="text-lg font-semibold text-slate-800 mb-4">Catatan</h3>
                                <div class="bg-slate-50 p-4 rounded-lg">
                                    <p class="text-slate-700">{{ $loan->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- ACTIONS -->
                        <div class="flex gap-4">
                            <a href="{{ route('admin.loans.edit', $loan->id) }}" class="flex-1 px-6 py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-medium text-center">
                                <i class="fas fa-edit mr-2"></i>Edit Peminjaman
                            </a>
                            @if($loan->getActualStatus() !== 'dikembalikan')
                                <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="w-full px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium" onclick="return confirm('Kembalikan buku ini?')">
                                        <i class="fas fa-undo mr-2"></i>Kembalikan Buku
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.loans.index') }}" class="flex-1 px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors font-medium text-center">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
