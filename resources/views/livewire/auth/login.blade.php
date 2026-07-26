<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Welcome back</h2>
        <p class="text-sm text-slate-500 mt-1">Please enter your details to sign in.</p>
    </div>

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
            <input wire:model="email" id="email" type="email" autocomplete="email" required
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="you@example.com">
            @error('email')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-500 transition">
                    Forgot password?
                </a>
            </div>
            <input wire:model="password" id="password" type="password" autocomplete="current-password" required
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="••••••••">
            @error('password')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="remember" id="remember" type="checkbox"
                class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50/50">
            <label for="remember" class="ml-2 block text-sm text-slate-600 select-none">
                Remember me for 30 days
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-75 disabled:cursor-not-allowed shadow-sm shadow-indigo-500/10 transition duration-150 cursor-pointer border border-transparent">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Signing in...
                </span>
            </button>
        </div>
    </form>
</div>
