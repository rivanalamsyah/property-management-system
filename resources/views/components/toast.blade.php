<div x-data="{
        toasts: [],
        add(e) {
            let id = Date.now();
            let toast = {
                id:      id,
                type:    e.detail[0]?.type || 'info',
                message: e.detail[0]?.message || '',
                title:   e.detail[0]?.title || null,
            };
            this.toasts.unshift(toast);
            setTimeout(() => this.remove(id), 5200);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
     }"
     @toast.window="add($event)"
     class="fixed bottom-20 md:bottom-6 right-4 sm:right-6 z-[60] flex flex-col-reverse gap-2.5 w-full max-w-[22rem] pointer-events-none">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-4 opacity-0 scale-95"
             x-transition:enter-end="transform translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-x-0"
             x-transition:leave-end="opacity-0 scale-95 translate-x-4"
             class="pointer-events-auto relative flex items-start gap-3 p-4 rounded-2xl border overflow-hidden glass-toast shadow-xl"
             :class="{
                'border-emerald-200/70 bg-emerald-50/95': toast.type === 'success',
                'border-rose-200/70 bg-rose-50/95':       toast.type === 'error',
                'border-amber-200/70 bg-amber-50/95':     toast.type === 'warning',
                'border-indigo-200/70 bg-indigo-50/95':   toast.type === 'info',
             }">

            <!-- Progress Bar -->
            <div class="toast-progress opacity-50"
                 :class="{
                    'toast-progress-success':  toast.type === 'success',
                    'toast-progress-error':    toast.type === 'error',
                    'toast-progress-warning':  toast.type === 'warning',
                    'toast-progress-info':     toast.type === 'info',
                 }"></div>

            <!-- Icon Ring -->
            <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center"
                 :class="{
                    'bg-emerald-100 text-emerald-600': toast.type === 'success',
                    'bg-rose-100 text-rose-600':       toast.type === 'error',
                    'bg-amber-100 text-amber-600':     toast.type === 'warning',
                    'bg-indigo-100 text-indigo-600':   toast.type === 'info',
                 }">
                <template x-if="toast.type === 'success'">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <template x-if="toast.title">
                    <p class="text-xs font-bold mb-0.5"
                       :class="{
                          'text-emerald-900': toast.type === 'success',
                          'text-rose-900':    toast.type === 'error',
                          'text-amber-900':   toast.type === 'warning',
                          'text-indigo-900':  toast.type === 'info',
                       }"
                       x-text="toast.title"></p>
                </template>
                <p class="text-xs font-medium leading-relaxed"
                   :class="{
                      'text-emerald-800': toast.type === 'success',
                      'text-rose-800':    toast.type === 'error',
                      'text-amber-800':   toast.type === 'warning',
                      'text-indigo-800':  toast.type === 'info',
                   }"
                   x-text="toast.message"></p>
            </div>

            <!-- Close -->
            <button @click="remove(toast.id)"
                    class="flex-shrink-0 rounded-lg p-1 hover:bg-black/8 cursor-pointer transition-all active:scale-90"
                    :class="{
                       'text-emerald-500 hover:text-emerald-700': toast.type === 'success',
                       'text-rose-500 hover:text-rose-700':       toast.type === 'error',
                       'text-amber-500 hover:text-amber-700':     toast.type === 'warning',
                       'text-indigo-500 hover:text-indigo-700':   toast.type === 'info',
                    }"
                    aria-label="Tutup notifikasi">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>
