<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Forgot password?</h2>
        <p class="text-sm text-slate-500 mt-1">No problem. Enter your email and we'll send you a password reset link.</p>
    </div>

    @if ($status)
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm">
            {{ $status }}
        </div>
    @endif

    <form wire:submit="sendResetLink" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email address</label>
            <input wire:model="email" id="email" type="email" required autofocus
                class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200 text-sm"
                placeholder="you@example.com">
            @error('email')
                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-75 disabled:cursor-not-allowed shadow-sm shadow-indigo-500/10 transition duration-150 cursor-pointer border border-transparent">
                <span wire:loading.remove wire:target="sendResetLink">Send Reset Link</span>
                <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending link...
                </span>
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to sign in
            </a>
        </div>
    </form>
</div>
