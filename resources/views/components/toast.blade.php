<div x-data="{ 
        toasts: [],
        add(e) {
            let id = Date.now();
            let toast = {
                id: id,
                type: e.detail[0]?.type || 'info',
                message: e.detail[0]?.message || '',
            };
            this.toasts.push(toast);
            setTimeout(() => {
                this.remove(id);
            }, 5000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
     }"
     @toast.window="add($event)"
     class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 w-full max-w-sm pointer-events-none">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-4 opacity-0 scale-95"
             x-transition:enter-end="transform translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto flex items-start gap-3 p-4 rounded-2xl border bg-white/95 backdrop-blur-md shadow-xl transition"
             :class="{
                'border-emerald-200/60 bg-emerald-50/90 text-emerald-950': toast.type === 'success',
                'border-rose-200/60 bg-rose-50/90 text-rose-950': toast.type === 'error',
                'border-amber-200/60 bg-amber-50/90 text-amber-950': toast.type === 'warning',
                'border-indigo-200/60 bg-indigo-50/90 text-indigo-950': toast.type === 'info'
             }">
            
            <!-- Icon -->
            <div class="flex-shrink-0 pt-0.5">
                <template x-if="toast.type === 'success'">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1">
                <p class="text-[10px] font-bold uppercase tracking-wider opacity-70" x-text="toast.type"></p>
                <p class="text-xs font-medium mt-0.5 leading-relaxed" x-text="toast.message"></p>
            </div>

            <!-- Close Button -->
            <button @click="remove(toast.id)" class="flex-shrink-0 text-slate-400 hover:text-slate-600 rounded-lg p-1 hover:bg-black/5 cursor-pointer">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
