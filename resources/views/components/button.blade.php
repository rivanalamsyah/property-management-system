@props([
    'variant' => 'primary',
    'size'    => 'md',
    'type'    => 'button',
    'loading' => null,
    'icon'    => null,
    'iconEnd' => null,
    'href'    => null,
    'ripple'  => true,
])

@php
    $base = 'relative inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-150 ease-out active:scale-[0.97] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:active:scale-100 disabled:hover:translate-y-0 cursor-pointer select-none overflow-hidden hover:-translate-y-0.5 hover:shadow-md';

    $variants = [
        'primary'   => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-500/20 focus-visible:ring-indigo-500 border border-indigo-600/90 hover:shadow-indigo-500/30',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-800 focus-visible:ring-slate-400 border border-slate-200/60 hover:shadow-slate-200/50',
        'outline'   => 'bg-white border border-slate-200/90 hover:bg-slate-50 text-slate-700 hover:text-slate-900 shadow-2xs focus-visible:ring-indigo-500 hover:border-slate-300',
        'danger'    => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm shadow-rose-500/20 focus-visible:ring-rose-500 border border-rose-600/90 hover:shadow-rose-500/30',
        'success'   => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-500/20 focus-visible:ring-emerald-500 border border-emerald-600/90',
        'ghost'     => 'bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-900 focus-visible:ring-slate-400 border border-transparent hover:shadow-none hover:translate-y-0',
        'glass'     => 'btn-glass text-slate-700 hover:text-indigo-700 focus-visible:ring-indigo-400',
        'gradient'  => 'btn-gradient-primary text-white focus-visible:ring-indigo-400 border-0',
        'warning'   => 'bg-amber-500 hover:bg-amber-600 text-white shadow-sm shadow-amber-500/20 focus-visible:ring-amber-500 border border-amber-500/90',
    ];

    $sizes = [
        'xs' => 'px-2.5 py-1 text-[11px] gap-1 rounded-lg',
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-5 py-2.5 text-base gap-2.5',
        'xl' => 'px-6 py-3 text-lg gap-3 rounded-2xl',
    ];

    $classes = "{$base} {$variants[$variant]} {$sizes[$size]}";
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if(!$href) type="{{ $type }}" @endif
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
    @if($loading) wire:loading.attr="disabled" @endif
    @if($ripple) data-ripple @endif>

    {{-- Loading spinner --}}
    @if($loading)
        <svg wire:loading wire:target="{{ $loading }}"
             class="animate-spin flex-shrink-0 {{ str_contains($sizes[$size] ?? '', 'xs') ? 'h-3 w-3' : 'h-4 w-4' }} text-current"
             fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
        </svg>
    @endif

    {{-- Leading icon --}}
    @if($icon)
        <svg class="flex-shrink-0 {{ $size === 'xs' || $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4.5 h-4.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    @endif

    {{ $slot }}

    {{-- Trailing icon --}}
    @if($iconEnd)
        <svg class="flex-shrink-0 {{ $size === 'xs' || $size === 'sm' ? 'w-3.5 h-3.5' : 'w-4.5 h-4.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $iconEnd !!}
        </svg>
    @endif
</{{ $tag }}>
