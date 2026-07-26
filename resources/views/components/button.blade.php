@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'loading' => null,
])

@php
    $baseStyles = 'inline-flex items-center justify-center font-semibold rounded-xl transition duration-150 ease-in-out active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:active:scale-100 cursor-pointer select-none';
    
    $variants = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm shadow-indigo-500/20 focus-visible:ring-indigo-500 border border-indigo-600',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-800 focus-visible:ring-slate-400 border border-slate-200/60',
        'outline' => 'bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 hover:text-slate-900 shadow-2xs focus-visible:ring-indigo-500',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm shadow-rose-500/20 focus-visible:ring-rose-500 border border-rose-600',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm shadow-emerald-500/20 focus-visible:ring-emerald-500 border border-emerald-600',
        'ghost' => 'bg-transparent hover:bg-slate-100 text-slate-600 hover:text-slate-900 focus-visible:ring-slate-400 border border-transparent',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-5 py-2.5 text-base gap-2.5',
    ];

    $classes = "{$baseStyles} {$variants[$variant]} {$sizes[$size]}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($loading) wire:loading.attr="disabled" @endif>
    @if($loading)
        <svg wire:loading wire:target="{{ $loading }}" class="animate-spin -ml-0.5 mr-1.5 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>
