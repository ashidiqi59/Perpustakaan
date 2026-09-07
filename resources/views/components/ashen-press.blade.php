@props([
    'height' => null,
    'class' => ''
])

<div class="ashen-press-container relative w-full overflow-hidden bg-[#F4EFEA] h-[540px] sm:h-[640px] lg:h-[780px] {{ $class }}"
     style="min-height: 520px; @if($height) height: {{ $height }}; @endif">
    <!-- Clean, elegant loading indicator -->
    <div id="ashen-press-loader" class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-[#F4EFEA] transition-opacity duration-500 pointer-events-none">
        <div class="relative flex items-center justify-center">
            <!-- Spinner Ring -->
            <div class="w-14 h-14 rounded-full border-2 border-blue-600/20 border-t-blue-600 animate-spin"></div>
            <!-- Book Icon -->
            <div class="absolute inset-0 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
        <p class="mt-4 text-xs tracking-wider uppercase font-semibold text-stone-600">Memuat Rak Buku 3D...</p>
    </div>

    <!-- 3D Bookshelf Iframe -->
    <iframe
        id="ashen-press-iframe"
        title="Rak Buku 3D Perpustakaan"
        src="{{ asset('ashen-press.html') }}"
        sandbox="allow-scripts allow-same-origin"
        loading="eager"
        class="w-full h-full border-0 block relative z-0 opacity-100"
        style="background: #F4EFEA;"
    ></iframe>
</div>

<script>
    (function() {
        const loader = document.getElementById('ashen-press-loader');
        const iframe = document.getElementById('ashen-press-iframe');
        
        function hideLoader() {
            if (!loader) return;
            loader.classList.add('opacity-0');
            setTimeout(() => {
                if (loader && loader.parentNode) {
                    loader.style.display = 'none';
                }
            }, 500);
        }

        window.addEventListener('message', function(e) {
            if (e.data === 'ashen-ready') {
                hideLoader();
            }
        });

        if (iframe) {
            iframe.addEventListener('load', function() {
                setTimeout(hideLoader, 600);
            });
        }

        setTimeout(hideLoader, 2000);
    })();
</script>
