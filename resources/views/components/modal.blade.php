@props([
    'name'     => null,
    'title'    => null,
    'show'     => false,
    'maxWidth' => '2xl',
    'type'     => 'center', // center | drawer | sheet
])

@php
$maxWidthClass = [
    'sm'  => 'sm:max-w-sm',
    'md'  => 'sm:max-w-md',
    'lg'  => 'sm:max-w-lg',
    'xl'  => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    'full'=> 'sm:max-w-full sm:mx-4',
][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div x-data="{
        show: @entangle($attributes->wire('model')),
        close() { this.show = false }
     }"
     x-show="show"
     x-on:keydown.escape.window="close"
     style="display:none;"
     class="fixed inset-0 z-50 {{ $type === 'sheet' ? 'flex flex-col justify-end' : 'overflow-y-auto' }}"
     aria-labelledby="modal-title-{{ $name }}"
     role="dialog"
     aria-modal="true">

    <!-- Backdrop -->
    <div x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
         @click="close">
    </div>

    @if($type === 'drawer')
        <!-- Slide-in Drawer (Right) -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed inset-y-0 right-0 flex flex-col glass-modal border-l border-slate-200/60 shadow-2xl w-full {{ $maxWidthClass }} z-50 overflow-y-auto">
            @if($title)
                <div class="px-6 py-5 border-b border-slate-100/80 flex items-center justify-between flex-shrink-0">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-title-{{ $name }}">{{ $title }}</h3>
                    <button type="button" @click="close"
                            class="text-slate-400 hover:text-slate-600 rounded-xl p-1.5 hover:bg-slate-100 transition cursor-pointer"
                            aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="flex-1 px-6 py-6 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>

    @elseif($type === 'sheet')
        <!-- Bottom Sheet (mobile-first) -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-full"
             class="relative glass-modal rounded-t-3xl border-t border-slate-200/60 shadow-2xl w-full max-h-[90vh] flex flex-col z-50 safe-area-bottom">
            <!-- Drag handle -->
            <div class="flex justify-center pt-3 pb-1 flex-shrink-0">
                <div class="w-10 h-1 bg-slate-300 rounded-full"></div>
            </div>
            @if($title)
                <div class="px-6 py-4 border-b border-slate-100/80 flex items-center justify-between flex-shrink-0">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-title-{{ $name }}">{{ $title }}</h3>
                    <button type="button" @click="close"
                            class="text-slate-400 hover:text-slate-600 rounded-xl p-1.5 hover:bg-slate-100 transition cursor-pointer"
                            aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="flex-1 px-6 py-6 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>

    @else
        <!-- Center Modal (default) -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-250"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-180"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="relative transform overflow-hidden rounded-3xl glass-modal border border-slate-200/60 text-left shadow-2xl transition-all w-full {{ $maxWidthClass }} my-8">

                @if($title)
                    <div class="px-6 py-5 border-b border-slate-100/80 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-title-{{ $name }}">{{ $title }}</h3>
                        <button type="button" @click="close"
                                class="text-slate-400 hover:text-slate-600 rounded-xl p-1.5 hover:bg-slate-100 transition cursor-pointer active:scale-95"
                                aria-label="Tutup Dialog">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="px-6 py-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    @endif
</div>
