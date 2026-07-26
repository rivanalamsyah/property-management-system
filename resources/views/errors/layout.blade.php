<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Kosan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased h-screen flex flex-col justify-center items-center p-6 transition-colors duration-300">
    <div class="relative max-w-md w-full text-center space-y-6">
        <!-- Glows -->
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="text-7xl font-extrabold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">
            @yield('code')
        </div>
        
        <div class="space-y-2">
            <h1 class="text-xl font-bold tracking-tight text-slate-900">@yield('message')</h1>
            <p class="text-sm text-slate-500 leading-relaxed">@yield('description')</p>
        </div>

        <div class="pt-4">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition cursor-pointer">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
