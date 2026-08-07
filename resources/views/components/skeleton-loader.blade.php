@props([
    'type' => 'text', // text | circle | card | table | stat | profile | grid
    'rows' => 1,
    'cols' => 1,
])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    @if($type === 'text')
        @for($i = 0; $i < $rows; $i++)
            <div class="h-3.5 shimmer-skeleton rounded-lg {{ $i === $rows - 1 && $rows > 1 ? 'w-4/6' : 'w-full' }}"></div>
        @endfor

    @elseif($type === 'circle')
        <div class="h-12 w-12 rounded-full shimmer-skeleton"></div>

    @elseif($type === 'stat')
        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <div class="h-2.5 shimmer-skeleton rounded w-20"></div>
                <div class="w-10 h-10 shimmer-skeleton rounded-2xl"></div>
            </div>
            <div class="h-7 shimmer-skeleton rounded w-16 mb-2"></div>
            <div class="h-2.5 shimmer-skeleton rounded w-28"></div>
        </div>

    @elseif($type === 'card')
        <div class="border border-slate-200/80 p-6 rounded-2xl space-y-4 bg-white shadow-xs">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl shimmer-skeleton flex-shrink-0"></div>
                <div class="space-y-1.5 flex-1">
                    <div class="h-3 shimmer-skeleton rounded w-1/3"></div>
                    <div class="h-2.5 shimmer-skeleton rounded w-1/4"></div>
                </div>
            </div>
            <div class="space-y-2">
                <div class="h-3.5 shimmer-skeleton rounded w-full"></div>
                <div class="h-3.5 shimmer-skeleton rounded w-5/6"></div>
                <div class="h-3.5 shimmer-skeleton rounded w-4/6"></div>
            </div>
        </div>

    @elseif($type === 'profile')
        <div class="border border-slate-200/80 p-6 rounded-2xl bg-white shadow-xs">
            <div class="flex items-start gap-4">
                <div class="h-16 w-16 rounded-2xl shimmer-skeleton flex-shrink-0"></div>
                <div class="flex-1 space-y-2 pt-1">
                    <div class="h-4 shimmer-skeleton rounded w-1/3"></div>
                    <div class="h-3 shimmer-skeleton rounded w-1/2"></div>
                    <div class="h-5 shimmer-skeleton rounded-full w-20 mt-3"></div>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-3 gap-3">
                @for($i = 0; $i < 3; $i++)
                    <div class="text-center space-y-1">
                        <div class="h-5 shimmer-skeleton rounded w-12 mx-auto"></div>
                        <div class="h-2.5 shimmer-skeleton rounded w-14 mx-auto"></div>
                    </div>
                @endfor
            </div>
        </div>

    @elseif($type === 'table')
        <div class="border border-slate-200/80 rounded-2xl overflow-hidden bg-white shadow-xs">
            <div class="h-11 bg-slate-50 border-b border-slate-100 px-5 flex items-center gap-4">
                @for($c = 0; $c < 4; $c++)
                    <div class="h-2.5 shimmer-skeleton rounded w-16"></div>
                @endfor
            </div>
            <div class="divide-y divide-slate-100/60">
                @for($i = 0; $i < $rows; $i++)
                    <div class="px-5 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 shimmer-skeleton rounded-xl flex-shrink-0"></div>
                            <div class="space-y-1.5">
                                <div class="h-3 shimmer-skeleton rounded w-28"></div>
                                <div class="h-2.5 shimmer-skeleton rounded w-20"></div>
                            </div>
                        </div>
                        <div class="h-3 shimmer-skeleton rounded w-20 hidden sm:block"></div>
                        <div class="h-5 shimmer-skeleton rounded-full w-14 hidden md:block"></div>
                        <div class="h-7 shimmer-skeleton rounded-xl w-14"></div>
                    </div>
                @endfor
            </div>
        </div>

    @elseif($type === 'grid')
        <div class="grid grid-cols-{{ $cols }} gap-4">
            @for($i = 0; $i < $rows * $cols; $i++)
                <div class="border border-slate-200/80 rounded-2xl p-5 bg-white shadow-xs space-y-3">
                    <div class="h-32 shimmer-skeleton rounded-xl"></div>
                    <div class="h-3.5 shimmer-skeleton rounded w-3/4"></div>
                    <div class="h-3 shimmer-skeleton rounded w-1/2"></div>
                </div>
            @endfor
        </div>

    @elseif($type === 'list')
        @for($i = 0; $i < $rows; $i++)
            <div class="flex items-center gap-3 py-2.5">
                <div class="h-9 w-9 shimmer-skeleton rounded-xl flex-shrink-0"></div>
                <div class="flex-1 space-y-1.5">
                    <div class="h-3 shimmer-skeleton rounded w-1/3"></div>
                    <div class="h-2.5 shimmer-skeleton rounded w-1/2"></div>
                </div>
                <div class="h-5 shimmer-skeleton rounded-full w-12 flex-shrink-0"></div>
            </div>
        @endfor
    @endif
</div>
