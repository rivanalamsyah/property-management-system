<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kosan">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="manifest" href="/manifest.json">

    <title>{{ config('app.name', 'Kosan') }} — {{ $pageTitle ?? 'Autentikasi' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Outfit', sans-serif; }

        /* Animated gradient mesh for left panel */
        @keyframes mesh-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .brand-panel-bg {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4338ca 50%, #5b21b6 75%, #1e1b4b 100%);
            background-size: 400% 400%;
            animation: mesh-shift 12s ease infinite;
        }

        /* Floating particles on brand panel */
        @keyframes float-up {
            0% { transform: translateY(0) scale(1); opacity: 0.15; }
            50% { opacity: 0.08; }
            100% { transform: translateY(-100vh) scale(0.5); opacity: 0; }
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            animation: float-up linear infinite;
        }
        .particle:nth-child(1) { width: 8px; height: 8px; left: 10%; animation-duration: 14s; animation-delay: 0s; }
        .particle:nth-child(2) { width: 5px; height: 5px; left: 30%; animation-duration: 18s; animation-delay: 3s; }
        .particle:nth-child(3) { width: 12px; height: 12px; left: 55%; animation-duration: 11s; animation-delay: 6s; }
        .particle:nth-child(4) { width: 6px; height: 6px; left: 75%; animation-duration: 16s; animation-delay: 1s; }
        .particle:nth-child(5) { width: 9px; height: 9px; left: 88%; animation-duration: 13s; animation-delay: 8s; }

        /* Smooth form transition */
        @keyframes slide-up-fade {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-card {
            animation: slide-up-fade 0.5s ease-out forwards;
        }

        /* Custom input focus ring */
        .auth-input {
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
            outline: none;
        }

        /* Password strength bar */
        .strength-bar {
            transition: width 0.4s ease, background-color 0.4s ease;
        }
    </style>
</head>
<body class="h-full bg-white text-slate-900 antialiased">

    <div class="min-h-screen flex">

        <!-- ═══════════════════════════════════════════════ -->
        <!-- LEFT PANEL — Brand & Social Proof (Desktop Only) -->
        <!-- ═══════════════════════════════════════════════ -->
        <div class="hidden lg:flex lg:w-[52%] xl:w-[55%] brand-panel-bg relative overflow-hidden flex-col justify-between p-12">
            <!-- Floating particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <!-- Blurred blobs -->
                <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-indigo-400/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-violet-400/15 rounded-full blur-3xl"></div>
            </div>

            <!-- Logo -->
            <a href="{{ route('home') }}" class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('images/logos/logo.png') }}" class="h-10 w-auto" alt="Kosan Logo">
            </a>

            <!-- Center Content -->
            <div class="relative z-10 space-y-10">
                <div class="space-y-4">
                    <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight">
                        Kelola Kos<br>
                        <span class="text-indigo-200">Lebih Cerdas.</span>
                    </h2>
                    <p class="text-indigo-200/80 text-sm leading-relaxed font-medium max-w-xs">
                        Platform manajemen hunian komersial terlengkap untuk pemilik kos modern di Indonesia.
                    </p>
                </div>

                <!-- Feature Bullets -->
                <div class="space-y-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Faktur Otomatis &amp; Penagihan Sewa</h4>
                            <p class="text-xs text-indigo-200/70 mt-0.5 font-medium">Tagihan bulanan terkirim otomatis ke WhatsApp penghuni sebelum jatuh tempo.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Verifikasi Transfer Bank Instan</h4>
                            <p class="text-xs text-indigo-200/70 mt-0.5 font-medium">Cocokkan bukti bayar penghuni tanpa verifikasi manual yang membuang waktu.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="w-8 h-8 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Dasbor Analitik Multi-Properti</h4>
                            <p class="text-xs text-indigo-200/70 mt-0.5 font-medium">Pantau revenue, occupancy, dan arus kas semua cabang dari satu layar.</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial -->
                <div class="p-5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl space-y-3">
                    <p class="text-sm text-white/90 leading-relaxed font-medium italic">
                        "Kosan mengubah cara saya mengelola 48 kamar. Tagihan terbayar tepat waktu meningkat dari 72% menjadi 99% dalam dua bulan pertama."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-400/30 border border-white/20 flex items-center justify-center text-xs font-bold text-white">BP</div>
                        <div>
                            <p class="text-xs font-bold text-white">Budi Prasetyo</p>
                            <p class="text-[10px] text-indigo-200/70">Pemilik Kos Cihampelas — Bandung</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Stat Bar -->
            <div class="relative z-10 flex items-center gap-8">
                <div class="text-center">
                    <p class="text-2xl font-black text-white">1,200+</p>
                    <p class="text-[10px] text-indigo-200/60 font-medium uppercase tracking-wider">Pemilik Kos</p>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="text-center">
                    <p class="text-2xl font-black text-white">48rb+</p>
                    <p class="text-[10px] text-indigo-200/60 font-medium uppercase tracking-wider">Kamar Aktif</p>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div class="text-center">
                    <p class="text-2xl font-black text-white">99.9%</p>
                    <p class="text-[10px] text-indigo-200/60 font-medium uppercase tracking-wider">Uptime SLA</p>
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════ -->
        <!-- RIGHT PANEL — Auth Form                       -->
        <!-- ═══════════════════════════════════════════════ -->
        <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 sm:px-10 lg:px-16 bg-white relative overflow-hidden">
            <!-- Subtle background texture -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(99,102,241,0.04),transparent_50%)] pointer-events-none"></div>

            <!-- Mobile Logo (hidden on desktop) -->
            <div class="lg:hidden mb-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logos/logo.png') }}" class="h-9 w-auto" alt="Kosan Logo">
                </a>
            </div>

            <!-- Form Slot -->
            <div class="w-full max-w-md form-card">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <p class="text-[11px] text-slate-400 font-medium">
                    &copy; {{ date('Y') }} Kosan &bull;
                    <a href="{{ route('privacy') }}" class="hover:text-slate-600 transition">Privasi</a>
                    &bull;
                    <a href="{{ route('terms') }}" class="hover:text-slate-600 transition">Ketentuan</a>
                </p>
            </div>
        </div>

    </div>

    @livewireScripts
</body>
</html>
