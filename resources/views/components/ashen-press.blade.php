@props([
    'height' => '720px',
    'class' => ''
])

<div class="shader-frame ashen-press-container relative w-full rounded-2xl overflow-hidden shadow-2xl border border-stone-800/20 bg-[#c6ae8e] {{ $class }}"
     style="min-height: 520px; height: {{ $height }};">
    <div id="ashen-press-loader" class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-[#c6ae8e] transition-opacity duration-500">
        <div class="w-12 h-12 border-4 border-[#241a12]/20 border-t-[#241a12] rounded-full animate-spin mb-3"></div>
        <p class="text-xs tracking-widest uppercase font-semibold text-[#241a12]/80">Memuat Rak Buku 3D...</p>
    </div>
    <iframe
        id="ashen-press-iframe"
        title="Ashen Press — The Art Book Shelf"
        src="{{ asset('ashen-press.html') }}"
        sandbox="allow-scripts allow-same-origin"
        loading="eager"
        class="w-full h-full border-0 block relative z-0 opacity-0 transition-opacity duration-700"
        style="background: #c6ae8e;"
        onload="document.getElementById('ashen-press-iframe').classList.remove('opacity-0'); document.getElementById('ashen-press-loader').classList.add('opacity-0', 'pointer-events-none');"
    ></iframe>
</div>
