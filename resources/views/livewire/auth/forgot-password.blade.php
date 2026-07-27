<div>
    <!-- Icon illustration -->
    <div class="mb-7 flex flex-col items-center text-center space-y-4">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center shadow-xl shadow-indigo-500/25">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <div class="space-y-1">
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Lupa Kata Sandi?</h1>
            <p class="text-sm text-slate-500 font-medium max-w-xs">Tenang saja. Masukkan alamat email Anda dan kami akan mengirim tautan reset kata sandi.</p>
        </div>
    </div>

    <!-- Success State -->
    @if ($status)
        <div class="mb-5 flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200/60 rounded-2xl">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-emerald-800">Tautan Terkirim!</p>
                <p class="text-xs text-emerald-700 mt-0.5 font-medium">{{ $status }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="sendResetLink" class="space-y-5">
        <!-- Email -->
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-extrabold text-slate-700 uppercase tracking-wider">Alamat Email Terdaftar</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    required
                    autofocus
                    class="auth-input w-full pl-10 pr-4 py-3 bg-slate-50/70 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm font-medium"
                    placeholder="nama@perusahaan.com"
                >
            </div>
            @error('email')
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-rose-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span class="text-xs text-rose-600 font-medium">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Submit -->
        <button
            type="submit"
            wire:loading.attr="disabled"
            class="relative w-full flex justify-center items-center gap-2.5 px-4 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-70 disabled:cursor-not-allowed transition duration-150 cursor-pointer overflow-hidden group"
        >
            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 pointer-events-none"></span>

            <span wire:loading.remove wire:target="sendResetLink" class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Kirim Tautan Reset
            </span>
            <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengirim tautan...
            </span>
        </button>
    </form>

    <!-- Back Link -->
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke halaman masuk
        </a>
    </div>
</div>
