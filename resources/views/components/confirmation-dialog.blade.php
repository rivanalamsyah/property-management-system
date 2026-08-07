@props([
    'id',
    'title'         => 'Konfirmasi Tindakan',
    'message'       => 'Apakah Anda yakin ingin melakukan tindakan ini? Tindakan ini tidak dapat dibatalkan.',
    'confirmText'   => 'Konfirmasi',
    'confirmVariant'=> 'danger',
    'action'        => null,
    'variant'       => 'danger', // danger | warning | info
])

@php
$variantConfig = [
    'danger'  => ['bg' => 'bg-rose-50',   'text' => 'text-rose-600',   'icon_bg' => 'bg-rose-100',   'pulse' => 'danger-ring-pulse'],
    'warning' => ['bg' => 'bg-amber-50',  'text' => 'text-amber-600',  'icon_bg' => 'bg-amber-100',  'pulse' => ''],
    'info'    => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'icon_bg' => 'bg-indigo-100', 'pulse' => ''],
][$variant];
@endphp

<div x-data="{
        show: false,
        enter() {
            this.show = true;
            this.$nextTick(() => {
                const icon = this.$el.querySelector('.dialog-icon');
                if (icon) {
                    icon.classList.add('[animation:wiggle_0.4s_cubic-bezier(0.36,0.07,0.19,0.97)_both]');
                }
            });
        },
        close() { this.show = false }
     }"
     @confirm-{{ $id }}.window="enter"
     @close-{{ $id }}.window="close"
     x-show="show"
     x-on:keydown.escape.window="close"
     style="display:none;"
     class="fixed inset-0 z-50 overflow-y-auto"
     role="alertdialog"
     aria-modal="true"
     aria-labelledby="confirm-title-{{ $id }}">

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

    <!-- Dialog Box -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-0">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-180"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="relative overflow-hidden rounded-3xl glass-modal border border-slate-200/60 shadow-2xl w-full sm:max-w-md p-6 my-8">

            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="dialog-icon flex-shrink-0 w-11 h-11 rounded-2xl {{ $variantConfig['icon_bg'] }} {{ $variantConfig['text'] }} flex items-center justify-center {{ $variantConfig['pulse'] ? 'ring-pulse-danger' : '' }}">
                    @if($variant === 'danger')
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    @elseif($variant === 'warning')
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    @else
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>

                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight" id="confirm-title-{{ $id }}">{{ $title }}</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $message }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100/80">
                <x-button variant="outline" size="sm" @click="close">
                    Batal
                </x-button>
                @if($action)
                    <x-button variant="{{ $confirmVariant }}" size="sm"
                              wire:click="{{ $action }}"
                              @click="close">
                        {{ $confirmText }}
                    </x-button>
                @endif
                @if($slot->isNotEmpty())
                    {{ $slot }}
                @endif
            </div>
        </div>
    </div>
</div>
