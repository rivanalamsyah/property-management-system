@props([
    'name' => null,
    'title' => null,
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div x-data="{ 
        show: @entangle($attributes->wire('model')),
        close() { this.show = false }
     }"
      x-show="show"
      x-on:keydown.escape.window="close"
      style="display: none;"
      class="fixed inset-0 z-50 overflow-y-auto"
      aria-labelledby="modal-title"
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
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity"
         @click="close"></div>

    <!-- Modal Content Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        
        <!-- Modal Card -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white border border-slate-200/80 text-left shadow-2xl transition-all w-full {{ $maxWidthClass }} my-8">

            <!-- Title & Close -->
            @if($title)
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-title">{{ $title }}</h3>
                <button type="button" @click="close" class="text-slate-400 hover:text-slate-600 rounded-xl p-1.5 hover:bg-slate-100 transition cursor-pointer" aria-label="Tutup Dialog">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            <!-- Body -->
            <div class="px-6 py-6">
                {{ $slot }}
            </div>
            
        </div>
    </div>
</div>
