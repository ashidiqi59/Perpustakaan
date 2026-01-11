<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Koleksi</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .book-spine { transition: transform .2s, opacity .2s; }
            .book-spine.active { transform: scale(1.15) translateY(-8px); opacity: 1; }
            .book-spine.inactive { opacity: .5; }
        </style>
    </head>
    <body class="min-h-screen bg-neutral-900 text-neutral-100 font-sans">
        <!-- TOP BAR -->
        <header class="max-w-6xl mx-auto px-4 py-6 flex justify-between text-xs items-center">
            <button class="border border-neutral-600 px-3 py-1">
                BACK
            </button>
            <div class="text-center text-[11px] tracking-[0.2em] leading-tight">
                <div class="text-amber-500">KOLEKSI BUKU</div>
                <div class="font-semibold">PERPUSTAKAAN</div>
            </div>
            <div class="flex gap-2 items-center">
                @auth
                    <span class="text-neutral-400">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="border border-neutral-600 px-3 py-1 hover:bg-neutral-700 transition-colors">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="border border-neutral-600 px-3 py-1 hover:bg-neutral-700 transition-colors">
                        LOGIN
                    </a>
                @endauth
            </div>
        </header>

        <!-- FILTER (STATIS DULU) -->
        <section class="max-w-6xl mx-auto px-4 mb-6 flex flex-wrap gap-2 text-[11px]">
            <button class="px-3 py-1 bg-neutral-100 text-neutral-900">ALL</button>
            <button class="px-3 py-1 border border-neutral-600">1940s</button>
            <button class="px-3 py-1 border border-neutral-600">1950s</button>
            <button class="px-3 py-1 border border-neutral-600">1960s</button>
            <button class="px-3 py-1 border border-neutral-600">1970s</button>
            <button class="px-3 py-1 border border-neutral-600">1980s</button>
            <button class="px-3 py-1 border border-neutral-600">1990s</button>
        </section>

        <!-- ROW BUKU (STATIS, PAKE 1 GAMBAR YANG SAMA DULU) -->
        <section class="max-w-6xl mx-auto px-4">
            <div class="flex items-end gap-3 overflow-x-auto py-6">
                <!-- kiri -->
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 1" class="h-48">
                </div>
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 2" class="h-52">
                </div>
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 3" class="h-56">
                </div>

                <!-- tengah (dibuat lebih besar) -->
                <div class="book-spine active bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku utama" class="h-64 shadow-xl">
                </div>

                <!-- kanan -->
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 4" class="h-56">
                </div>
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 5" class="h-52">
                </div>
                <div class="book-spine inactive bg-neutral-800">
                    <img src="{{ asset('images/books/spine&cover.jpg') }}" alt="Buku 6" class="h-48">
                </div>
            </div>
        </section>

        <!-- DETAIL BUKU UTAMA (STATIS DULU) -->
        <section class="max-w-6xl mx-auto px-4 text-center mt-4">
            <h1 class="text-lg md:text-xl font-semibold">
                Throne of Blood
            </h1>
            <p class="text-xs md:text-sm text-neutral-400 mt-1">
                KUROSAWA • 1957
            </p>
        </section>

        <!-- FOOTER SEDERHANA -->
        <footer class="max-w-6xl mx-auto px-4 py-6 mt-10 flex justify-between text-[11px] text-neutral-500">
            <span>&copy; {{ date('Y') }} Perpustakaan. All rights reserved.</span>
            <span>FB / TW</span>
        </footer>
    </body>
</html>