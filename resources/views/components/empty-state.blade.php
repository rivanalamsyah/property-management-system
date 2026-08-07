@props([
    'title'       => 'Belum Ada Data Terkait',
    'description' => 'Mulai tambahkan data atau sesuaikan filter pencarian Anda.',
    'icon'        => 'folder',
    'size'        => 'md',
])

@php
$icons = [
    'folder' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>',
    'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
    'room'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    'user'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
    'payment'=> '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
    'inbox'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>',
    'chart'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>',
];

$svgPath = $icons[$icon] ?? $icons['folder'];

$sizeMap = [
    'sm' => ['wrap' => 'w-12 h-12 rounded-xl', 'icon' => 'w-6 h-6', 'padding' => 'p-6 sm:p-8'],
    'md' => ['wrap' => 'w-16 h-16 rounded-2xl', 'icon' => 'w-7 h-7', 'padding' => 'p-8 sm:p-12'],
    'lg' => ['wrap' => 'w-20 h-20 rounded-3xl', 'icon' => 'w-9 h-9', 'padding' => 'p-10 sm:p-16'],
];
$s = $sizeMap[$size] ?? $sizeMap['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center ' . $s['padding'] . ' border border-dashed border-slate-200/80 rounded-2xl bg-gradient-to-b from-slate-50/60 to-white']) }}>

    <!-- Animated Icon Container -->
    <div class="{{ $s['wrap'] }} bg-gradient-to-br from-slate-100 to-slate-50 border border-slate-200/60 flex items-center justify-center text-slate-400 mb-4 shadow-2xs"
         style="animation: float 4s ease-in-out infinite;">
        <svg class="{{ $s['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $svgPath !!}
        </svg>
    </div>

    <h3 class="text-sm font-bold text-slate-800 mb-1.5">{{ $title }}</h3>
    <p class="text-xs text-slate-500 max-w-xs leading-relaxed">{{ $description }}</p>

    @if($slot->isNotEmpty())
        <div class="mt-5">
            {{ $slot }}
        </div>
    @endif
</div>
