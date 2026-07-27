<div class="text-center">
    <!-- Animated envelope illustration -->
    <div class="flex justify-center mb-7">
        <div class="relative">
            <!-- Outer ring pulse animation -->
            <div class="absolute inset-0 rounded-2xl bg-indigo-400/20 animate-ping"></div>
            <div class="relative w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center shadow-xl shadow-indigo-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="mb-7 space-y-2">
        <h1 class="text-2xl font-black tracking-tight text-slate-900">Verifikasi Email Anda</h1>
        <p class="text-sm text-slate-500 font-medium max-w-sm mx-auto leading-relaxed">
            Terima kasih telah mendaftar! Kami telah mengirimkan tautan verifikasi ke alamat email Anda. Mohon periksa kotak masuk Anda.
        </p>
    </div>

    <!-- Success State Banner -->
    @if ($status === 'verification-link-sent')
        <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200/60 rounded-2xl text-left">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-emerald-800">Email Baru Terkirim!</p>
                <p class="text-xs text-emerald-700 mt-0.5 font-medium">Tautan verifikasi baru telah dikirim ke email yang Anda daftarkan.</p>
            </div>
        </div>
    @endif

    <!-- Steps guide -->
    <div class="mb-7 p-4 bg-slate-50 border border-slate-200/60 rounded-2xl text-left space-y-3">
        <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Langkah Selanjutnya</p>
        <div class="space-y-2.5">
            <div class="flex items-center gap-3 text-xs text-slate-600 font-medium">
                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0">1</span>
                Buka aplikasi email Anda (Gmail, Outlook, dll.)
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-600 font-medium">
                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0">2</span>
                Cari email dari <strong class="text-slate-800">no-reply@kosan.app</strong>
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-600 font-medium">
                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-700 text-[10px] font-bold flex items-center justify-center flex-shrink-0">3</span>
                Klik tombol <strong class="text-slate-800">"Verifikasi Email"</strong> di dalam email tersebut
            </div>
        </div>
    </div>

    <!-- Resend Button -->
    <button
        type="button"
        wire:click="sendVerification"
        wire:loading.attr="disabled"
        class="relative w-full flex justify-center items-center gap-2.5 px-4 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 disabled:opacity-70 disabled:cursor-not-allowed transition duration-150 cursor-pointer overflow-hidden group mb-4"
    >
        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700 pointer-events-none"></span>

        <span wire:loading.remove wire:target="sendVerification" class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Kirim Ulang Email Verifikasi
        </span>
        <span wire:loading wire:target="sendVerification" class="flex items-center gap-2">
            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Mengirim...
        </span>
    </button>

    <!-- Logout -->
    <button
        type="button"
        wire:click="logout"
        class="w-full py-2.5 text-sm font-semibold text-slate-500 hover:text-slate-700 transition cursor-pointer"
    >
        Keluar dari Akun
    </button>
</div>
