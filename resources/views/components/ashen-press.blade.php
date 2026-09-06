@props([
    'height' => '780px',
    'class' => ''
])

<div class="shader-frame ashen-press-container relative w-full rounded-2xl overflow-hidden shadow-xl border border-stone-300/80 bg-[#c6ae8e] {{ $class }}"
     style="min-height: 520px; height: {{ $height }};">
    <iframe
        id="ashen-press-iframe"
        title="Rak Buku 3D Perpustakaan"
        src="{{ asset('ashen-press.html') }}"
        sandbox="allow-scripts allow-same-origin"
        loading="eager"
        class="w-full h-full border-0 block relative z-0 opacity-100"
        style="background: #c6ae8e;"
    ></iframe>
</div>
