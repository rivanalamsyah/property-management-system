<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $boardingHouse->name }} - Hunian Kos Nyaman & Strategis</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ Str::limit($boardingHouse->description ?? 'Temukan hunian kos terbaik dengan fasilitas lengkap, bersih, aman, dan harga bersahabat di ' . $boardingHouse->city . '.', 150) }}">
    <meta name="keywords" content="kos, kosan, sewa kos, {{ $boardingHouse->city }}, {{ $boardingHouse->district }}, {{ $boardingHouse->name }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $boardingHouse->name }} - Hunian Kos Nyaman & Strategis">
    <meta property="og:description" content="{{ Str::limit($boardingHouse->description ?? 'Temukan hunian kos terbaik dengan fasilitas lengkap.', 150) }}">
    <meta property="og:image" content="{{ $boardingHouse->cover_image ? asset('storage/' . $boardingHouse->cover_image) : asset('assets/images/property/default_cover.png') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $boardingHouse->name }} - Hunian Kos Nyaman & Strategis">
    <meta property="twitter:description" content="{{ Str::limit($boardingHouse->description ?? 'Temukan hunian kos terbaik dengan fasilitas lengkap.', 150) }}">
    <meta property="twitter:image" content="{{ $boardingHouse->cover_image ? asset('storage/' . $boardingHouse->cover_image) : asset('assets/images/property/default_cover.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite / Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (from CDN if not compiled) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        :root {
            --primary-color: {{ $primaryColor }};
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 leading-relaxed min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    @if($boardingHouse->logo)
                        <img class="h-10 w-10 rounded-xl object-cover border border-slate-200" src="{{ asset('storage/' . $boardingHouse->logo) }}" alt="Logo {{ $boardingHouse->name }}">
                    @else
                        <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ Str::upper(substr($boardingHouse->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 block">{{ $boardingHouse->name }}</span>
                        <span class="text-xs text-slate-500 font-medium block -mt-1">{{ $boardingHouse->district }}, {{ $boardingHouse->city }}</span>
                    </div>
                </div>
                
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Tentang Kami</a>
                    <a href="#rooms" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Kamar</a>
                    <a href="#facilities" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Fasilitas</a>
                    <a href="#rules" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Peraturan</a>
                </nav>

                <div>
                    <a href="https://wa.me/{{ $boardingHouse->whatsapp_number }}?text=Halo%20Admin%20{{ urlencode($boardingHouse->name) }},%20saya%20ingin%20tanya%20mengenai%20kamar%20kos%20yang%20tersedia." 
                       target="_blank"
                       style="background-color: var(--primary-color);" 
                       class="px-5 py-2.5 rounded-xl text-white font-bold text-sm shadow-lg shadow-indigo-500/10 hover:shadow-indigo-500/20 transform hover:-translate-y-0.5 transition flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.625 1.451 5.45.002 9.885-4.417 9.888-9.87.001-2.64-1.026-5.123-2.895-6.993-1.868-1.87-4.35-2.9-6.992-2.902-5.452 0-9.89 4.42-9.893 9.873-.001 1.959.516 3.868 1.5 5.589l-.982 3.585 3.677-.96z"/>
                        </svg>
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-[500px] flex items-center justify-center overflow-hidden bg-slate-900 text-white">
        <!-- Hero Background -->
        <div class="absolute inset-0 z-0">
            @if($boardingHouse->cover_image)
                <img class="w-full h-full object-cover opacity-30" src="{{ asset('storage/' . $boardingHouse->cover_image) }}" alt="Hero Background">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-slate-950 via-slate-900 to-indigo-950 opacity-80"></div>
            @@endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                Tersedia Kamar Siap Huni
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight">
                Hunian Kos Nyaman & Mewah <br class="hidden sm:inline">di <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-indigo-300 to-sky-300">{{ $boardingHouse->name }}</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto font-medium">
                Nikmati kenyamanan tinggal di kos dengan fasilitas terbaik, manajemen yang ramah, dan lokasi strategis.
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="#rooms" 
                   style="background-color: var(--primary-color);"
                   class="px-8 py-4 rounded-xl text-white font-bold shadow-xl shadow-indigo-600/20 hover:scale-[1.02] transition">
                    Lihat Pilihan Kamar
                </a>
                <a href="#about" class="px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold backdrop-blur transition border border-white/10">
                    Pelajari Selengkapnya
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Container -->
    <main class="flex-grow">
        
        <!-- Section: About & Profile -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                            <span style="color: var(--primary-color);" class="text-sm font-bold tracking-widest uppercase">Tentang Properti</span>
                        </div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            Hunian Eksklusif dengan Lingkungan Bersih dan Tenang
                        </h2>
                        <p class="mt-6 text-slate-600 leading-relaxed font-medium">
                            {{ $boardingHouse->description ?? 'Kos ini menawarkan fasilitas lengkap yang dirancang khusus untuk kenyamanan para profesional muda dan mahasiswa. Lokasi strategis memudahkan akses ke berbagai perkantoran, pusat perbelanjaan, dan fasilitas transportasi publik.' }}
                        </p>
                        
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Alamat Lengkap</h4>
                                    <p class="text-slate-500 text-xs mt-0.5">{{ $boardingHouse->address }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Jam Operasional</h4>
                                    <p class="text-slate-500 text-xs mt-0.5">{{ $boardingHouse->operating_hours ?? 'Setiap hari, 24 Jam' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Gallery/Cover Mockup -->
                    <div class="relative">
                        <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-2xl bg-slate-100 border border-slate-200">
                            @if($boardingHouse->cover_image)
                                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $boardingHouse->cover_image) }}" alt="{{ $boardingHouse->name }}">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="absolute -bottom-6 -left-6 bg-white border border-slate-100 rounded-2xl p-4 shadow-xl hidden sm:flex items-center gap-3">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Aman & Terpercaya</h4>
                                <p class="text-slate-500 text-xs">Keamanan 24 Jam & CCTV aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Room Options -->
        <section id="rooms" class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                        <span style="color: var(--primary-color);" class="text-sm font-bold tracking-widest uppercase">Pilihan Kamar</span>
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kamar Kos Yang Tersedia</h2>
                    <p class="mt-4 text-slate-500 font-medium">Silakan pilih jenis kamar yang paling sesuai dengan kebutuhan dan budget Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($boardingHouse->rooms as $room)
                        <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transform transition duration-300 flex flex-col">
                            <!-- Room Header Image Placeholder -->
                            <div class="aspect-video w-full bg-slate-100 relative">
                                @if($room->images && $room->images->count() > 0)
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $room->images->first()->file_path) }}" alt="Kamar {{ $room->room_number }}">
                                @else
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                @endif
                                <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Tersedia
                                </span>
                            </div>

                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-xl font-bold text-slate-900">Kamar {{ $room->room_number }}</h3>
                                        <span class="text-xs font-semibold bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg">Lantai {{ $room->floor }}</span>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium line-clamp-2 mb-4">
                                        Ukuran {{ $room->room_size ?? '3x4' }} m, dilengkapi dengan berbagai perabotan penunjang aktivitas harian.
                                    </p>
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        @foreach($room->facilities as $facility)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold bg-slate-50 text-slate-600 border border-slate-100 px-2 py-0.5 rounded">
                                                {{ $facility->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-slate-50 flex items-center justify-between gap-4">
                                    <div>
                                        <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">Harga Sewa</span>
                                        <span class="text-lg font-extrabold text-indigo-600">Rp{{ number_format($room->monthly_rent, 0, ',', '.') }}<span class="text-xs text-slate-500 font-medium">/bln</span></span>
                                    </div>
                                    <a href="https://wa.me/{{ $boardingHouse->whatsapp_number }}?text=Halo%20Admin%20{{ urlencode($boardingHouse->name) }},%20saya%20tertarik%20untuk%20booking%20Kamar%20{{ $room->room_number }}%20dengan%20harga%20Rp%20{{ number_format($room->monthly_rent, 0, ',', '.') }}%20per%20bulan."
                                       target="_blank"
                                       style="background-color: var(--primary-color);"
                                       class="px-4 py-2 rounded-xl text-white font-bold text-xs hover:scale-105 transition">
                                        Booking Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @forelempty
                        <div class="col-span-full bg-white rounded-2xl border border-slate-100 p-12 text-center">
                            <svg class="w-16 h-16 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="font-bold text-slate-700 mt-4 text-lg">Maaf, Saat Ini Kamar Kos Sedang Penuh</h3>
                            <p class="text-slate-400 text-sm mt-1">Silakan hubungi administrator via WhatsApp untuk dimasukkan ke dalam waiting list.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Section: Facilities -->
        <section id="facilities" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                        <span style="color: var(--primary-color);" class="text-sm font-bold tracking-widest uppercase">Fasilitas Bersama</span>
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kenyamanan Beraktivitas Bersama</h2>
                    <p class="mt-4 text-slate-500 font-medium">Kami menyediakan berbagai fasilitas penunjang di luar kamar untuk digunakan bersama secara bijak.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($boardingHouse->facilities as $facility)
                        <div class="border border-slate-100 rounded-2xl p-6 text-center hover:bg-slate-50 transition">
                            <div class="h-12 w-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 font-bold text-lg">
                                {{ Str::upper(substr($facility->name, 0, 2)) }}
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $facility->name }}</h4>
                            <p class="text-xs text-slate-400 mt-1">{{ $facility->description ?? 'Fasilitas premium bersama' }}</p>
                        </div>
                    @forelempty
                        <div class="col-span-full text-center text-slate-400 font-medium">
                            Tidak ada fasilitas penunjang bersama yang didaftarkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Section: Rules -->
        <section id="rules" class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                        <span style="color: var(--primary-color);" class="text-sm font-bold tracking-widest uppercase">Peraturan Kos</span>
                        <span style="background-color: var(--primary-color);" class="w-8 h-1 rounded-full"></span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Ketentuan & Aturan Tinggal</h2>
                    <p class="mt-4 text-slate-500 font-medium">Aturan yang dibuat bertujuan untuk menjaga ketertiban, kenyamanan, dan kebersamaan seluruh penghuni.</p>
                </div>

                <div class="max-w-4xl mx-auto bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-10">
                    <div class="space-y-6">
                        @forelse($boardingHouse->rules as $rule)
                            <div class="flex items-start gap-4">
                                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg mt-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base">{{ $rule->title }}</h4>
                                    <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $rule->description }}</p>
                                </div>
                            </div>
                        @forelempty
                            <div class="text-center text-slate-400 font-medium">
                                Tidak ada peraturan khusus yang ditampilkan secara publik.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b border-slate-800 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-lg font-bold">{{ $boardingHouse->name }}</h3>
                    <p class="text-xs text-slate-400 mt-2 max-w-sm">Mewujudkan hunian kos modern dengan sistem pengelolaan berbasis platform teknologi terbaik.</p>
                </div>
                <div class="flex justify-start md:justify-end gap-6 text-slate-400">
                    @if($instagram)
                        <a href="https://instagram.com/{{ $instagram }}" target="_blank" class="hover:text-white transition">Instagram</a>
                    @endif
                    @if($facebook)
                        <a href="https://facebook.com/{{ $facebook }}" target="_blank" class="hover:text-white transition">Facebook</a>
                    @endif
                    <a href="https://wa.me/{{ $boardingHouse->whatsapp_number }}" target="_blank" class="hover:text-white transition">WhatsApp Contact</a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 text-center text-xs text-slate-500 font-medium">
            <p>&copy; {{ date('Y') }} {{ $boardingHouse->name }}. Dikelola menggunakan platform SaaS Kosan.</p>
        </div>
    </footer>

</body>
</html>
