@props([
    'variant' => 'neutral',
    'size' => 'md',
    'dot' => false,
])

@php
    $baseStyles = 'inline-flex items-center gap-1.5 font-bold tracking-tight rounded-full border select-none transition-colors duration-150';

    $variants = [
        'neutral' => 'bg-slate-100/80 text-slate-700 border-slate-200/50',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200/50',
        'info' => 'bg-indigo-50 text-indigo-700 border-indigo-200/50',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200/50',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200/50',
    ];

    $dots = [
        'neutral' => 'bg-slate-400',
        'success' => 'bg-emerald-500',
        'info' => 'bg-indigo-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
    ];

    $sizes = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-0.5 text-xs',
    ];

    $classes = "{$baseStyles} {$variants[$variant]} {$sizes[$size]}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dots[$variant] }}"></span>
    @endif
    {{ $slot }}
</span>
