<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} | Perpustakaan</title>
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

        .border-library {
            border-color: #2563EB;
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Status badge */
        .status-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .status-available {
            background-color: #D1FAE5;
            color: #059669;
        }

        .status-borrowed {
            background-color: #FEE2E2;
            color: #DC2626;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
    @include('components.navbar')

    <!-- Breadcrumb -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex items-center text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-library-primary">Beranda</a>
                <svg class="w-5 h-5 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-gray-800">{{ $book->title }}</span>
            </nav>
        </div>
    </div>

    <!-- Book Detail Section -->
    <section class="py-12 fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <!-- Book Cover -->
                    <div class="bg-gray-100 p-8 flex items-center justify-center">
                        <img src="{{ $book->image ? asset($book->image) : asset('images/books/spine&cover.jpg') }}"
                            alt="{{ $book->title }}"
                            class="w-64 h-96 object-cover rounded-lg shadow-lg">
                    </div>

                    <!-- Book Info -->
                    <div class="md:col-span-2 p-8">
                        <!-- Title & Status -->
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                                <p class="text-gray-500">ISBN: {{ $book->isbn }}</p>
                            </div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 {{ $book->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-sm font-medium">
                                    {{ $book->stock > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                        </div>

                        <!-- Category -->
                        @if($book->category)
                        <div class="mb-6">
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $book->category }}
                            </span>
                        </div>
                        @endif

                        <!-- Book Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="space-y-4">
                                @if($book->author)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Penulis</p>
                                        <p class="font-medium text-gray-800">{{ $book->author }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($book->publisher)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Penerbit</p>
                                        <p class="font-medium text-gray-800">{{ $book->publisher }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($book->language)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-language text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Bahasa</p>
                                        <p class="font-medium text-gray-800">{{ $book->language }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                @if($book->category)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-layer-group text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kategori</p>
                                        <p class="font-medium text-gray-800">{{ $book->category }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($book->shelf_number)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Lokasi Rak</p>
                                        <p class="font-medium text-gray-800">Rak {{ $book->shelf_number }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($book->published_date)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tahun Terbit</p>
                                        <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($book->published_date)->format('Y') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Info -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-8">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 {{ $book->stock > 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                        <i class="fas fa-book text-lg {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Stok Tersedia</p>
                                        <p class="text-2xl font-bold text-gray-800">{{ $book->stock }} Buku</p>
                                    </div>
                                </div>
                                @auth
                                    @if($userHasActiveLoan)
                                    <button disabled class="px-8 py-3 bg-yellow-500 text-white rounded-lg cursor-not-allowed flex items-center gap-2 font-semibold" title="Anda sudah meminjam buku ini">
                                        <i class="fas fa-check-circle"></i>
                                        Sudah Dipinjam
                                    </button>
                                    @elseif($book->stock > 0)
                                    <button onclick="showBorrowModal()" class="px-8 py-3 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold">
                                        <i class="fas fa-hand-holding"></i>
                                        Ajukan Peminjaman
                                    </button>
                                    @else
                                    <button disabled class="px-8 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed flex items-center gap-2 font-semibold">
                                        <i class="fas fa-times-circle"></i>
                                        Stok Habis
                                    </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="px-8 py-3 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold">
                                        <i class="fas fa-sign-in-alt"></i>
                                        Login untuk Meminjam
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Description -->
                        @if($book->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Back Button -->
                        <div class="flex justify-start">
                            <a href="{{ route('books.collection') }}" class="text-library-primary font-semibold hover:underline flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Koleksi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Borrow Modal -->
    <div id="borrowModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 transform transition-all">
            <div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">Ajukan Peminjaman</h3>
                <p class="text-gray-600 mb-6 text-center">Atur tanggal tenggat pengembalian</p>

                <form id="borrowForm" action="{{ route('borrow') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-calendar-check mr-1"></i>Durasi Peminjaman
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="duration" value="1" class="w-4 h-4 text-blue-600" onchange="updateDueDate(1)">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium text-gray-800">1 Hari</span>
                                    <p class="text-xs text-gray-500">Kembali pada {{ now()->addDay()->format('d/m/Y') }}</p>
                                </span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="duration" value="3" class="w-4 h-4 text-blue-600" onchange="updateDueDate(3)">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium text-gray-800">3 Hari</span>
                                    <p class="text-xs text-gray-500">Kembali pada {{ now()->addDays(3)->format('d/m/Y') }}</p>
                                </span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="duration" value="7" class="w-4 h-4 text-blue-600" checked onchange="updateDueDate(7)">
                                <span class="ml-3 flex-1">
                                    <span class="font-medium text-gray-800">7 Hari</span>
                                    <p class="text-xs text-gray-500">Kembali pada {{ now()->addDays(7)->format('d/m/Y') }}</p>
                                </span>
                            </label>
                        </div>
                        <input type="hidden" name="due_date" id="dueDateInput" value="{{ now()->addDays(7)->format('Y-m-d') }}">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeBorrowModal()" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-library-primary text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            Ajukan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        function showBorrowModal() {
            document.getElementById('borrowModal').classList.remove('hidden');
            document.getElementById('borrowModal').classList.add('flex');
        }

        function closeBorrowModal() {
            document.getElementById('borrowModal').classList.add('hidden');
            document.getElementById('borrowModal').classList.remove('flex');
        }

        function updateDueDate(days) {
            const today = new Date();
            const dueDate = new Date(today.getTime() + days * 24 * 60 * 60 * 1000);
            const year = dueDate.getFullYear();
            const month = String(dueDate.getMonth() + 1).padStart(2, '0');
            const date = String(dueDate.getDate()).padStart(2, '0');
            document.getElementById('dueDateInput').value = `${year}-${month}-${date}`;
        }

        // Close modal when clicking outside
        document.getElementById('borrowModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBorrowModal();
            }
        });
    </script>
</body>
</html>


