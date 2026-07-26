@props([
    'type' => 'text', // text, circle, card, table
    'rows' => 1,
])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    @if($type === 'text')
        @for($i = 0; $i < $rows; $i++)
            <div class="h-3.5 shimmer-skeleton rounded-lg w-full last:w-5/6"></div>
        @endfor
    @elseif($type === 'circle')
        <div class="h-12 w-12 rounded-full shimmer-skeleton"></div>
    @elseif($type === 'card')
        <div class="border border-slate-200/80 p-6 rounded-2xl space-y-4 bg-white shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl shimmer-skeleton"></div>
                <div class="space-y-1.5 flex-1">
                    <div class="h-3 shimmer-skeleton rounded w-1/3"></div>
                    <div class="h-2.5 shimmer-skeleton rounded w-1/4"></div>
                </div>
            </div>
            <div class="space-y-2">
                <div class="h-3.5 shimmer-skeleton rounded w-full"></div>
                <div class="h-3.5 shimmer-skeleton rounded w-5/6"></div>
            </div>
        </div>
    @elseif($type === 'table')
        <div class="border border-slate-200/80 rounded-2xl overflow-hidden bg-white shadow-2xs">
            <div class="h-12 bg-slate-50 border-b border-slate-100"></div>
            <div class="divide-y divide-slate-100">
                @for($i = 0; $i < $rows; $i++)
                    <div class="p-6 flex items-center justify-between gap-4">
                        <div class="h-3.5 shimmer-skeleton rounded w-1/4"></div>
                        <div class="h-3.5 shimmer-skeleton rounded w-1/3"></div>
                        <div class="h-3.5 shimmer-skeleton rounded w-12"></div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
</div>
