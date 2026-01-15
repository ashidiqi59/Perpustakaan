<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan | Riwayat Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    </style>
</head>
<body>
    @include('components.navbar')

    <div class="min-h-screen pt-24 pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-history library-primary mr-3"></i>Riwayat Peminjaman
                </h1>
                <p class="text-gray-600">Kelola peminjaman buku Anda</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 border-l-4 border-amber-500 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Peminjaman Aktif</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $loans->filter(fn($l) => $l->getActualStatus() === 'peminjaman')->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-amber-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border-l-4 border-red-500 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Terlambat</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $loans->filter(fn($l) => $l->getActualStatus() === 'terlambat')->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border-l-4 border-green-500 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Dikembalikan</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $loans->filter(fn($l) => $l->getActualStatus() === 'dikembalikan')->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @if($loans->count() > 0)
                    <!-- Table for desktop -->
                    <div class="overflow-x-auto hidden md:block">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Buku</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Pinjam</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tenggat</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dikembalikan</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($loans as $loan)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $loan->book->title }}</p>
                                                <p class="text-sm text-gray-600">{{ $loan->book->author }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $loan->loan_date->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="font-medium text-gray-900">{{ $loan->due_date->format('d/m/Y') }}</span>
                                            @if($loan->getActualStatus() === 'terlambat')
                                                <p class="text-xs text-red-600 font-semibold">{{ $loan->getDaysLate() }} hari terlambat</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($loan->getActualStatus() === 'peminjaman')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                                                    <i class="fas fa-hourglass-half mr-1"></i>Peminjaman
                                                </span>
                                            @elseif($loan->getActualStatus() === 'dikembalikan')
                                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                                    <i class="fas fa-check-circle mr-1"></i>Dikembalikan
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Terlambat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('books.show', $loan->book->id) }}"
                                               class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium hover:bg-blue-200 transition">
                                                Lihat Buku
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards for mobile -->
                    <div class="md:hidden space-y-4 p-4">
                        @foreach($loans as $loan)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $loan->book->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $loan->book->author }}</p>
                                    </div>
                                    @if($loan->getActualStatus() === 'peminjaman')
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium whitespace-nowrap ml-2">
                                            Pinjam
                                        </span>
                                    @elseif($loan->getActualStatus() === 'dikembalikan')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium whitespace-nowrap ml-2">
                                            Kembali
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium whitespace-nowrap ml-2">
                                            Lambat
                                        </span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 text-xs">Pinjam</p>
                                        <p class="font-medium text-gray-900">{{ $loan->loan_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-xs">Tenggat</p>
                                        <p class="font-medium text-gray-900">{{ $loan->due_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 text-xs">Kembali</p>
                                        <p class="font-medium text-gray-900">{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    @if($loan->getActualStatus() === 'terlambat')
                                        <div>
                                            <p class="text-gray-600 text-xs">Terlambat</p>
                                            <p class="font-medium text-red-600">{{ $loan->getDaysLate() }} hari</p>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('books.show', $loan->book->id) }}"
                                   class="w-full px-3 py-2 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition text-center">
                                    Lihat Buku
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $loans->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada peminjaman</h3>
                        <p class="text-gray-600 mb-6">Anda belum meminjam buku apapun. Jelajahi koleksi perpustakaan kami!</p>
                        <a href="{{ route('books.collection') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center gap-2">
                            <i class="fas fa-book"></i> Jelajahi Koleksi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html>
