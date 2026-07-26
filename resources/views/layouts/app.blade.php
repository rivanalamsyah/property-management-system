<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ sidebarOpen: false }"
      class="h-full bg-slate-50/60">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">

    <!-- PWA Mobile Capabilities -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Kosan">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="manifest" href="/manifest.json">

    <title>{{ config('app.name', 'Kosan') }} - Application Dashboard</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="h-full text-slate-900 antialiased transition-colors duration-300">
    
    <div class="h-screen flex overflow-hidden">
        
        <!-- Sidebar Navigation -->
        <x-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header -->
            <x-header />

            <!-- Main Scrollable Section -->
            <main class="flex-1 overflow-y-auto focus:outline-none bg-slate-50/40 p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-100 py-3.5 px-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} {{ config('app.name', 'Kosan') }} Platform. Seluruh hak cipta dilindungi undang-undang.
            </footer>

        </div>
    </div>

    <!-- Global Toast Notifications -->
    <x-toast />

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
