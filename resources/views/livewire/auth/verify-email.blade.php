<div>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Verify your email</h2>
        <p class="text-sm text-slate-500 mt-1">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
    </div>

    @if ($status === 'verification-link-sent')
        <div class="mb-5 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 text-sm">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif

    <div class="space-y-4">
        <!-- Submit Button -->
        <button type="button" wire:click="sendVerification" wire:loading.attr="disabled"
            class="relative w-full flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-75 disabled:cursor-not-allowed shadow-md shadow-indigo-500/10 transition duration-200 cursor-pointer">
            <span wire:loading.remove wire:target="sendVerification">Resend Verification Email</span>
            <span wire:loading wire:target="sendVerification" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            </span>
        </button>

        <!-- Logout Link -->
        <div class="text-center">
            <button type="button" wire:click="logout"
                class="text-sm font-medium text-slate-500 hover:text-slate-700 transition cursor-pointer">
                Log Out
            </button>
        </div>
    </div>
</div>
