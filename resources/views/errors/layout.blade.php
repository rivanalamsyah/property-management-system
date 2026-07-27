<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Terjadi Kesalahan') — Kosan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.12); opacity: 0.15; }
            100% { transform: scale(1); opacity: 0.4; }
        }
        .pulse-ring { animation: pulse-ring 3s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 text-slate-900 antialiased flex flex-col">

    <!-- Top Nav Bar -->
    <nav class="px-6 py-5 flex justify-between items-center max-w-6xl mx-auto w-full">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/25 transition-transform group-hover:scale-105">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-lg font-black text-slate-900 tracking-tight">Kosan<span class="text-indigo-600">.</span></span>
        </a>
        <a href="{{ url('/') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700 transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col justify-center items-center px-6 py-16 relative overflow-hidden">
        <!-- Ambient blobs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/6 w-80 h-80 bg-indigo-400/6 rounded-full blur-3xl pulse-ring"></div>
            <div class="absolute bottom-1/4 right-1/6 w-96 h-96 bg-rose-400/5 rounded-full blur-3xl pulse-ring" style="animation-delay: 1.5s;"></div>
        </div>

        <div class="relative max-w-lg w-full text-center space-y-8">
            <!-- Illustration slot -->
            @yield('illustration')

            <!-- Error code -->
            <div class="space-y-3">
                <div class="text-8xl font-black tracking-tighter bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-600 bg-clip-text text-transparent leading-none">
                    @yield('code')
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">@yield('message')</h1>
                <p class="text-sm text-slate-500 leading-relaxed font-medium max-w-sm mx-auto">@yield('description')</p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 rounded-2xl shadow-lg shadow-indigo-500/25 transition duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Kembali ke Beranda
                </a>
                @yield('extra_action')
            </div>

            <!-- Status code badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200/80 rounded-full text-[10px] font-bold text-slate-500 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                HTTP @yield('code') Error
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-5 text-center">
        <p class="text-[11px] text-slate-400 font-medium">&copy; {{ date('Y') }} Kosan &bull; Sistem Manajemen Hunian Modern</p>
    </footer>

</body>
</html>
