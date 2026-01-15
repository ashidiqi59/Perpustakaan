<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Kelola Peminjaman</title>
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
                        <h2 class="text-xl font-semibold text-slate-800">Kelola Peminjaman</h2>
                        <p class="text-sm text-slate-500">Kelola data peminjaman buku</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.loans.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Tambah Peminjaman
                        </a>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- ALERT MESSAGES -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- STATS CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Peminjaman Aktif</p>
                                    <p class="text-2xl font-bold text-slate-800">
                                        {{ $loans->where('status', 'peminjaman')->count() }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-hourglass-half text-amber-500 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Terlambat</p>
                                    <p class="text-2xl font-bold text-slate-800">
                                        {{ $loans->where('status', 'terlambat')->count() }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-slate-500">Dikembalikan</p>
                                    <p class="text-2xl font-bold text-slate-800">
                                        {{ $loans->where('status', 'dikembalikan')->count() }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <form action="{{ route('admin.loans.index') }}" method="GET" id="searchForm" class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Cari Peminjam</label>
                                <input type="text" name="search" placeholder="Nama atau NPM peminjam..." value="{{ request('search', '') }}"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 auto-search">
                            </div>
                            <div class="w-48">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 auto-search">
                                    <option value="">Semua Status</option>
                                    <option value="peminjaman" {{ request('status') === 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                    <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- LOANS TABLE -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($loans->count() > 0)
                            <table class="w-full">
                                <thead class="bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">No</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Peminjam</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Buku</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Tanggal Pinjam</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Tenggat</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Dikembalikan</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Status</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($loans as $index => $loan)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                {{ $loans->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div>
                                                    <p class="font-medium text-slate-800">{{ $loan->user->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $loan->user->npm }}</p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div>
                                                    <p class="font-medium text-slate-800">{{ $loan->book->title }}</p>
                                                    <p class="text-xs text-slate-500">{{ $loan->book->author }}</p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                {{ $loan->loan_date->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <span class="font-medium">{{ $loan->due_date->format('d/m/Y') }}</span>
                                                @if($loan->status === 'peminjaman' && now()->isAfter($loan->due_date))
                                                    <p class="text-xs text-red-600 font-semibold">{{ $loan->getDaysOverdue() }} hari terlambat</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                {{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($loan->status === 'peminjaman')
                                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                                                        <i class="fas fa-hourglass-half mr-1"></i>Peminjaman
                                                    </span>
                                                @elseif($loan->status === 'dikembalikan')
                                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                                        <i class="fas fa-check-circle mr-1"></i>Dikembalikan
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">
                                                        <i class="fas fa-exclamation-circle mr-1"></i>Terlambat
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.loans.show', $loan->id) }}"
                                                        class="p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.loans.edit', $loan->id) }}"
                                                        class="p-2 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($loan->status !== 'dikembalikan')
                                                        <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="p-2 text-slate-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                                title="Kembalikan"
                                                                onclick="return confirm('Kembalikan buku ini?')">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.loans.destroy', $loan->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- PAGINATION -->
                            <div class="px-6 py-4 border-t border-slate-200">
                                {{ $loans->links() }}
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-search text-slate-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-800 mb-2">Tidak ada peminjaman</h3>
                                <p class="text-slate-500">
                                    @if(request('search') || (request('status') && request('status') !== ''))
                                        Tidak ada peminjaman yang sesuai dengan pencarian.
                                    @else
                                        Belum ada peminjaman yang dicatat.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    <script>
        // Auto-submit search on input with debounce
        let searchTimeout;
        document.querySelectorAll('.auto-search').forEach(function(input) {
            input.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    document.getElementById('searchForm').submit();
                }, 400);
            });
            input.addEventListener('change', function() {
                clearTimeout(searchTimeout);
                document.getElementById('searchForm').submit();
            });
        });
    </script>
    </body>
</html>
