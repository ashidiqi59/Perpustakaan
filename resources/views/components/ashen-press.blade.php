@props([
    'height' => '780px',
    'class' => ''
])

<div class="ashen-press-container relative w-full overflow-hidden bg-[#F9FAFB] {{ $class }}"
     style="min-height: 520px; height: {{ $height }};">
    <iframe
        id="ashen-press-iframe"
        title="Rak Buku 3D Perpustakaan"
        src="{{ asset('ashen-press.html') }}"
        sandbox="allow-scripts allow-same-origin"
        loading="eager"
        class="w-full h-full border-0 block relative z-0 opacity-100"
        style="background: #F9FAFB;"
    ></iframe>
</div>
