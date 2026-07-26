@props([
    'title' => null,
    'description' => null,
    'headerActions' => null,
    'footer' => null,
    'hover' => false,
])

@php
    $cardClasses = 'bg-white border border-slate-200/80 rounded-2xl shadow-xs overflow-hidden transition duration-200';
    if ($hover) {
        $cardClasses .= ' hover:shadow-md hover:-translate-y-0.5 hover:border-slate-300';
    }
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    @if($title || $headerActions)
        <div class="px-6 py-5 border-b border-slate-100/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                @if($title)
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $description }}</p>
                @endif
            </div>
            @if($headerActions)
                <div class="flex items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-3.5 bg-slate-50/60 border-t border-slate-100 flex items-center justify-end gap-3">
            {{ $footer }}
        </div>
    @endif
</div>
