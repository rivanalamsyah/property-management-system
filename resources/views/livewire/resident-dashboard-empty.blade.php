<div class="min-h-[70vh] flex flex-col items-center justify-center p-6 text-center">
    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Data Penghuni Menunggu Verifikasi</h1>
    <p class="text-slate-500 max-w-md mb-6">
        Akun pengguna Anda telah terdaftar dengan peran penghuni. Namun, profil Anda belum tertaut ke profil kontrak kos aktif yang cocok dengan email Anda (<span class="font-semibold text-slate-800">{{ auth()->user()->email }}</span>) di ruang kerja ini.
    </p>
    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-sm text-slate-600 max-w-sm mb-8">
        Silakan hubungi administrator atau pemilik kos untuk menyelesaikan pendaftaran penghuni Anda dan menautkan email Anda ke kontrak kamar yang aktif.
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <x-button type="submit" variant="outline">
            Keluar dan Coba Lagi
        </x-button>
    </form>
</div>
