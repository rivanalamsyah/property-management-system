<header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 h-16 flex items-center justify-between px-6 z-20 sticky top-0 transition-colors">
    
    <!-- Left Section: Mobile Menu Button & Breadcrumbs -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="md:hidden p-2 text-slate-500 hover:text-slate-800 rounded-xl hover:bg-slate-100 cursor-pointer" aria-label="Buka Menu Navigation">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <!-- Breadcrumbs -->
        <nav class="hidden sm:flex items-center space-x-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
            @foreach($breadcrumbs as $breadcrumb)
                <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ $breadcrumb['url'] }}" class="hover:text-indigo-600 transition {{ $loop->last ? 'text-slate-900 font-bold' : '' }}">{{ $breadcrumb['name'] }}</a>
            @endforeach
        </nav>
    </div>

    <!-- Right Section: Actions, Notifications, & User Dropdown -->
    <div class="flex items-center gap-3">

        <!-- Tenant Switcher Dropdown -->
        @if($tenants->count() > 1)
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl text-xs font-semibold text-slate-700 transition cursor-pointer">
                <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                <span>Ganti Properti</span>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-60 rounded-2xl bg-white border border-slate-200/80 shadow-xl py-1.5 z-50 overflow-hidden">
                <div class="px-4 py-2 border-b border-slate-50 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pilih Ruang Kerja</div>
                @foreach($tenants as $tenantItem)
                    <a href="{{ route('tenant.switch', $tenantItem->id) }}" class="flex items-center justify-between px-4 py-2.5 text-xs text-slate-700 hover:bg-slate-50 transition {{ $currentTenant && $currentTenant->id === $tenantItem->id ? 'font-bold text-indigo-600 bg-indigo-50/40' : '' }}">
                        <span class="truncate">{{ $tenantItem->name }}</span>
                        @if($currentTenant && $currentTenant->id === $tenantItem->id)
                            <svg class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Notification Bell Dropdown -->
        @livewire('notification.notification-center')

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2 p-1 hover:bg-slate-100 rounded-xl transition cursor-pointer" aria-label="Buka Menu Profil">
                <img class="h-8 w-8 rounded-lg object-cover bg-slate-100 border border-slate-200/60" 
                     src="{{ auth()->user()->avatar_url }}" 
                     alt="{{ auth()->user()->name }}">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-2xl bg-white border border-slate-200/80 shadow-xl py-2 z-50 overflow-hidden">
                <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/40">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                </div>
                
                <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Profil Saya</span>
                </a>
                
                @can('manage-settings')
                <a href="{{ route('settings') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Pengaturan Ruang Kerja</span>
                </a>
                @endcan
                
                <div class="border-t border-slate-100 my-1"></div>
                
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50/50 transition cursor-pointer">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>