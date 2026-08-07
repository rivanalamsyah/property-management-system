<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          sidebarOpen: false,
          pageLoaded: false,
          searchOpen: false
      }"
      x-init="setTimeout(() => pageLoaded = true, 50)"
      class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- PWA Mobile Capabilities -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kosan">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="manifest" href="/manifest.json">

    <title>{{ config('app.name', 'Kosan') }} — {{ $pageTitle ?? 'Dashboard' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Outfit', 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full text-slate-900 antialiased app-background" x-cloak>

    <div class="h-screen flex overflow-hidden">

        <!-- Sidebar Navigation -->
        <x-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            <!-- Header -->
            <x-header />

            <!-- Main Scrollable Section -->
            <main class="flex-1 overflow-y-auto focus:outline-none p-4 sm:p-6 pb-20 md:pb-6"
                  id="main-content">
                <div class="max-w-7xl mx-auto space-y-6"
                     x-show="pageLoaded"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    {{ $slot }}
                </div>

                <!-- Loading skeleton shown before page content loads -->
                <div class="max-w-7xl mx-auto space-y-6" x-show="!pageLoaded">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @for($i = 0; $i < 4; $i++)
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="h-3 shimmer-skeleton rounded w-24"></div>
                                    <div class="w-10 h-10 shimmer-skeleton rounded-2xl"></div>
                                </div>
                                <div class="h-7 shimmer-skeleton rounded w-16 mb-2"></div>
                                <div class="h-2.5 shimmer-skeleton rounded w-32"></div>
                            </div>
                        @endfor
                    </div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs">
                        <div class="h-4 shimmer-skeleton rounded w-40 mb-4"></div>
                        <div class="space-y-3">
                            @for($i = 0; $i < 5; $i++)
                                <div class="h-3.5 shimmer-skeleton rounded w-full"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="hidden md:flex glass-panel border-t border-slate-100/80 py-3 px-6 items-center justify-between text-xs text-slate-400 flex-shrink-0">
                <span>&copy; {{ date('Y') }} <span class="font-semibold text-slate-500">{{ config('app.name', 'Kosan') }}</span> Platform. Seluruh hak cipta dilindungi.</span>
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Berjalan Normal
                </span>
            </footer>

        </div>
    </div>

    <!-- Mobile Bottom Navigation -->
    <nav class="bottom-nav md:hidden" id="bottom-navigation" aria-label="Mobile Navigation">
        <a href="{{ route('dashboard') }}"
           class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           aria-label="Dashboard">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('dashboard') ? '2.5' : '1.75' }}"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
            </svg>
            <span>Dashboard</span>
        </a>
        @can('manage-rooms')
        <a href="{{ route('rooms') }}"
           class="bottom-nav-item {{ request()->routeIs('rooms*') ? 'active' : '' }}"
           aria-label="Kamar">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('rooms*') ? '2.5' : '1.75' }}"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Kamar</span>
        </a>
        <a href="{{ route('residents') }}"
           class="bottom-nav-item {{ request()->routeIs('residents*') ? 'active' : '' }}"
           aria-label="Penghuni">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('residents*') ? '2.5' : '1.75' }}"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Penghuni</span>
        </a>
        @endcan
        @can('manage-payments')
        <a href="{{ route('invoices') }}"
           class="bottom-nav-item {{ request()->routeIs('invoices*') ? 'active' : '' }}"
           aria-label="Tagihan">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('invoices*') ? '2.5' : '1.75' }}"
                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span>Tagihan</span>
        </a>
        @endcan
        <button @click="sidebarOpen = true"
                class="bottom-nav-item"
                aria-label="Menu Lengkap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:1.375rem;height:1.375rem;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span>Menu</span>
        </button>
    </nav>

    <!-- Global Toast Notifications -->
    <x-toast />

    <!-- Livewire Scripts -->
    @livewireScripts

    <script>
        // Scroll reveal observer
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal, .reveal-scale').forEach(el => {
                revealObserver.observe(el);
            });
        });

        // Ripple effect for buttons
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-ripple]');
            if (!btn) return;
            const ripple = document.createElement('span');
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${e.clientX - rect.left - size/2}px;
                top: ${e.clientY - rect.top - size/2}px;
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                background-color: rgba(255,255,255,0.3);
                pointer-events: none;
            `;
            btn.style.position = 'relative';
            btn.style.overflow = 'hidden';
            btn.appendChild(ripple);
            ripple.addEventListener('animationend', () => ripple.remove());
        });

        // KPI counter animation
        function animateCounter(el, target, duration = 800) {
            const start = 0;
            const startTime = performance.now();
            const update = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target).toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-counter]').forEach(el => {
                const target = parseInt(el.getAttribute('data-counter'), 10);
                if (!isNaN(target)) {
                    const obs = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) {
                            animateCounter(el, target);
                            obs.unobserve(el);
                        }
                    });
                    obs.observe(el);
                }
            });
        });
    </script>
</body>
</html>