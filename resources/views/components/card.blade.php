@props([
    'title'         => null,
    'description'   => null,
    'headerActions' => null,
    'footer'        => null,
    'hover'         => false,
    'glass'         => false,
    'gradient'      => false,
    'flat'          => false,
    'padding'       => 'default',
])

@php
    $base = 'border rounded-2xl overflow-hidden transition-all duration-200';

    if ($glass) {
        $base .= ' glass-card shadow-sm';
    } elseif ($flat) {
        $base .= ' bg-white border-slate-200/70 shadow-none';
    } else {
        $base .= ' bg-white border-slate-200/75 shadow-xs';
    }

    if ($gradient) {
        $base .= ' card-gradient-border';
    }

    if ($hover) {
        $base .= ' card-hover cursor-pointer';
    }

    $bodyPad = match($padding) {
        'sm'    => 'p-4',
        'lg'    => 'p-8',
        'none'  => 'p-0',
        default => 'p-6',
    };
@endphp

<div {{ $attributes->merge(['class' => $base]) }}>

    @if($title || $headerActions)
        <div class="px-6 py-4 border-b border-slate-100/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                @if($title)
                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $description }}</p>
                @endif
            </div>
            @if($headerActions)
                <div class="flex items-center gap-2 flex-shrink-0">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $bodyPad }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-3.5 bg-slate-50/60 border-t border-slate-100/80 flex items-center justify-end gap-3">
            {{ $footer }}
        </div>
    @endif
</div>
