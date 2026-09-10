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
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #F9FAFB; color: #1F2937; }
        .library-primary { color: #2563EB; }
        .bg-library-primary { background-color: #2563EB; }
        .bg-library-light { background-color: #EFF6FF; }

        /* Barcode modal styles */
        .barcode-modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.2s ease;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .barcode-modal {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.3s ease;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .barcode-modal-header { margin-bottom: 1.5rem; }
        .barcode-modal-icon {
            width: 64px; height: 64px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.75rem;
        }
        .barcode-modal-icon.loan { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
        .barcode-modal-icon.return { background: linear-gradient(135deg, #f0fdf4, #dcfce7); }

        .barcode-qr-wrap {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.25rem;
            margin: 1rem 0;
            border: 2px dashed #e2e8f0;
        }
        .barcode-qr-wrap img, .barcode-qr-wrap svg {
            max-width: 200px; width: 100%; height: auto;
            margin: 0 auto; display: block;
        }

        /* Countdown timer */
        .countdown-wrap {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            margin: 1rem 0;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .countdown-wrap.expired {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
        }
        .countdown-time {
            font-size: 1.4rem; font-weight: 800;
            color: #92400e;
            font-variant-numeric: tabular-nums;
        }
        .countdown-wrap.expired .countdown-time { color: #991b1b; }

        .token-display {
            font-size: 0.65rem;
            font-family: monospace;
            color: #94a3b8;
            word-break: break-all;
            margin-top: 8px;
        }

        /* Status pill in table */
        .status-pill {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 20px;
            font-size: 0.72rem; font-weight: 600;
        }
        .status-menunggu    { background: #fef3c7; color: #92400e; }
        .status-peminjaman  { background: #fef9c3; color: #713f12; }
        .status-terlambat   { background: #fee2e2; color: #991b1b; }
        .status-dikembalikan { background: #dcfce7; color: #166534; }
        .status-menunggu-kembali { background: #ede9fe; color: #5b21b6; }
        .status-expired { background: #f1f5f9; color: #64748b; }

        /* Barcode btn */
        .btn-barcode {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600; cursor: pointer;
            border: none; transition: all 0.2s;
        }
        .btn-barcode.loan { background: #eff6ff; color: #2563eb; }
        .btn-barcode.loan:hover { background: #dbeafe; }
        .btn-barcode.return-req { background: #f0fdf4; color: #16a34a; }
        .btn-barcode.return-req:hover { background: #dcfce7; }
        .btn-barcode.cancel { background: #fee2e2; color: #dc2626; }
        .btn-barcode.cancel:hover { background: #fecaca; }
        .btn-barcode.show { background: #f5f3ff; color: #7c3aed; }
        .btn-barcode.show:hover { background: #ede9fe; }
    </style>
</head>
<body>
    <x-page-loader />
    @include('components.navbar')

    <!-- Sub-Navbar / Breadcrumb -->
    @include('components.sub-navbar', ['title' => 'Riwayat Peminjaman', 'maxWidth' => 'max-w-6xl'])

    <div class="min-h-screen pt-6 sm:pt-8 pb-12 sm:pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-history library-primary mr-3"></i><span>Riwayat Peminjaman</span>
                </h1>
                <p class="text-xs sm:text-base text-gray-600">Kelola peminjaman buku Anda</p>
            </div>

            <!-- Barcode Info Banner -->
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6 flex items-start gap-3">
                <i class="fas fa-info-circle mt-0.5 text-blue-500"></i>
                <div class="text-sm">
                    <strong>Cara Peminjaman Baru:</strong> Setelah mengajukan pinjam, barcode QR akan muncul. Tunjukkan barcode tersebut kepada petugas untuk mengambil buku.
                    Barcode berlaku selama <strong>{{ \App\Models\Loan::BARCODE_EXPIRY_HOURS }} jam</strong> sejak pengajuan.
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 border-l-4 border-amber-500 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-600 text-sm mb-1">Peminjaman Aktif</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ $loans->filter(fn($l) => in_array($l->getActualStatus(), ['peminjaman', 'terlambat', 'menunggu_konfirmasi', 'menunggu_pengembalian']))->count() }}
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
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($loans as $loan)
                                    @php $status = $loan->getActualStatus(); @endphp
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
                                            @if($status === 'terlambat')
                                                <p class="text-xs text-red-600 font-semibold">{{ $loan->getDaysLate() }} hari terlambat</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($status === 'menunggu_konfirmasi')
                                                <span class="status-pill status-menunggu">
                                                    <i class="fas fa-clock"></i> Menunggu Konfirmasi
                                                </span>
                                                @if($loan->isLoanBarcodeValid())
                                                    <p class="text-xs text-amber-600 mt-1">
                                                        <i class="fas fa-hourglass-half"></i>
                                                        Barcode berlaku <span class="font-semibold loan-countdown-{{ $loan->id }}">{{ gmdate('H:i:s', $loan->getLoanBarcodeRemainingSeconds()) }}</span>
                                                    </p>
                                                @endif
                                            @elseif($status === 'peminjaman')
                                                <span class="status-pill status-peminjaman">
                                                    <i class="fas fa-book-open"></i> Dipinjam
                                                </span>
                                            @elseif($status === 'menunggu_pengembalian')
                                                <span class="status-pill status-menunggu-kembali">
                                                    <i class="fas fa-undo"></i> Menunggu Pengembalian
                                                </span>
                                                @if($loan->isReturnBarcodeValid())
                                                    <p class="text-xs text-purple-600 mt-1">
                                                        <i class="fas fa-hourglass-half"></i>
                                                        Barcode berlaku <span class="font-semibold return-countdown-{{ $loan->id }}">{{ gmdate('H:i:s', $loan->getReturnBarcodeRemainingSeconds()) }}</span>
                                                    </p>
                                                @endif
                                            @elseif($status === 'dikembalikan')
                                                @if($loan->isReturnedLate())
                                                    <span class="status-pill bg-amber-100 text-amber-800 border border-amber-200">
                                                        <i class="fas fa-check-circle text-amber-600"></i> Dikembalikan (Terlambat)
                                                    </span>
                                                    @if($loan->return_date)
                                                        <p class="text-xs text-amber-600 mt-1 font-medium">{{ $loan->return_date->format('d/m/Y') }} (+{{ $loan->getDaysLate() }} hari)</p>
                                                    @endif
                                                @else
                                                    <span class="status-pill status-dikembalikan">
                                                        <i class="fas fa-check-circle"></i> Dikembalikan
                                                    </span>
                                                    @if($loan->return_date)
                                                        <p class="text-xs text-gray-500 mt-1">{{ $loan->return_date->format('d/m/Y') }}</p>
                                                    @endif
                                                @endif
                                            @elseif($status === 'terlambat')
                                                <span class="status-pill status-terlambat">
                                                    <i class="fas fa-exclamation-circle"></i> Terlambat
                                                </span>
                                            @elseif($status === 'expired')
                                                <span class="status-pill status-expired">
                                                    <i class="fas fa-ban"></i> Hangus
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                                {{-- Show barcode loan --}}
                                                @if($status === 'menunggu_konfirmasi' && $loan->isLoanBarcodeValid())
                                                    <button class="btn-barcode show" onclick="showBarcodeModal('loan', {{ $loan->id }}, '{{ $loan->loan_barcode }}', {{ $loan->getLoanBarcodeRemainingSeconds() }}, '{{ $loan->book->title }}')">
                                                        <i class="fas fa-qrcode"></i> Lihat Barcode
                                                    </button>
                                                    <form method="POST" action="{{ route('loans.cancel', $loan) }}" style="display:inline" data-confirm="Batalkan pengajuan peminjaman untuk buku '{{ $loan->book->title }}'? Stok buku akan dikembalikan." data-confirm-title="Batalkan Peminjaman" data-confirm-btn="Ya, Batalkan">
                                                        @csrf
                                                        <button type="submit" class="btn-barcode cancel">
                                                            <i class="fas fa-times"></i> Batal
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Show barcode return --}}
                                                @if($status === 'menunggu_pengembalian' && $loan->isReturnBarcodeValid())
                                                    <button class="btn-barcode show" onclick="showBarcodeModal('return', {{ $loan->id }}, '{{ $loan->return_barcode }}', {{ $loan->getReturnBarcodeRemainingSeconds() }}, '{{ $loan->book->title }}')">
                                                        <i class="fas fa-qrcode"></i> Lihat Barcode Kembali
                                                    </button>
                                                    <form method="POST" action="{{ route('loans.cancel-return', $loan) }}" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn-barcode cancel">
                                                            <i class="fas fa-times"></i> Batal
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Request return --}}
                                                @if(in_array($status, ['peminjaman', 'terlambat']))
                                                    <form method="POST" action="{{ route('loans.request-return', $loan) }}" style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="btn-barcode return-req">
                                                            <i class="fas fa-undo"></i> Kembalikan Buku
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- View book --}}
                                                <a href="{{ route('books.show', $loan->book->id) }}"
                                                   class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-200 transition">
                                                    <i class="fas fa-eye"></i> Lihat Buku
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Cards for mobile -->
                    <div class="md:hidden space-y-4 p-4">
                        @foreach($loans as $loan)
                            @php $status = $loan->getActualStatus(); @endphp
                            <div class="border border-gray-200 rounded-xl p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $loan->book->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $loan->book->author }}</p>
                                    </div>
                                    @if($status === 'menunggu_konfirmasi')
                                        <span class="status-pill status-menunggu ml-2 whitespace-nowrap">Menunggu</span>
                                    @elseif($status === 'peminjaman')
                                        <span class="status-pill status-peminjaman ml-2 whitespace-nowrap">Dipinjam</span>
                                    @elseif($status === 'menunggu_pengembalian')
                                        <span class="status-pill status-menunggu-kembali ml-2 whitespace-nowrap">Mau Kembali</span>
                                    @elseif($status === 'dikembalikan')
                                        @if($loan->isReturnedLate())
                                            <span class="status-pill bg-amber-100 text-amber-800 border border-amber-200 ml-2 whitespace-nowrap">Kembali (Terlambat)</span>
                                        @else
                                            <span class="status-pill status-dikembalikan ml-2 whitespace-nowrap">Kembali</span>
                                        @endif
                                    @elseif($status === 'terlambat')
                                        <span class="status-pill status-terlambat ml-2 whitespace-nowrap">Lambat</span>
                                    @else
                                        <span class="status-pill status-expired ml-2 whitespace-nowrap">Hangus</span>
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
                                    @if($status === 'dikembalikan' && $loan->return_date)
                                        <div>
                                            <p class="text-gray-600 text-xs">Kembali</p>
                                            <p class="font-medium {{ $loan->isReturnedLate() ? 'text-amber-700 font-semibold' : 'text-gray-900' }}">
                                                {{ $loan->return_date->format('d/m/Y') }}
                                                @if($loan->isReturnedLate())
                                                    <span class="text-[11px] text-amber-600 font-normal block">+{{ $loan->getDaysLate() }} hari</span>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    @if($status === 'terlambat')
                                        <div>
                                            <p class="text-gray-600 text-xs">Terlambat</p>
                                            <p class="font-medium text-red-600">{{ $loan->getDaysLate() }} hari</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons Mobile -->
                                <div class="flex flex-wrap gap-2">
                                    @if($status === 'menunggu_konfirmasi' && $loan->isLoanBarcodeValid())
                                        <button class="btn-barcode show flex-1" onclick="showBarcodeModal('loan', {{ $loan->id }}, '{{ $loan->loan_barcode }}', {{ $loan->getLoanBarcodeRemainingSeconds() }}, '{{ $loan->book->title }}')">
                                            <i class="fas fa-qrcode"></i> Lihat Barcode
                                        </button>
                                    @endif
                                    @if($status === 'menunggu_pengembalian' && $loan->isReturnBarcodeValid())
                                        <button class="btn-barcode show flex-1" onclick="showBarcodeModal('return', {{ $loan->id }}, '{{ $loan->return_barcode }}', {{ $loan->getReturnBarcodeRemainingSeconds() }}, '{{ $loan->book->title }}')">
                                            <i class="fas fa-qrcode"></i> Lihat Barcode Kembali
                                        </button>
                                    @endif
                                    @if(in_array($status, ['peminjaman', 'terlambat']))
                                        <form method="POST" action="{{ route('loans.request-return', $loan) }}" style="display:contents">
                                            @csrf
                                            <button type="submit" class="btn-barcode return-req flex-1">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                    @if($status === 'menunggu_konfirmasi')
                                        <form method="POST" action="{{ route('loans.cancel', $loan) }}" style="display:contents" data-confirm="Batalkan pengajuan peminjaman untuk buku '{{ $loan->book->title }}'? Stok buku akan dikembalikan." data-confirm-title="Batalkan Peminjaman" data-confirm-btn="Ya, Batalkan">
                                            @csrf
                                            <button type="submit" class="btn-barcode cancel">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                        </form>
                                    @endif
                                    @if($status === 'menunggu_pengembalian')
                                        <form method="POST" action="{{ route('loans.cancel-return', $loan) }}" style="display:contents">
                                            @csrf
                                            <button type="submit" class="btn-barcode cancel">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('books.show', $loan->book->id) }}"
                                       class="btn-barcode loan">
                                        <i class="fas fa-eye"></i> Lihat Buku
                                    </a>
                                </div>
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

    <!-- ══ BARCODE MODAL ══ -->
    <div id="barcode-modal-overlay" class="barcode-modal-overlay" style="display:none" onclick="closeBarcodeModal(event)">
        <div class="barcode-modal" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="barcode-modal-header">
                <div class="barcode-modal-icon" id="modal-icon">🔖</div>
                <h2 class="text-xl font-bold text-gray-900 mb-1" id="modal-title">Barcode Peminjaman</h2>
                <p class="text-sm text-gray-500" id="modal-subtitle">Tunjukkan kepada petugas perpustakaan</p>
            </div>

            <!-- QR Code Display -->
            <div class="barcode-qr-wrap">
                <div id="modal-qr-container">
                    <!-- QR code will be rendered here -->
                </div>
                <div class="token-display" id="modal-token-display"></div>
            </div>

            <!-- Countdown -->
            <div class="countdown-wrap" id="modal-countdown-wrap">
                <i class="fas fa-clock" style="color:#92400e"></i>
                <div>
                    <div style="font-size:0.7rem; color:#92400e; font-weight:600">MASA BERLAKU</div>
                    <div class="countdown-time" id="modal-countdown">00:00:00</div>
                </div>
            </div>

            <!-- Book name -->
            <div class="bg-gray-50 rounded-xl p-3 mb-4">
                <p class="text-xs text-gray-500 mb-1"><i class="fas fa-book"></i> Buku:</p>
                <p class="font-semibold text-gray-800 text-sm" id="modal-book-name"></p>
            </div>

            <!-- Warning -->
            <p class="text-xs text-gray-400 mb-4">
                <i class="fas fa-exclamation-triangle text-amber-400"></i>
                Barcode ini hanya bisa di-scan <strong>satu kali</strong> dan akan hangus setelah masa berlaku habis.
            </p>

            <!-- Close -->
            <button onclick="closeBarcodeModal()" class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
                Tutup
            </button>
        </div>
    </div>

    <script>
    // ── BARCODE MODAL ──
    let countdownInterval = null;
    let currentSeconds   = 0;

    function showBarcodeModal(type, loanId, token, remainingSeconds, bookTitle) {
        const isLoan  = type === 'loan';
        const overlay = document.getElementById('barcode-modal-overlay');
        const icon    = document.getElementById('modal-icon');
        const title   = document.getElementById('modal-title');
        const subtitle = document.getElementById('modal-subtitle');
        const tokenEl  = document.getElementById('modal-token-display');
        const bookEl   = document.getElementById('modal-book-name');

        icon.className = 'barcode-modal-icon ' + (isLoan ? 'loan' : 'return');
        icon.textContent = isLoan ? '📦' : '🔄';
        title.textContent = isLoan ? 'Barcode Peminjaman' : 'Barcode Pengembalian';
        subtitle.textContent = isLoan
            ? 'Tunjukkan kepada petugas untuk mengambil buku'
            : 'Tunjukkan kepada petugas untuk mengembalikan buku';
        tokenEl.textContent = token;
        bookEl.textContent  = bookTitle;

        // Generate QR Code using Google Charts API
        const qrContainer = document.getElementById('modal-qr-container');
        const qrSize = 200;
        const qrUrl  = `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(token)}&format=png&margin=2`;
        qrContainer.innerHTML = `<img src="${qrUrl}" alt="QR Code" style="border-radius:8px; width:${qrSize}px; height:${qrSize}px">`;

        // Start countdown
        currentSeconds = remainingSeconds;
        updateCountdown();
        clearInterval(countdownInterval);
        countdownInterval = setInterval(() => {
            currentSeconds--;
            if (currentSeconds <= 0) {
                currentSeconds = 0;
                clearInterval(countdownInterval);
                // Mark as expired
                document.getElementById('modal-countdown-wrap').classList.add('expired');
                document.getElementById('modal-countdown').textContent = 'HANGUS';
            }
            updateCountdown();
        }, 1000);

        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function updateCountdown() {
        if (currentSeconds <= 0) return;
        const h = Math.floor(currentSeconds / 3600);
        const m = Math.floor((currentSeconds % 3600) / 60);
        const s = currentSeconds % 60;
        const timeStr = [h, m, s].map(v => String(v).padStart(2, '0')).join(':');
        document.getElementById('modal-countdown').textContent = timeStr;

        const wrap = document.getElementById('modal-countdown-wrap');
        if (currentSeconds < 300) { // < 5 min: red warning
            wrap.style.background = 'linear-gradient(135deg, #fee2e2, #fecaca)';
            document.getElementById('modal-countdown').style.color = '#991b1b';
        }
    }

    function closeBarcodeModal(event) {
        if (event && event.target !== document.getElementById('barcode-modal-overlay')) return;
        clearInterval(countdownInterval);
        document.getElementById('barcode-modal-overlay').style.display = 'none';
        document.body.style.overflow = '';
        document.getElementById('modal-countdown-wrap').classList.remove('expired');
        document.getElementById('modal-countdown-wrap').style.background = '';
        document.getElementById('modal-countdown').style.color = '';
    }

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeBarcodeModal();
    });

    // ── COUNTDOWN IN TABLE (live ticking) ──
    function tickTableCountdowns() {
        @foreach($loans as $loan)
            @if($loan->getActualStatus() === 'menunggu_konfirmasi' && $loan->isLoanBarcodeValid())
                @php $secs = $loan->getLoanBarcodeRemainingSeconds(); @endphp
                (function() {
                    let s = {{ $secs }};
                    const el = document.querySelector('.loan-countdown-{{ $loan->id }}');
                    if (!el) return;
                    setInterval(() => {
                        s = Math.max(0, s - 1);
                        const h = Math.floor(s/3600), m = Math.floor((s%3600)/60), sec = s%60;
                        el.textContent = [h,m,sec].map(v => String(v).padStart(2,'0')).join(':');
                    }, 1000);
                })();
            @endif
            @if($loan->getActualStatus() === 'menunggu_pengembalian' && $loan->isReturnBarcodeValid())
                @php $secs = $loan->getReturnBarcodeRemainingSeconds(); @endphp
                (function() {
                    let s = {{ $secs }};
                    const el = document.querySelector('.return-countdown-{{ $loan->id }}');
                    if (!el) return;
                    setInterval(() => {
                        s = Math.max(0, s - 1);
                        const h = Math.floor(s/3600), m = Math.floor((s%3600)/60), sec = s%60;
                        el.textContent = [h,m,sec].map(v => String(v).padStart(2,'0')).join(':');
                    }, 1000);
                })();
            @endif
        @endforeach
    }

    document.addEventListener('DOMContentLoaded', tickTableCountdowns);
    </script>
</body>
</html>
