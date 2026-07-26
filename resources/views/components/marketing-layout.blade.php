@props(['meta_title', 'meta_description', 'canonical', 'globals' => []])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ mobileMenu: false, cookieAccepted: localStorage.getItem('cookieConsent') !== null }"
      class="scroll-smooth h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">

    <title>{{ $meta_title ?? 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart' }}</title>
    <meta name="description" content="{{ $meta_description ?? 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).' }}">
    
    @if(isset($canonical))
        <link rel="canonical" href="{{ $canonical }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonical ?? request()->url() }}">
    <meta property="og:title" content="{{ $meta_title ?? 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart' }}">
    <meta property="og:description" content="{{ $meta_description ?? 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).' }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $canonical ?? request()->url() }}">
    <meta property="twitter:title" content="{{ $meta_title ?? 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart' }}">
    <meta property="twitter:description" content="{{ $meta_description ?? 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).' }}">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Structured Data Organization Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "Kosan",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('icons/icon-192x192.png') }}",
      "sameAs": [
        "https://twitter.com/kosanhq",
        "https://github.com/rivanalamsyah/kosan"
      ],
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+62-812-3456-7890",
        "contactType": "customer support",
        "availableLanguage": ["Indonesian", "English"]
      }
    }
    </script>

    @stack('schema')

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="text-slate-900 antialiased transition-colors duration-300">

    <!-- Sticky Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 transition-colors">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Kosan.</span>
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium transition {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('features') }}" class="text-sm font-medium transition {{ request()->routeIs('features') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Fitur</a>
                <a href="{{ route('pricing') }}" class="text-sm font-medium transition {{ request()->routeIs('pricing') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Harga</a>
                <a href="{{ route('resources') }}" class="text-sm font-medium transition {{ request()->routeIs('resources') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Panduan &amp; Blog</a>
                <a href="{{ route('about') }}" class="text-sm font-medium transition {{ request()->routeIs('about') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium transition {{ request()->routeIs('contact') ? 'text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Kontak</a>
            </nav>

            <!-- Actions (CTAs) -->
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition">Masuk</a>
                <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
                </x-button>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center gap-3 md:hidden">
                <button @click="mobileMenu = !mobileMenu" class="p-2 text-slate-500 hover:text-slate-900 cursor-pointer" aria-label="Toggle Navigation Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenu" @click.away="mobileMenu = false" x-transition class="md:hidden border-b border-slate-100 bg-white px-6 py-4 space-y-4">
            <nav class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-650">Beranda</a>
                <a href="{{ route('features') }}" class="text-sm font-semibold text-slate-650">Fitur</a>
                <a href="{{ route('pricing') }}" class="text-sm font-semibold text-slate-650">Harga</a>
                <a href="{{ route('resources') }}" class="text-sm font-semibold text-slate-650">Panduan &amp; Blog</a>
                <a href="{{ route('about') }}" class="text-sm font-semibold text-slate-650">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="text-sm font-semibold text-slate-650">Kontak</a>
            </nav>
            <div class="border-t border-slate-100 pt-4 flex flex-col gap-2.5">
                <a href="{{ route('login') }}" class="text-center py-2 text-sm font-semibold text-slate-650">Masuk</a>
                <x-button variant="primary" class="w-full text-center" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
                </x-button>
            </div>
        </div>
    </header>

    <!-- Main View Content Slot -->
    <main>
        {{ $slot }}
    </main>

    <!-- Global Floating WhatsApp Bubble -->
    <a href="https://wa.me/{{ $globals['whatsapp'] ?? '6281234567890' }}" target="_blank" 
       class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-xl hover:bg-emerald-600 hover:scale-110 active:scale-95 transition duration-200" 
       aria-label="Hubungi Kami via WhatsApp">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.262 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.731-1.456L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.743.003-2.602-1.012-5.05-2.859-6.898C16.63 2.115 14.183 1.1 11.582 1.1 6.148 1.1 1.72 5.47 1.716 10.843c-.001 1.64.453 3.24 1.314 4.678L2.006 20.9l5.097-1.336z"/>
        </svg>
        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-rose-500 border border-white rounded-full"></span>
    </a>

    <!-- Global Back To Top Button -->
    <div x-data="{ show: false }" 
         x-init="window.addEventListener('scroll', () => { show = window.scrollY > 400 })"
         x-show="show" 
         x-transition
         class="fixed bottom-22 right-6 z-40">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="w-10 h-10 bg-white border border-slate-100 rounded-full flex items-center justify-center text-slate-500 hover:text-slate-800 shadow-lg cursor-pointer hover:-translate-y-1 transition duration-200" 
                aria-label="Kembali ke Atas">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
        </button>
    </div>

    <!-- Mega Footer -->
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8 px-6 transition-colors">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-10">
            <!-- Brand Column -->
            <div class="space-y-4 md:col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">Kosan.</span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed max-w-sm">
                    Kosan adalah platform SaaS manajemen properti dan kos-kosan berbasis multi-tenant yang membantu pemilik mengotomatisasi penagihan sewa, verifikasi bukti transfer otomatis, dan pengelolaan properti secara efisien.
                </p>
                <div class="flex gap-3 text-slate-400 pt-2">
                    <!-- Twitter -->
                    <a href="#" class="hover:text-indigo-600 transition" aria-label="Twitter Kosan"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                    <!-- GitHub -->
                    <a href="#" class="hover:text-slate-900 transition" aria-label="GitHub Repository Kosan"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg></a>
                </div>
            </div>

            <!-- Col 2: Product -->
            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-4">Produk</h4>
                <ul class="space-y-2 text-sm text-slate-550">
                    <li><a href="{{ route('features') }}" class="hover:text-indigo-600 transition">Fitur Lengkap</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition">Paket &amp; Harga</a></li>
                    <li><a href="{{ route('features') }}" class="hover:text-indigo-600 transition">Panduan Dashboard</a></li>
                    <li><a href="{{ route('features') }}" class="hover:text-indigo-600 transition">Portal Penghuni (PWA)</a></li>
                </ul>
            </div>

            <!-- Col 3: Resources -->
            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-4">Panduan &amp; Blog</h4>
                <ul class="space-y-2 text-sm text-slate-550">
                    <li><a href="{{ route('resources') }}" class="hover:text-indigo-600 transition">Artikel &amp; Tips Kos</a></li>
                    <li><a href="{{ route('resources') }}" class="hover:text-indigo-600 transition">Dokumentasi Sistem</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition">Pusat Bantuan</a></li>
                    <li><a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition">Kalkulator ROI Kos</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Buletin Bisnis Kos</h4>
                <p class="text-xs text-slate-500">Dapatkan tips pengelolaan bisnis kos dan update fitur terbaru langsung di email Anda. Bebas spam.</p>
                <form class="flex gap-2" onsubmit="event.preventDefault(); alert('Terima kasih! Anda telah terdaftar dalam buletin kami.');">
                    <input type="email" placeholder="pemilik@kosan.com" required 
                           class="flex-1 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" />
                    <button type="submit" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto border-t border-slate-100 mt-16 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <p>{{ $globals['copyright'] ?? '© 2026 Kosan Platform. Seluruh hak cipta dilindungi undang-undang.' }}</p>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-indigo-600">Kebijakan Privasi</a>
                <a href="{{ route('terms') }}" class="hover:text-indigo-600">Syarat &amp; Ketentuan</a>
                <a href="{{ route('about') }}" class="hover:text-indigo-600">Keamanan Data</a>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent Popup Banner -->
    <div x-show="!cookieAccepted" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-6 left-6 z-50 max-w-sm p-5 bg-white border border-slate-100 rounded-3xl shadow-2xl">
        <h4 class="text-sm font-bold text-slate-900 mb-1.5">Pengaturan Persetujuan Cookie</h4>
        <p class="text-xs text-slate-550 leading-relaxed mb-4">
            Kami menggunakan cookie untuk mengoptimalkan pengalaman pengguna, menganalisis lalu lintas platform, dan menyimpan preferensi pengaturan Anda.
        </p>
        <div class="flex gap-2">
            <button @click="localStorage.setItem('cookieConsent', 'true'); cookieAccepted = true" 
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold cursor-pointer flex-1">
                Setuju Semua
            </button>
            <button @click="cookieAccepted = true" 
                    class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-xs font-medium cursor-pointer">
                Tolak
            </button>
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
