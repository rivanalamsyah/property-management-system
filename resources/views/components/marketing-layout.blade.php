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
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

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

    <!-- Floating Island Glassmorphism Header with Glowing Animated Border -->
    <header class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-2rem)] max-w-5xl transition-all duration-300">
        <!-- The Animated Border wrapper -->
        <div class="relative p-[1.5px] overflow-hidden rounded-2xl shadow-xl shadow-indigo-950/[0.03]">
            <!-- Rotating Conic Border Glow Line -->
            <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,transparent_0%,transparent_35%,#6366f1_45%,#a855f7_50%,#6366f1_55%,transparent_65%,transparent_100%)] animate-[spin_6s_linear_infinite] pointer-events-none"></div>

            <!-- Glassmorphic content mask -->
            <div class="relative bg-white/75 backdrop-blur-xl rounded-[15px] px-6 h-16 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group transition duration-200">
                    <img src="{{ asset('images/logos/logo.png') }}" class="h-8 w-auto group-hover:scale-102 active:scale-98 transition-all" alt="Kosan Logo">
                </a>

                <!-- Desktop Menu with Modern Pills styling -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/50 p-1 rounded-xl border border-slate-200/10">
                    <a href="{{ route('home') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ request()->routeIs('home') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Beranda</a>
                    <a href="{{ route('features') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ request()->routeIs('features') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Fitur</a>
                    <a href="{{ route('pricing') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ request()->routeIs('pricing') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Harga</a>
                    <a href="{{ route('blog.index') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ (request()->routeIs('blog.index') || request()->routeIs('blog.detail') || request()->routeIs('resources')) ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Blog</a>
                    <a href="{{ route('about') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ request()->routeIs('about') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Tentang</a>
                    <a href="{{ route('contact') }}" class="text-xs font-bold px-3.5 py-1.5 rounded-lg transition-all {{ request()->routeIs('contact') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-650 hover:text-slate-900' }}">Kontak</a>
                </nav>

                <!-- Actions (CTAs) -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-indigo-605 hover:text-indigo-800 transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-slate-655 hover:text-rose-600 cursor-pointer bg-transparent border-0 transition">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-650 hover:text-slate-950 transition">Masuk</a>
                        <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('register') }}'" class="text-xs font-bold py-2 px-4 shadow-sm shadow-indigo-500/10">
                            Coba Gratis
                        </x-button>
                    @endauth
                </div>

                <!-- Mobile Hamburger -->
                <div class="flex items-center gap-3 md:hidden">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 text-slate-500 hover:text-slate-900 cursor-pointer rounded-xl hover:bg-slate-100/50 transition" aria-label="Toggle Navigation Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu Panel inside the island card! -->
            <div x-show="mobileMenu" @click.away="mobileMenu = false" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="md:hidden bg-white/95 backdrop-blur-xl border-t border-slate-100 px-6 py-4 space-y-4 rounded-b-[15px]">
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition">Beranda</a>
                    <a href="{{ route('features') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition">Fitur</a>
                    <a href="{{ route('pricing') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition">Harga</a>
                    <a href="{{ route('blog.index') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold {{ (request()->routeIs('blog.index') || request()->routeIs('blog.detail') || request()->routeIs('resources')) ? 'bg-slate-50 text-indigo-600' : 'text-slate-650 hover:bg-slate-50' }} transition">Panduan &amp; Blog</a>
                    <a href="{{ route('about') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="block py-2.5 px-4 rounded-xl text-xs font-bold text-slate-650 hover:bg-slate-50 transition">Kontak</a>
                </nav>
                <div class="border-t border-slate-100 pt-4 flex flex-col gap-2.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block text-center py-2.5 text-xs font-bold text-indigo-600 hover:bg-slate-50 rounded-xl transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-center py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer bg-transparent border-0">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-center py-2.5 text-xs font-bold text-slate-650 hover:bg-slate-50 rounded-xl transition">Masuk</a>
                        <x-button variant="primary" class="w-full text-center py-3 text-xs font-bold" onclick="window.location.href='{{ route('register') }}'">
                            Coba Gratis 14 Hari
                        </x-button>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main View Content Slot -->
    <main class="pt-24 md:pt-28">
        {{ $slot }}
    </main>

    <!-- Global Floating WhatsApp Bubble -->
    <a href="https://wa.me/{{ $globals['whatsapp'] ?? '6281234567890' }}" target="_blank" 
       class="fixed bottom-6 right-6 z-40 w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white shadow-xl hover:bg-emerald-600 hover:scale-110 active:scale-95 transition duration-200" 
       aria-label="Hubungi Kami via WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
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
    <footer class="bg-slate-50/70 border-t border-slate-200/60 pt-20 pb-12 px-6 transition-colors relative overflow-hidden">
        <!-- Background light glows -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(99,102,241,0.04),transparent_35%)] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto space-y-16 relative z-10">
            <!-- Top Section: Brand Info & Newsletter Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center pb-12 border-b border-slate-200/50">
                <!-- Left: Branding & Pitch -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/logos/logo.png') }}" class="h-9 w-auto" alt="Kosan Logo">
                    </div>
                    
                    <p class="text-sm text-slate-500 leading-relaxed max-w-xl">
                        Sistem Operasi Operasional Bisnis Kos Multi-Tenant nomor satu di Indonesia. Kami mengotomatisasi penagihan sewa, rekonsiliasi bukti bayar bank, pengelolaan kontrak digital, serta keluhan penghuni.
                    </p>

                    <!-- Realtime Status Indicators & Trust badging -->
                    <div class="flex flex-wrap gap-3.5 items-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[10px] font-bold shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Seluruh Sistem Normal
                        </div>
                        <div class="text-[10px] text-slate-400 font-semibold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 inline-block" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>SSL Encrypted &bull; UU PDP Compliant</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Glassmorphic Newsletter Box -->
                <div class="lg:col-span-5 bg-white border border-slate-200/80 p-6 rounded-3xl shadow-xs space-y-4">
                    <div class="space-y-1">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Buletin Bisnis Kos</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Dapatkan tips taktis pengelolaan kos dan info pembaruan produk.</p>
                    </div>
                    
                    <form class="flex gap-2" onsubmit="event.preventDefault(); alert('Terima kasih! Anda telah terdaftar dalam buletin kami.');">
                        <input type="email" placeholder="pemilik@kosan.com" required 
                               class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200" />
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white rounded-xl text-xs font-bold cursor-pointer transition duration-200 shadow-sm shadow-indigo-500/10">
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Middle Section: Detailed Columns Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Col 1: Produk -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Produk</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Fitur Lengkap OS</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Daftar Paket &amp; Harga</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Panduan Dasbor Owner</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Portal PWA Penghuni</a></li>
                    </ul>
                </div>

                <!-- Col 2: Solusi Fitur -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Solusi Pintar</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Otomatisasi Tagihan Sewa</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Verifikasi Rekening Otomatis</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Pemantauan Kontrak Aktif</a></li>
                        <li><a href="{{ route('features') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Manajemen Komplain Kerusakan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Resources & Guides -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Pusat Informasi</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('blog.index') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Artikel &amp; Panduan Bisnis</a></li>
                        <li><a href="{{ route('blog.index', ['category' => 'studi-kasus']) }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Studi Kasus Sukses Mitra</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Kalkulator Penghematan ROI</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Pusat Bantuan Teknis</a></li>
                    </ul>
                </div>

                <!-- Col 4: Hubungi Kami & Medsos -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-widest">Tim &amp; Hubungan</h4>
                    <ul class="space-y-2.5 text-xs text-slate-500 font-medium">
                        <li><a href="{{ route('about') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Tentang Pengembang</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Jadwalkan Sesi Demo</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 hover:translate-x-0.5 transition duration-150 inline-block">Hubungi Customer Service</a></li>
                    </ul>
                    <div class="flex gap-3 text-slate-400 pt-1">
                        <!-- Twitter -->
                        <a href="#" class="hover:text-indigo-600 transition" aria-label="Twitter Kosan"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg></a>
                        <!-- GitHub -->
                        <a href="#" class="hover:text-slate-900 transition" aria-label="GitHub Repository Kosan"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg></a>
                    </div>
                </div>
            </div>

            <!-- Bottom Section: Legal & Copyright -->
            <div class="border-t border-slate-200/50 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>{{ $globals['copyright'] ?? '© 2026 Kosan Platform. Seluruh hak cipta dilindungi undang-undang.' }}</p>
                <div class="flex flex-wrap justify-center gap-5">
                    <a href="{{ route('privacy') }}" class="hover:text-indigo-600 transition">Kebijakan Privasi</a>
                    <a href="{{ route('terms') }}" class="hover:text-indigo-600 transition">Syarat &amp; Ketentuan</a>
                    <a href="{{ route('about') }}" class="hover:text-indigo-600 transition">Keamanan Data</a>
                </div>
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

    <!-- UTM Link Auto-Append Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
            const activeUtms = {};
            
            utmKeys.forEach(key => {
                if (urlParams.has(key)) {
                    activeUtms[key] = urlParams.get(key);
                }
            });

            if (Object.keys(activeUtms).length > 0) {
                // Find all links containing register or trial
                document.querySelectorAll('a, button[onclick]').forEach(element => {
                    let urlStr = '';
                    if (element.tagName === 'A') {
                        urlStr = element.getAttribute('href');
                    } else if (element.hasAttribute('onclick')) {
                        const match = element.getAttribute('onclick').match(/window\.location\.href='([^']+)'/);
                        if (match) urlStr = match[1];
                    }

                    if (urlStr && urlStr.includes('/register')) {
                        try {
                            const url = new URL(urlStr, window.location.origin);
                            Object.keys(activeUtms).forEach(key => {
                                url.searchParams.set(key, activeUtms[key]);
                            });
                            if (element.tagName === 'A') {
                                element.setAttribute('href', url.toString());
                            } else {
                                element.setAttribute('onclick', `window.location.href='${url.toString()}'`);
                            }
                        } catch (e) {
                            console.error('Failed to append UTMs', e);
                        }
                    }
                });
            }
        });
    </script>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
