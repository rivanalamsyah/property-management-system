<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Create a new workspace</h2>
        <p class="text-sm text-slate-500 mt-1">To get started, please set up a boarding house workspace.</p>
    </div>

    <form wire:submit="createWorkspace" class="space-y-5">
        <!-- Boarding House Name -->
        <div>
            <label for="workspace_name" class="block text-sm font-medium text-slate-700 mb-1.5">Boarding House Name</label>
            <input wire:model="workspace_name" id="workspace_name" type="text" required autofocus
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="e.g. Kosan Premium Cihampelas">
            @error('workspace_name')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" wire:loading.attr="disabled"
                class="relative w-full flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-75 disabled:cursor-not-allowed shadow-md shadow-indigo-500/10 transition duration-200 cursor-pointer">
                <span wire:loading.remove wire:target="createWorkspace">Create Workspace</span>
                <span wire:loading wire:target="createWorkspace" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>
