@props([
    'type' => 'info',
    'dismissible' => true,
])

@php
    $baseStyles = 'p-4 rounded-xl text-sm border flex items-start gap-3 relative transition';

    $types = [
        'success' => 'bg-emerald-50/20 text-emerald-800 border-emerald-100',
        'info' => 'bg-indigo-50/20 text-indigo-800 border-indigo-100',
        'warning' => 'bg-amber-50/20 text-amber-800 border-amber-100',
        'danger' => 'bg-rose-50/20 text-rose-800 border-rose-100',
    ];

    $icons = [
        'success' => '<svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'info' => '<svg class="h-5 w-5 text-indigo-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'warning' => '<svg class="h-5 w-5 text-amber-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
        'danger' => '<svg class="h-5 w-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
    ];

    $classes = "{$baseStyles} {$types[$type]}";
@endphp

<div x-data="{ show: true }" x-show="show" {{ $attributes->merge(['class' => $classes]) }}>
    <!-- Icon -->
    {!! $icons[$type] !!}

    <!-- Content -->
    <div class="flex-1">
        {{ $slot }}
    </div>

    <!-- Dismiss Button -->
    @if($dismissible)
        <button type="button" @click="show = false" class="text-current opacity-60 hover:opacity-100 rounded-lg p-0.5 hover:bg-black/5 transition cursor-pointer">
            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
