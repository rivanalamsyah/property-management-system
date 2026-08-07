<div class="flex-shrink-0 z-30" :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 md:hidden"
         aria-hidden="true">
    </div>

    <!-- Sidebar Wrapper -->
    <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
         class="fixed md:static inset-y-0 left-0 w-64 glass-sidebar flex flex-col z-50 transition-transform duration-300 ease-in-out h-full hidden md:flex">

        <!-- Logo / Header -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200/50 flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" aria-label="Kosan Home">
                <img src="{{ asset('images/logos/logo.png') }}" class="h-8 w-auto transition-transform duration-300 group-hover:scale-105" alt="Kosan Logo">
            </a>
            <button @click="sidebarOpen = false"
                    class="md:hidden p-1.5 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 cursor-pointer transition-all duration-150"
                    aria-label="Tutup Menu">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Active Workspace Badge -->
        <div class="px-4 py-3 border-b border-slate-100/60 bg-slate-50/40 flex-shrink-0">
            <div class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200/60 shadow-2xs group hover:border-indigo-200/60 hover:shadow-xs transition-all duration-200 cursor-default">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center font-black text-xs uppercase flex-shrink-0 shadow-sm shadow-indigo-500/30">
                    {{ substr(tenant() ? tenant()->name : 'KS', 0, 2) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <h3 class="section-label">Ruang Kerja</h3>
                    <p class="text-xs font-bold text-slate-800 truncate mt-0.5">{{ tenant() ? tenant()->name : 'Tanpa Ruang Kerja' }}</p>
                </div>
                <div class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0 animate-pulse" title="Aktif"></div>
            </div>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 px-3 py-4 space-y-5 overflow-y-auto" id="sidebar-nav">

            <!-- Group 1: Operasional -->
            <div class="space-y-0.5">
                <div class="px-3 pb-2 section-label">Operasional</div>

                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'nav-item-active' : '' }}"
                   style="{{ request()->routeIs('dashboard') ? '' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('dashboard') ? '2.5' : '1.75' }}"
                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @can('manage-rooms')
                <a href="{{ route('rooms') }}"
                   class="nav-item {{ request()->routeIs('rooms*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('rooms*') ? '2.5' : '1.75' }}"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kamar Kos</span>
                </a>

                <a href="{{ route('residents') }}"
                   class="nav-item {{ request()->routeIs('residents*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('residents*') ? '2.5' : '1.75' }}"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Penghuni Kos</span>
                </a>

                <a href="{{ route('contracts') }}"
                   class="nav-item {{ request()->routeIs('contracts*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('contracts*') ? '2.5' : '1.75' }}"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Kontrak Hunian</span>
                </a>
                @endcan
            </div>

            <!-- Group 2: Keuangan -->
            @can('manage-payments')
            <div class="space-y-0.5">
                <div class="px-3 pb-2 section-label">Keuangan</div>

                <a href="{{ route('invoices') }}"
                   class="nav-item {{ request()->routeIs('invoices*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('invoices*') ? '2.5' : '1.75' }}"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Tagihan &amp; Faktur</span>
                </a>

                <a href="{{ route('payments') }}"
                   class="nav-item {{ request()->routeIs('payments*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('payments*') ? '2.5' : '1.75' }}"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Verifikasi Pembayaran</span>
                </a>
            </div>
            @endcan

            <!-- Group 3: Manajemen -->
            <div class="space-y-0.5">
                <div class="px-3 pb-2 section-label">Manajemen</div>

                @can('manage-complaints')
                <a href="{{ route('complaints') }}"
                   class="nav-item {{ request()->routeIs('complaints*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('complaints*') ? '2.5' : '1.75' }}"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Laporan Kerusakan</span>
                </a>
                @endcan

                @can('manage-settings')
                <a href="{{ route('announcements') }}"
                   class="nav-item {{ request()->routeIs('announcements*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('announcements*') ? '2.5' : '1.75' }}"
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <span>Pusat Pengumuman</span>
                </a>

                <a href="{{ route('analytics.dashboard') }}"
                   class="nav-item {{ request()->routeIs('analytics*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('analytics*') ? '2.5' : '1.75' }}"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                    </svg>
                    <span>Laporan BI &amp; Analisis</span>
                </a>
                @endcan
            </div>

            <!-- Group 4: Sistem & Pengaturan -->
            <div class="space-y-0.5">
                <div class="px-3 pb-2 section-label">Sistem &amp; Pengaturan</div>

                @can('manage-rooms')
                <a href="{{ route('boarding-houses') }}"
                   class="nav-item {{ request()->routeIs('boarding-houses*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('boarding-houses*') ? '2.5' : '1.75' }}"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Master Properti Kos</span>
                </a>
                @endcan

                @can('manage-settings')
                <a href="{{ route('facilities') }}"
                   class="nav-item {{ request()->routeIs('facilities*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('facilities*') ? '2.5' : '1.75' }}"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Katalog Fasilitas</span>
                </a>

                @if(auth()->user()->hasRole(['owner', 'super_admin']))
                <a href="{{ route('billing') }}"
                   class="nav-item {{ request()->routeIs('billing') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('billing') ? '2.5' : '1.75' }}"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>SaaS Billing Portal</span>
                </a>
                @endif

                @if(auth()->user()->hasRole('super_admin'))
                <a href="{{ route('workspaces.index') }}"
                   class="nav-item {{ request()->routeIs('workspaces.index') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('workspaces.index') ? '2.5' : '1.75' }}"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>Ruang Kerja (Admin)</span>
                </a>

                <a href="{{ route('cms.dashboard') }}"
                   class="nav-item {{ request()->routeIs('cms*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('cms*') ? '2.5' : '1.75' }}"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span>Konsol CMS</span>
                </a>
                @endif
                @endcan

                @can('manage-settings')
                <a href="{{ route('settings') }}"
                   class="nav-item {{ request()->routeIs('settings') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('settings') ? '2.5' : '1.75' }}"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('settings') ? '2.5' : '1.75' }}" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan Ruang Kerja</span>
                </a>
                @endcan

                @if(auth()->user()->hasRole('super_admin'))
                <a href="{{ route('settings.platform') }}"
                   class="nav-item {{ request()->routeIs('settings.platform') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('settings.platform') ? '2.5' : '1.75' }}"
                              d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span>Pengaturan Platform</span>
                </a>

                <a href="{{ route('monitoring.console') }}"
                   class="nav-item {{ request()->routeIs('monitoring*') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('monitoring*') ? '2.5' : '1.75' }}"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                    </svg>
                    <span>Konsol Pemantauan</span>
                </a>

                <a href="{{ route('security.center') }}"
                   class="nav-item {{ request()->routeIs('security.center') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('security.center') ? '2.5' : '1.75' }}"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Keamanan &amp; Vault</span>
                </a>

                <a href="{{ route('backup.center') }}"
                   class="nav-item {{ request()->routeIs('backup.center') ? 'nav-item-active' : '' }}">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('backup.center') ? '2.5' : '1.75' }}"
                              d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"/>
                    </svg>
                    <span>Pencadangan &amp; Pemulihan</span>
                </a>
                @endif
            </div>

        </nav>

        <!-- User Profile Footer -->
        <div class="p-3 border-t border-slate-100/60 bg-slate-50/30 flex-shrink-0">
            <a href="{{ route('profile') }}"
               class="flex items-center gap-2.5 w-full p-2 rounded-xl hover:bg-white border border-transparent hover:border-slate-200/60 hover:shadow-2xs transition-all duration-200 group">
                <div class="relative flex-shrink-0">
                    <img class="h-8 w-8 rounded-lg object-cover bg-slate-100 border border-slate-200/50"
                         src="{{ auth()->user()->avatar_url }}"
                         alt="{{ auth()->user()->name }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4f46e5&color=fff&size=64'">
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-bold text-slate-800 truncate group-hover:text-indigo-700 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-indigo-400 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</div>
