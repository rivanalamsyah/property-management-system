@php
    // Resolve breadcrumbs from the ViewComposer / shared data
    $breadcrumbs = $breadcrumbs ?? [];

    // Resolve tenants
    $tenants      = $tenants ?? collect();
    $currentTenant = $currentTenant ?? null;
@endphp

<header class="glass-header h-16 flex items-center justify-between px-4 sm:px-6 z-20 sticky top-0 flex-shrink-0 transition-all duration-300"
        x-data="{
            lastScroll: 0,
            headerVisible: true,
            searchOpen: false,
            searchQuery: '',
        }"
        x-init="
            const main = document.getElementById('main-content');
            if (main) {
                main.addEventListener('scroll', () => {
                    const current = main.scrollTop;
                    headerVisible = current <= 10 || current < lastScroll;
                    lastScroll = current;
                }, { passive: true });
            }
        "
        :class="headerVisible ? 'opacity-100 translate-y-0' : '-translate-y-1 opacity-95'"
        style="transition: opacity 0.25s ease, transform 0.25s ease, box-shadow 0.2s ease;"
        id="app-header">

    <!-- Left: Mobile Menu + Breadcrumbs -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- Mobile Hamburger -->
        <button @click="sidebarOpen = true"
                class="md:hidden p-2 text-slate-500 hover:text-slate-800 rounded-xl hover:bg-slate-100/80 cursor-pointer transition-all duration-150 active:scale-95"
                aria-label="Buka Menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Breadcrumb Navigation -->
        <nav class="hidden sm:flex items-center gap-1.5 min-w-0" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}"
               class="breadcrumb-item flex-shrink-0"
               title="Dashboard">
                <svg class="w-3.5 h-3.5 text-slate-400 hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </a>
            @foreach($breadcrumbs as $breadcrumb)
                <svg class="w-3 h-3 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ $breadcrumb['url'] }}"
                   class="breadcrumb-item truncate {{ $loop->last ? 'breadcrumb-item-active' : '' }}">
                    {{ $breadcrumb['name'] }}
                </a>
            @endforeach
        </nav>
    </div>

    <!-- Right: Actions, Search, Notifications, User -->
    <div class="flex items-center gap-2 flex-shrink-0">

        <!-- Floating Search (expandable) -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open; if(open) $nextTick(() => $refs.searchInput.focus())"
                    class="p-2 text-slate-500 hover:text-slate-800 rounded-xl hover:bg-slate-100/80 cursor-pointer transition-all duration-150 active:scale-95"
                    aria-label="Cari">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            <!-- Dropdown search panel -->
            <div x-show="open"
                 @click.away="open = false"
                 @keydown.escape.window="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                 class="absolute right-0 top-full mt-2 w-80 glass-dropdown rounded-2xl overflow-hidden z-50"
                 style="display:none;">
                <div class="p-3">
                    <div class="relative">
                        <input x-ref="searchInput"
                               x-model="searchQuery"
                               type="text"
                               placeholder="Cari kamar, penghuni, tagihan..."
                               class="input-base input-with-icon pr-4 text-sm"
                               style="padding-left: 2.5rem;">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="px-3 pb-3">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 px-1">Akses Cepat</div>
                    <div class="space-y-0.5">
                        <a href="{{ route('rooms') }}" @click="open = false"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 text-xs font-semibold text-slate-700 hover:text-indigo-600 transition-all group">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span>Kamar Kos</span>
                        </a>
                        <a href="{{ route('residents') }}" @click="open = false"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 text-xs font-semibold text-slate-700 hover:text-indigo-600 transition-all group">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span>Penghuni Kos</span>
                        </a>
                        <a href="{{ route('invoices') }}" @click="open = false"
                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 text-xs font-semibold text-slate-700 hover:text-indigo-600 transition-all group">
                            <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <span>Tagihan &amp; Faktur</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenant Switcher -->
        @if($tenants->count() > 1)
        <div x-data="{ open: false }" class="relative hidden sm:block">
            <button @click="open = !open"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-50/80 hover:bg-white border border-slate-200/70 hover:border-indigo-200/60 rounded-xl text-xs font-semibold text-slate-700 hover:text-indigo-700 transition-all duration-150 cursor-pointer shadow-2xs hover:shadow-xs"
                    aria-label="Ganti Properti">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                <span>Ganti Properti</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-64 glass-dropdown rounded-2xl py-1.5 z-50 overflow-hidden"
                 style="display:none;">
                <div class="px-4 py-2 border-b border-slate-50/80 section-label">Pilih Ruang Kerja</div>
                @foreach($tenants as $tenantItem)
                    <a href="{{ route('tenant.switch', $tenantItem->id) }}"
                       class="flex items-center justify-between px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50/80 transition {{ $currentTenant && $currentTenant->id === $tenantItem->id ? 'font-bold text-indigo-600 bg-indigo-50/40' : 'font-semibold' }}">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg {{ $currentTenant && $currentTenant->id === $tenantItem->id ? 'bg-indigo-600' : 'bg-slate-200' }} flex items-center justify-center text-[9px] font-black {{ $currentTenant && $currentTenant->id === $tenantItem->id ? 'text-white' : 'text-slate-600' }} uppercase">
                                {{ substr($tenantItem->name, 0, 2) }}
                            </div>
                            <span class="truncate">{{ $tenantItem->name }}</span>
                        </div>
                        @if($currentTenant && $currentTenant->id === $tenantItem->id)
                            <svg class="w-3.5 h-3.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Notification Bell -->
        @livewire('notification.notification-center')

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2 p-1 hover:bg-slate-100/70 rounded-xl transition-all duration-150 cursor-pointer active:scale-95"
                    aria-label="Menu Profil"
                    aria-expanded="false">
                <div class="relative">
                    <img class="h-8 w-8 rounded-xl object-cover bg-slate-100 border-2 border-white shadow-xs ring-2 ring-indigo-500/20"
                         src="{{ auth()->user()->avatar_url }}"
                         alt="{{ auth()->user()->name }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4f46e5&color=fff&size=64'">
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="hidden lg:block text-left">
                    <p class="text-xs font-bold text-slate-800 leading-tight max-w-24 truncate">{{ auth()->user()->name }}</p>
                </div>
                <svg class="w-3 h-3 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open"
                 @click.away="open = false"
                 @keydown.escape.window="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-60 glass-dropdown rounded-2xl py-2 z-50 overflow-hidden"
                 style="display:none;">

                <!-- User Info Header -->
                <div class="px-4 py-3 border-b border-slate-100/80">
                    <div class="flex items-center gap-3">
                        <img class="h-9 w-9 rounded-xl object-cover border border-slate-200/60"
                             src="{{ auth()->user()->avatar_url }}"
                             alt="{{ auth()->user()->name }}"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4f46e5&color=fff&size=64'">
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-2.5 flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-50 border border-indigo-200/60 text-[10px] font-bold text-indigo-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                        @if(auth()->user()->hasRole('super_admin'))
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 border border-amber-200/60 text-[10px] font-bold text-amber-700">
                            Super Admin
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="py-1">
                    <a href="{{ route('profile') }}"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50/80 hover:text-indigo-600 transition-all group">
                        <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span>Profil Saya</span>
                    </a>

                    @can('manage-settings')
                    <a href="{{ route('settings') }}"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50/80 hover:text-indigo-600 transition-all group">
                        <div class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span>Pengaturan Ruang Kerja</span>
                    </a>
                    @endcan
                </div>

                <div class="border-t border-slate-100/80 my-0.5"></div>

                <!-- Logout -->
                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2.5 w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50/60 transition-all cursor-pointer group">
                            <div class="w-6 h-6 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 group-hover:bg-rose-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <span>Keluar Akun</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</header>