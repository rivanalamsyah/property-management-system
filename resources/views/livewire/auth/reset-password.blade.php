<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Reset password</h2>
        <p class="text-sm text-slate-500 mt-1">Please enter your new password below.</p>
    </div>

    <form wire:submit="resetPassword" class="space-y-5">
        <input type="hidden" wire:model="token">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
            <input wire:model="email" id="email" type="email" required autocomplete="email" readonly
                class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 focus:outline-none text-sm cursor-not-allowed">
            @error('email')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
            <input wire:model="password" id="password" type="password" required autocomplete="new-password" autofocus
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="••••••••">
            @error('password')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password"
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="••••••••">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-75 disabled:cursor-not-allowed shadow-sm shadow-indigo-500/10 transition duration-150 cursor-pointer border border-transparent">
                <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                <span wire:loading wire:target="resetPassword" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Resetting...
                </span>
            </button>
        </div>
    </form>
</div>
