@props([
    'id',
    'title' => 'Konfirmasi Tindakan',
    'message' => 'Apakah Anda yakin ingin melakukan tindakan ini? Tindakan ini tidak dapat dibatalkan.',
    'confirmText' => 'Konfirmasi',
    'confirmVariant' => 'danger',
    'action' => null,
])

<div x-data="{ show: false }"
     @confirm-{{ $id }}.window="show = true"
     @close-{{ $id }}.window="show = false"
     x-show="show"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto"
     role="dialog"
     aria-modal="true">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity" @click="show = false"></div>

    <!-- Dialog Position -->
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        
        <!-- Dialog Box -->
        <div class="relative transform overflow-hidden rounded-3xl bg-white border border-slate-200/80 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6">
            
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                    <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">{{ $title }}</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ $message }}</p>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <x-button variant="outline" size="sm" @click="show = false">Batal</x-button>
                @if($action)
                    <x-button variant="{{ $confirmVariant }}" size="sm" wire:click="{{ $action }}" @click="show = false">
                        {{ $confirmText }}
                    </x-button>
                @endif
            </div>

        </div>
    </div>
</div>
