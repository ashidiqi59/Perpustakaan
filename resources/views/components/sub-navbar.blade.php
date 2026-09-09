@props([
    'title' => '',
    'links' => [],
    'maxWidth' => 'max-w-7xl',
])

@php
    // Dukung pemanggilan via @include('components.sub-navbar', ['title' => '...'])
    $title = $title ?? ($pageTitle ?? '');
    $links = $links ?? [];
    $maxWidth = $maxWidth ?? 'max-w-7xl';
@endphp

<!-- Sub-Navbar / Breadcrumb Bar -->
<div class="bg-white shadow-sm border-b border-gray-100">
    <div class="{{ $maxWidth }} mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center text-sm text-gray-500 overflow-x-auto whitespace-nowrap scrollbar-none" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-library-primary transition-colors flex items-center shrink-0">
                Beranda
            </a>

            @if(!empty($links))
                @foreach($links as $link)
                    <svg class="w-5 h-5 mx-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    @if(!empty($link['url']))
                        <a href="{{ $link['url'] }}" class="hover:text-library-primary transition-colors shrink-0">
                            {{ $link['label'] ?? ($link['title'] ?? '') }}
                        </a>
                    @else
                        <span class="text-gray-800 font-medium shrink-0">{{ $link['label'] ?? ($link['title'] ?? '') }}</span>
                    @endif
                @endforeach
            @endif

            @if(!empty($title))
                <svg class="w-5 h-5 mx-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-800 font-medium shrink-0">{{ $title }}</span>
            @endif

            {{ $slot ?? '' }}
        </nav>
    </div>
</div>
