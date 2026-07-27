<div :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" class="hidden md:block md:flex-shrink-0 z-30">
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 md:hidden"></div>

    <!-- Sidebar Wrapper -->
    <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed md:static inset-y-0 left-0 w-64 md:translate-x-0 bg-white border-r border-slate-200/80 flex flex-col z-50 transition-transform duration-300 ease-in-out h-full">
        
        <!-- Header / Logo -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/20">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">Kosan.</span>
            </a>
            
            <button @click="sidebarOpen = false" class="md:hidden p-1 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer" aria-label="Tutup Menu Navigation">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Active Tenant Info Badge -->
        <div class="px-5 py-3.5 border-b border-slate-100/80 bg-slate-50/40">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-white border border-slate-200/60 shadow-2xs">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                    {{ substr(tenant() ? tenant()->name : 'K', 0, 2) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <h3 class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Ruang Kerja</h3>
                    <p class="text-xs font-bold text-slate-800 truncate">{{ tenant() ? tenant()->name : 'Tanpa Ruang Kerja' }}</p>
                </div>
            </div>
        </div>

        <!-- Nav Links Grouped -->
        <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto">
            
            <!-- Group 1: Operasional -->
            <div class="space-y-1">
                <div class="px-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Operasional</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                    <span>Dashboard</span>
                </a>

                @can('manage-rooms')
                <a href="{{ route('rooms') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('rooms*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Kamar Kos</span>
                </a>

                <a href="{{ route('residents') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('residents*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Penghuni Kos</span>
                </a>

                <a href="{{ route('contracts') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('contracts*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Kontrak Hunian</span>
                </a>
                @endcan
            </div>

            <!-- Group 2: Keuangan -->
            @can('manage-payments')
            <div class="space-y-1">
                <div class="px-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Keuangan</div>
                
                <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('invoices*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span>Tagihan &amp; Faktur</span>
                </a>

                <a href="{{ route('payments') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('payments*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Verifikasi Pembayaran</span>
                </a>
            </div>
            @endcan

            <!-- Group 3: Manajemen -->
            <div class="space-y-1">
                <div class="px-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Manajemen</div>
                
                <a href="{{ route('complaints') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('complaints*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Laporan Kerusakan</span>
                </a>

                @can('manage-settings')
                <a href="{{ route('announcements') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('announcements*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <span>Pusat Pengumuman</span>
                </a>

                <a href="{{ route('analytics.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('analytics*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                    <span>BI Reports &amp; Analytics</span>
                </a>
                @endcan
            </div>

            <!-- Group 4: Sistem & Hak Akses -->
            <div class="space-y-1">
                <div class="px-3 pb-1 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Sistem &amp; Pengaturan</div>

                @can('manage-rooms')
                <a href="{{ route('boarding-houses') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('boarding-houses*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Master Properti Kos</span>
                </a>
                @endcan

                @can('manage-settings')
                <a href="{{ route('facilities') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('facilities*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Katalog Fasilitas</span>
                </a>

                <a href="{{ route('billing') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('billing') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span>SaaS Billing Portal</span>
                </a>

                <a href="{{ route('workspaces.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('workspaces.index') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Workspaces (Admin)</span>
                </a>

                <a href="{{ route('cms.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('cms*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span>Konsol CMS</span>
                </a>
                @endcan

                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('settings') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Pengaturan Ruang Kerja</span>
                </a>

                @can('manage-settings')
                <a href="{{ route('settings.platform') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('settings.platform') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <span>Platform Settings</span>
                </a>

                <a href="{{ route('monitoring.console') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('monitoring*') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                    <span>Monitoring Console</span>
                </a>

                <a href="{{ route('security.center') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('security.center') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Keamanan &amp; Vault</span>
                </a>

                <a href="{{ route('backup.center') }}" class="flex items-center gap-3 px-3 py-2 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('backup.center') ? 'bg-indigo-50 text-indigo-600 font-bold border-l-2 border-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"></path></svg>
                    <span>Backup &amp; Pemulihan</span>
                </a>
                @endcan
            </div>

        </nav>

        <!-- User Profile Footer Card -->
        <div class="p-3 border-t border-slate-100/80 bg-slate-50/40">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 w-full hover:bg-white border border-transparent hover:border-slate-200/60 p-2 rounded-xl transition duration-150">
                <img class="h-8 w-8 rounded-lg object-cover bg-slate-100 border border-slate-200/50 flex-shrink-0" 
                     src="{{ auth()->user()->avatar_url }}" 
                     alt="{{ auth()->user()->name }}">
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </a>
        </div>

    </div>
</div>
