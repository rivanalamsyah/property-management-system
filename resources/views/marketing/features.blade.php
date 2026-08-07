<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- JSON-LD Breadcrumbs Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [{
        "@@type": "ListItem",
        "position": 1,
        "name": "Beranda",
        "item": "{{ route('home') }}"
      },{
        "@@type": "ListItem",
        "position": 2,
        "name": "Fitur",
        "item": "{{ route('features') }}"
      }]
    }
    </script>
    @endpush

    <!-- Custom Modern Styling for Features Page -->
    <style>
        .glow-indigo {
            background-image: radial-gradient(circle at top right, rgba(99, 102, 241, 0.08), transparent 60%);
        }
        .glow-purple {
            background-image: radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.08), transparent 60%);
        }
        .glow-emerald {
            background-image: radial-gradient(circle at center, rgba(16, 185, 129, 0.05), transparent 50%);
        }
        @keyframes subtlePulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .dot-pulse {
            animation: subtlePulse 2s infinite ease-in-out;
        }
        .perspective-1000 {
            perspective: 1000px;
        }
        .rotate-y-12 {
            transform: rotateY(-12deg) rotateX(8deg);
        }
    </style>

    <!-- SECTION 1: HERO SECTION -->
    <section class="relative overflow-hidden pt-28 pb-20 lg:pt-36 lg:pb-32 bg-slate-50/40 border-b border-slate-200/50 glow-indigo">
        <!-- Ambient mesh blurs -->
        <div class="absolute top-10 left-1/3 w-[450px] h-[450px] bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-1/4 w-[400px] h-[400px] bg-purple-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-6 text-center space-y-8 relative z-10">
            <!-- Feature Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 border border-indigo-100/80 text-indigo-700 shadow-2xs mx-auto">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-650 animate-ping"></span>
                <span>Fitur Lengkap Kosan SaaS v2.4</span>
            </div>
            
            <!-- Headline & Subheadline -->
            <div class="max-w-4xl mx-auto space-y-4">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.1]">
                    Sistem Operasi Kos Modern untuk <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Mengotomatiskan & Melipatgandakan Efisiensi</span>
                </h1>
                <p class="text-slate-500 text-sm sm:text-base md:text-lg max-w-2xl mx-auto leading-relaxed font-medium">
                    Gantikan proses manual yang melelahkan. Kelola hunian, tagihan bulanan, mutasi bank, dan laporan komplain dalam satu dashboard terintegrasi yang hemat waktu dan bebas stres.
                </p>
            </div>

            <!-- Action Buttons & Trust Indicators -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 max-w-md mx-auto">
                    <x-button variant="primary" size="lg" class="w-full sm:w-auto text-center font-bold px-8 py-4 shadow-md shadow-indigo-500/20 cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                        Coba Gratis 14 Hari
                    </x-button>
                    <x-button variant="outline" size="lg" class="w-full sm:w-auto text-center font-bold bg-white px-8 py-4 border border-slate-200/80 hover:bg-slate-50 cursor-pointer !text-slate-800 hover:!text-slate-950 flex items-center gap-2" onclick="window.location.href='{{ route('contact') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                        </svg>
                        Jadwalkan Demo
                    </x-button>
                </div>
                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center gap-6 text-[11px] font-bold text-slate-400 tracking-wide uppercase pt-2">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span>Tanpa Kartu Kredit</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span>Aktif dalam 2 Menit</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span>Dukungan CS Prioritas</span>
                    </div>
                </div>
            </div>

            <!-- Hero Interactive Dashboard Mockup (Browser Frame UI) -->
            <div class="max-w-5xl mx-auto pt-8 select-none" x-data="{
                activeFeed: 0,
                feeds: [
                    { msg: 'Kamar 102: Pembayaran sewa Rp 1.800.000 terverifikasi otomatis.', type: 'lunas', time: 'Baru saja' },
                    { msg: 'Kamar 204: Mengajukan komplain AC tidak dingin.', type: 'komplain', time: '2 menit lalu' },
                    { msg: 'Kamar 301: Dokumen kontrak digital ditandatangani.', type: 'kontrak', time: '10 menit lalu' },
                    { msg: 'Budi Santoso (Kamar 105) telah berhasil Check-In.', type: 'checkin', time: '1 jam lalu' }
                ]
            }" x-init="setInterval(() => { activeFeed = (activeFeed + 1) % feeds.length }, 4000)">
                <div class="bg-white border border-slate-200/90 rounded-2xl shadow-2xl overflow-hidden text-left flex flex-col h-[480px]">
                    <!-- Window Top bar -->
                    <div class="bg-slate-50 border-b border-slate-200/60 px-4 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        </div>
                        <div class="bg-slate-200/60 text-slate-500 text-[10px] font-bold px-8 py-1 rounded-md max-w-xs truncate font-mono">
                            https://app.kosan.io/dashboard
                        </div>
                        <div class="w-8"></div>
                    </div>
                    
                    <!-- Dashboard Body -->
                    <div class="flex-1 flex overflow-hidden">
                        <!-- Sidebar Sim -->
                        <div class="w-48 bg-slate-900 text-slate-400 p-4 hidden md:flex flex-col justify-between">
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 px-2">
                                    <span class="w-6 h-6 rounded-lg bg-indigo-650 flex items-center justify-center text-white font-black text-xs">K</span>
                                    <span class="text-xs font-black text-white uppercase tracking-wider">Kosan OS</span>
                                </div>
                                <nav class="space-y-1">
                                    <div class="flex items-center gap-2.5 px-3 py-2 bg-indigo-600/10 text-indigo-400 rounded-lg text-xs font-bold border-l-2 border-indigo-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                                        <span>Dashboard</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 px-3 py-2 hover:bg-slate-800 hover:text-slate-200 transition rounded-lg text-xs font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        <span>Properti</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 px-3 py-2 hover:bg-slate-800 hover:text-slate-200 transition rounded-lg text-xs font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        <span>Penghuni</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 px-3 py-2 hover:bg-slate-800 hover:text-slate-200 transition rounded-lg text-xs font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        <span>Penagihan</span>
                                    </div>
                                </nav>
                            </div>
                            <div class="text-[10px] text-slate-500 font-bold font-mono">v2.4 Production</div>
                        </div>
                        
                        <!-- Content Area Sim -->
                        <div class="flex-1 bg-slate-50 p-6 overflow-y-auto space-y-6">
                            <!-- Stats Overview Row -->
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="bg-white p-4 border border-slate-200/60 rounded-xl shadow-2xs space-y-1">
                                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Okupansi Kamar</span>
                                    <h4 class="text-lg font-black text-slate-800">94.8%</h4>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-indigo-650 h-full rounded-full" style="width: 94%"></div>
                                    </div>
                                </div>
                                <div class="bg-white p-4 border border-slate-200/60 rounded-xl shadow-2xs space-y-1">
                                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Kas Masuk (Bulan Ini)</span>
                                    <h4 class="text-lg font-black text-emerald-600">Rp 48.5M</h4>
                                    <span class="text-[8px] font-bold text-emerald-600 block">+15.2% vs bln lalu</span>
                                </div>
                                <div class="bg-white p-4 border border-slate-200/60 rounded-xl shadow-2xs space-y-1">
                                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Tagihan Terkirim</span>
                                    <h4 class="text-lg font-black text-indigo-600">100%</h4>
                                    <span class="text-[8px] font-bold text-indigo-600 block">WhatsApp Otomatis</span>
                                </div>
                                <div class="bg-white p-4 border border-slate-200/60 rounded-xl shadow-2xs space-y-1">
                                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Komplain Selesai</span>
                                    <h4 class="text-lg font-black text-indigo-750">12 / 12</h4>
                                    <span class="text-[8px] font-bold text-slate-400 block">Teknisi Responsif</span>
                                </div>
                            </div>
                            
                            <!-- Middle Section: Graph and Live Feed -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                                <!-- Mini Graph -->
                                <div class="lg:col-span-7 bg-white p-5 border border-slate-200/60 rounded-xl shadow-2xs space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">Tren Pendapatan Operasional</span>
                                        <span class="text-[9px] px-2.5 py-0.5 rounded-full font-bold bg-indigo-50 text-indigo-600">6 Bulan Terakhir</span>
                                    </div>
                                    <div class="h-28 flex items-end justify-between border-b border-slate-100 pb-2">
                                        <!-- Custom inline SVG Chart lines -->
                                        <div class="w-8 bg-indigo-100 rounded-t-sm h-[30%]"></div>
                                        <div class="w-8 bg-indigo-200 rounded-t-sm h-[45%]"></div>
                                        <div class="w-8 bg-indigo-300 rounded-t-sm h-[60%]"></div>
                                        <div class="w-8 bg-indigo-400 rounded-t-sm h-[75%]"></div>
                                        <div class="w-8 bg-indigo-550 rounded-t-sm h-[85%]"></div>
                                        <div class="w-8 bg-indigo-650 rounded-t-sm h-[98%]"></div>
                                    </div>
                                    <div class="flex justify-between text-[8px] font-extrabold text-slate-400 font-mono">
                                        <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
                                    </div>
                                </div>
                                
                                <!-- Live Updates Feed -->
                                <div class="lg:col-span-5 bg-white p-5 border border-slate-200/60 rounded-xl shadow-2xs flex flex-col justify-between min-h-[160px]">
                                    <div class="border-b border-slate-100 pb-2 flex items-center justify-between">
                                        <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">Aktivitas Real-time</span>
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 dot-pulse"></span>
                                    </div>
                                    
                                    <!-- Animated list item based on state -->
                                    <div class="flex-1 flex items-center justify-center py-4">
                                        <template x-for="(feed, index) in feeds" :key="index">
                                            <div x-show="activeFeed === index" x-transition:enter="transition ease-out duration-300 transform translate-y-2 opacity-0" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform -translate-y-2 opacity-0" class="w-full flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                                     :class="{
                                                        'bg-emerald-50 text-emerald-600': feed.type === 'lunas' || feed.type === 'checkin',
                                                        'bg-rose-50 text-rose-600': feed.type === 'komplain',
                                                        'bg-indigo-50 text-indigo-600': feed.type === 'kontrak'
                                                     }">
                                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" x-show="feed.type === 'lunas'" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" x-show="feed.type === 'komplain'" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" x-show="feed.type === 'kontrak'" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" x-show="feed.type === 'checkin'" />
                                                    </svg>
                                                </div>
                                                <div class="text-left space-y-0.5">
                                                    <p class="text-xs font-bold text-slate-800" x-text="feed.msg"></p>
                                                    <span class="text-[9px] text-slate-400 font-semibold" x-text="feed.time"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: RINGKASAN FITUR -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            <!-- Headers -->
            <div class="max-w-3xl mx-auto text-center space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Alur Kerja yang Disederhanakan</h2>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Satu Platform, Segala Kemudahan Pengelolaan Properti Kos
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xl mx-auto font-medium">
                    Kosan mengintegrasikan 10 modul canggih yang saling terhubung untuk mengotomatisasi pekerjaan administrasi harian dan mengeliminasi kesalahan manusia.
                </p>
            </div>

            <!-- Grid Fitur -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Struktur Multi Properti</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Kelola kamar, gedung, blok, dan fasilitas umum di berbagai lokasi berbeda dari satu antarmuka dashboard tunggal yang ringkas.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Otomatisasi Tagihan</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Sistem menerbitkan tagihan secara berkala, menghitung akumulasi biaya tambahan, dan mengirimkannya ke WhatsApp penghuni tepat waktu.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Rekonsiliasi Bank Otomatis</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Verifikasi bukti transfer digital secara cerdas untuk meminimalkan kecurangan manipulasi nota transfer dan mempercepat verifikasi pembukuan.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Manajemen Pemeliharaan</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Sistem tiket terpusat bagi penghuni untuk melaporkan kerusakan unit. Hubungkan langsung dengan staf teknisi terdaftar.
                        </p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Analisis Keuangan Mendalam</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Dapatkan visualisasi analitik okupansi, laporan laba rugi, dan data cash flow harian secara otomatis tanpa kalkulasi spreadsheet manual.
                        </p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="bg-slate-50 border border-slate-200/50 p-6 rounded-2xl shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300 space-y-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-base font-bold text-slate-900">Portal PWA Mandiri</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Penghuni dapat memantau kontrak, riwayat bayar, mengunggah bukti transfer, dan melakukan pengaduan langsung dari layar ponsel tanpa unduh aplikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: DASHBOARD OPERASIONAL -->
    <section class="py-24 bg-slate-50/40 border-y border-slate-250/10 glow-purple">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left Side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Pusat Komando Bisnis
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Pantau Seluruh Metrik Operasional dari Satu Layar Utama
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Lupakan kebingungan mencocokkan puluhan lembar catatan. Dashboard Kosan dirancang secara intuitif untuk membantu Anda melacak performa finansial, okupansi aktif, pembayaran yang tertunda, dan notifikasi aktivitas terbaru secara real-time.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>KPI penting (Okupansi, Keuangan, Kas Masuk) instan</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Notifikasi aktivitas terbaru secara langsung</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Tampilan grafik interaktif pertumbuhan bisnis bulanan</span>
                    </li>
                </ul>
            </div>

            <!-- Right Side Dashboard Visual Mockup -->
            <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-xl space-y-6 relative overflow-hidden">
                <!-- Ambient Backlight -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-purple-500/10 rounded-full blur-2xl"></div>
                
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800">Dashboard Utama</h4>
                        <p class="text-[9px] text-slate-400 font-semibold">Gedung Utama Dago &bull; Periode Juli 2026</p>
                    </div>
                    <span class="px-2.5 py-1 text-[9px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-100/60 rounded-md">Live Update</span>
                </div>
                
                <!-- Inner Stats Grid -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-[8px] uppercase font-bold text-slate-400 block">Total Hunian</span>
                        <div class="text-sm font-black text-slate-800">42 / 45 <span class="text-[9px] text-emerald-500 font-bold ml-1">93.3%</span></div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-[8px] uppercase font-bold text-slate-400 block">Pelunasan Sewa</span>
                        <div class="text-sm font-black text-slate-800">38 Unit <span class="text-[9px] text-indigo-500 font-bold ml-1">Lunas</span></div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <span class="text-[8px] uppercase font-bold text-slate-400 block">Komplain Terbuka</span>
                        <div class="text-sm font-black text-slate-800">0 Tiket <span class="text-[9px] text-slate-400 font-bold ml-1">Bersih</span></div>
                    </div>
                </div>

                <!-- Simple Table Mock -->
                <div class="space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-slate-455 tracking-wider">Aktivitas Terakhir Properti</span>
                    <div class="border border-slate-150 rounded-lg overflow-hidden text-xs">
                        <div class="bg-slate-50/60 px-3 py-2 border-b border-slate-150 flex justify-between text-[9px] font-extrabold text-slate-455">
                            <span>AKTIVITAS</span>
                            <span>STATUS</span>
                        </div>
                        <div class="px-3 py-2 border-b border-slate-100 flex justify-between items-center bg-white">
                            <span class="font-bold text-slate-700">Check-in Penghuni Kamar 104 (Budi S.)</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[8px] font-black">SELESAI</span>
                        </div>
                        <div class="px-3 py-2 flex justify-between items-center bg-white">
                            <span class="font-bold text-slate-700">Pembayaran Tagihan Kamar 203 (Mutasi BCA)</span>
                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-650 text-[8px] font-black">TERVERIFIKASI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: MANAJEMEN PROPERTI -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left Side visual diagram -->
            <div class="lg:col-span-6 lg:order-2 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Tata Struktur Unit
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Pengelolaan Struktur Kamar, Fasilitas &amp; Tarif Terpusat
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Sesuaikan sistem dengan topologi fisik properti Anda. Kosan memudahkan Anda dalam mengatur pembagian gedung, blok, penomoran lantai, ketersediaan fasilitas kamar, hingga kustomisasi skema tarif sewa harian, mingguan, atau bulanan secara fleksibel.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pengelompokan properti berdasarkan Gedung &amp; Blok</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Status hunian kamar yang diperbarui secara otomatis</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Katalog fasilitas kamar &amp; pendataan status meteran air/listrik</span>
                    </li>
                </ul>
            </div>

            <!-- Right Side Diagram Visual -->
            <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                <!-- Room Card 1 -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-3 transition hover:shadow-md">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase font-bold text-slate-400">Gedung A &bull; Lantai 1</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 dot-pulse"></span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Kamar 101 (Deluxe)</h4>
                        <p class="text-[10px] text-slate-400 font-semibold">AC, Kamar Mandi Dalam, WiFi</p>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500">Rp 1.800.000 / bln</span>
                        <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[8px] font-black">TERISI</span>
                    </div>
                </div>

                <!-- Room Card 2 -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-3 transition hover:shadow-md">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase font-bold text-slate-400">Gedung A &bull; Lantai 1</span>
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Kamar 102 (Standard)</h4>
                        <p class="text-[10px] text-slate-400 font-semibold">Kamar Mandi Dalam, Fan, WiFi</p>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500">Rp 1.200.000 / bln</span>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[8px] font-black">KOSONG</span>
                    </div>
                </div>

                <!-- Room Card 3 -->
                <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-3 transition hover:shadow-md">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase font-bold text-slate-400">Gedung B &bull; Lantai 2</span>
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Kamar 201 (VIP)</h4>
                        <p class="text-[10px] text-slate-400 font-semibold">TV, AC, Bed King Size, Balkon</p>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-bold text-slate-500">Rp 2.500.000 / bln</span>
                        <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 text-[8px] font-black">MAINTENANCE</span>
                    </div>
                </div>

                <!-- Total Units Widget -->
                <div class="bg-indigo-600 text-white p-5 rounded-xl flex flex-col justify-between shadow-lg">
                    <span class="text-[9px] uppercase font-bold text-indigo-200">Kapasitas Maksimal</span>
                    <div>
                        <h4 class="text-3xl font-black">94%</h4>
                        <p class="text-[10px] text-indigo-100 font-semibold">Rata-rata hunian terisi tahun ini</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: MANAJEMEN PENGHUNI -->
    <section class="py-24 bg-slate-50/40 border-y border-slate-250/10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side visual widget -->
            <div class="lg:col-span-7 bg-white p-5 border border-slate-200 rounded-2xl shadow-xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">Detail Profil Penghuni</span>
                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-650 text-[8.5px] font-black rounded">Penyewa Aktif</span>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-650 text-sm">BS</div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Budi Santoso</h4>
                        <p class="text-[10px] text-slate-400 font-semibold">budi.santoso@email.com &bull; Kamar 104</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs pt-2">
                    <div class="space-y-1">
                        <span class="text-[8px] uppercase font-extrabold text-slate-400 tracking-wider">Status Identitas</span>
                        <div class="flex items-center gap-1.5 text-emerald-600 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>KTP Terverifikasi</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[8px] uppercase font-extrabold text-slate-400 tracking-wider">Masa Sewa Kontrak</span>
                        <div class="text-slate-700 font-bold">01 Jul 2026 - 01 Jul 2027</div>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-150 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-650" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <span class="text-[10px] font-bold text-slate-700">Dokumen Kontrak Sewa Digital</span>
                    </div>
                    <span class="text-[9px] font-black text-emerald-600">✓ TANDA TANGAN ELEKTRONIK</span>
                </div>
            </div>

            <!-- Right side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Administrasi Tertib
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Simpan Riwayat Sewa, Kontrak &amp; Profil Penghuni dengan Aman
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Jaga hubungan baik dan administrasi hukum yang tertib dengan penghuni Anda. Kosan mengotomatiskan siklus hidup penghuni sejak awal check-in, penandatanganan dokumen perjanjian, pendataan dokumen KTP/KK, pembayaran berkala, hingga proses check-out resmi tanpa ada data historis yang hilang.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Database penghuni terpusat &amp; aman</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pengunggahan dokumen legalitas (KTP/KTM) digital</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pemberitahuan otomatis saat kontrak sewa mendekati tenggat berakhir</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- SECTION 6: PENAGIHAN & INVOICE -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Otomatisasi Finansial
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Penerbitan Tagihan Otomatis &amp; Invoice Digital Tanpa Repot
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Jangan buang waktu menagih satu per satu. Sistem akan secara otomatis menerbitkan tagihan bulanan sesuai masa kontrak, menjumlahkan biaya utilitas tambahan (seperti laundry, WiFi, token listrik), dan langsung mengirimkannya dalam format invoice digital ke WhatsApp &amp; Email penghuni.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Sistem penagihan terjadwal otomatis di awal/akhir bulan</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Penjumlahan biaya tambahan dinamis (misal: air/listrik)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pengingat jatuh tempo (reminder) otomatis via WhatsApp</span>
                    </li>
                </ul>
            </div>

            <!-- Right side mockup: WhatsApp notification + Invoice preview -->
            <div class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-2xl p-6 relative overflow-hidden flex flex-col justify-center min-h-[300px]">
                <div class="space-y-4 max-w-md mx-auto w-full">
                    <!-- Whatsapp simulator widget -->
                    <div class="bg-emerald-600 text-white rounded-xl p-3 shadow-md text-xs space-y-1.5 border border-emerald-500">
                        <div class="flex justify-between items-center border-b border-emerald-500 pb-1.5 text-[9px] font-extrabold uppercase tracking-wide">
                            <span>WhatsApp Platform</span>
                            <span>KOSAN NOTIFIKASI</span>
                        </div>
                        <p class="font-bold">"Halo Kak Budi, tagihan Kamar 104 sebesar Rp 1.800.000 telah terbit. Silakan bayar sebelum jatuh tempo 05 Juli 2026."</p>
                    </div>

                    <!-- Digital Invoice Card widget -->
                    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm text-xs space-y-3 text-left">
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-mono text-slate-400">FAKTUR #INV-2607104</span>
                            <span class="text-[8px] bg-rose-50 text-rose-600 px-2 py-0.5 rounded font-black">BELUM DIBAYAR</span>
                        </div>
                        <div class="space-y-1 border-y border-slate-100 py-2">
                            <div class="flex justify-between text-slate-650">
                                <span>Sewa Kamar 104 (Jul 2026)</span>
                                <span class="font-bold">Rp 1.800.000</span>
                            </div>
                            <div class="flex justify-between text-slate-650">
                                <span>Addon: Cuci &amp; Setrika (Laundry)</span>
                                <span class="font-bold">Rp 120.000</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="font-extrabold text-slate-800">Total Tagihan:</span>
                            <span class="text-sm font-black text-indigo-650 font-mono">Rp 1.920.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 7: PEMBAYARAN -->
    <section class="py-24 bg-slate-50/40 border-y border-slate-250/10 glow-emerald">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side visual matching simulator -->
            <div class="lg:col-span-6 bg-white p-5 border border-slate-200 rounded-2xl shadow-xl space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">Rekonsiliasi Mutasi Bank</span>
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8.5px] font-black rounded">Pencocokan Cerdas</span>
                </div>

                <div class="space-y-3">
                    <!-- Tenant upload proof simulator -->
                    <div class="p-3 bg-slate-50 border border-slate-150 rounded-lg flex items-center justify-between text-xs">
                        <div class="space-y-0.5">
                            <span class="text-[8px] uppercase font-bold text-slate-400 block">Bukti Transfer Diunggah</span>
                            <span class="font-bold text-slate-700">Struk_Transfer_Budi.jpg</span>
                        </div>
                        <span class="text-[9px] font-bold text-indigo-600">Rp 1.920.000</span>
                    </div>

                    <!-- Connection indicator -->
                    <div class="flex items-center justify-center py-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></div>
                        <div class="h-[1.5px] bg-emerald-300 w-16"></div>
                        <span class="text-[9.5px] font-black text-emerald-600 px-3 uppercase tracking-wider">Matched &amp; Verified</span>
                        <div class="h-[1.5px] bg-emerald-300 w-16"></div>
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></div>
                    </div>

                    <!-- Mutasi BCA bank record simulator -->
                    <div class="p-3 bg-slate-900 text-white rounded-lg flex items-center justify-between text-xs">
                        <div class="space-y-0.5">
                            <span class="text-[8px] uppercase font-bold text-slate-400 block">Mutasi Bank BCA (Real-time)</span>
                            <span class="font-bold text-slate-200">CR: TRSF FRM BUDI S Rp 1.920.000</span>
                        </div>
                        <span class="text-xs font-black text-emerald-400 font-mono">LUNAS</span>
                    </div>
                </div>
            </div>

            <!-- Right side copywriting -->
            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Verifikasi Instan
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Penerimaan Pembayaran Aman &amp; Rekonsiliasi Otomatis
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Hilangkan kekhawatiran manipulasi gambar struk transfer palsu. Kosan mencocokkan nomor referensi transfer atau transaksi Virtual Account yang diunggah penghuni secara langsung dengan mutasi rekening bank terdaftar Anda. Jika nominal dan nomor referensi cocok, sistem akan mengubah status tagihan menjadi lunas seketika tanpa perlu verifikasi manual.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Verifikasi otomatis pembayaran Virtual Account &amp; Transfer Bank</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Proteksi mutlak dari bukti bayar palsu</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Kuitansi digital otomatis dikirim setelah transaksi diverifikasi</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- SECTION 8: MAINTENANCE -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Manajemen Keluhan
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Penanganan Laporan Kerusakan &amp; Tiket Teknisi Responsif
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Pertahankan tingkat loyalitas penghuni kos dengan pelayanan perbaikan fasilitas yang responsif. Penghuni dapat mengajukan komplain fasilitas (AC mati, kebocoran pipa, internet bermasalah) lengkap dengan foto langsung dari portal mereka, sementara Anda dapat mendelegasikan tiket penugasan kerja ini kepada staf teknisi terdaftar.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pelaporan komplain mandiri dilengkapi foto bukti keluhan</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Penugasan teknisi internal dengan detail pekerjaan lengkap</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pemantauan status progres perbaikan secara transparan</span>
                    </li>
                </ul>
            </div>

            <!-- Right side maintenance ticket simulation -->
            <div class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-2xl p-6 relative overflow-hidden flex items-center justify-center min-h-[300px]"
                 x-data="{ status: 'Diajukan' }" x-init="setInterval(() => { status = status === 'Diajukan' ? 'Teknisi Ditugaskan' : status === 'Teknisi Ditugaskan' ? 'Selesai' : 'Diajukan' }, 4000)">
                <div class="w-full max-w-sm bg-white border border-slate-200 rounded-2xl p-4 shadow-xl space-y-4 text-left">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                        <span class="text-[9px] font-mono text-slate-455">TIKET KOMPLAIN #TKT-309</span>
                        <span class="text-[8px] px-2 py-0.5 rounded font-black uppercase transition-all duration-300"
                              :class="{
                                'bg-rose-50 text-rose-600 border border-rose-100': status === 'Diajukan',
                                'bg-amber-50 text-amber-600 border border-amber-100': status === 'Teknisi Ditugaskan',
                                'bg-emerald-50 text-emerald-600 border border-emerald-100': status === 'Selesai'
                              }" x-text="status"></span>
                    </div>

                    <div class="space-y-1">
                        <h5 class="text-xs font-bold text-slate-800">Judul Keluhan: Saluran Air Kamar Mandi Tersumbat</h5>
                        <p class="text-[9px] text-slate-500 font-semibold">Pelapor: Budi Santoso (Kamar 104)</p>
                    </div>

                    <!-- Steps Timeline -->
                    <div class="grid grid-cols-3 gap-2 text-center text-[8.5px] font-bold tracking-wide">
                        <div class="p-1 rounded transition-colors" :class="status === 'Diajukan' ? 'bg-rose-50 text-rose-600' : 'text-slate-455 bg-slate-50'">1. Diajukan</div>
                        <div class="p-1 rounded transition-colors" :class="status === 'Teknisi Ditugaskan' ? 'bg-amber-50 text-amber-600' : 'text-slate-455 bg-slate-50'">2. Diproses</div>
                        <div class="p-1 rounded transition-colors" :class="status === 'Selesai' ? 'bg-emerald-50 text-emerald-600' : 'text-slate-455 bg-slate-50'">3. Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 9: LAPORAN & ANALITIK -->
    <section class="py-24 bg-slate-50/40 border-y border-slate-250/10 glow-indigo">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side visual graph -->
            <div class="lg:col-span-7 bg-white p-5 border border-slate-200 rounded-2xl shadow-xl space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider">Statistik Profitabilitas</span>
                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-650 text-[8.5px] font-black rounded">Executive Insight</span>
                </div>

                <!-- Custom Bar visual -->
                <div class="space-y-4">
                    <div class="space-y-1">
                        <div class="flex justify-between text-[10px] font-bold text-slate-650">
                            <span>Okupansi Rata-rata</span>
                            <span>94%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-650 h-full rounded-full transition-all duration-1000" style="width: 94%"></div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-[10px] font-bold text-slate-650">
                            <span>Rata-rata Durasi Sewa</span>
                            <span>8.5 Bulan</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-650 h-full rounded-full transition-all duration-1000" style="width: 70%"></div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between text-[10px] font-bold text-slate-650">
                            <span>Arus Kas Masuk Bersih</span>
                            <span>Rp 48.500.000</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-indigo-650 h-full rounded-full transition-all duration-1000" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Data Bisnis Konkret
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Laporan Keuangan &amp; Analitik Tingkat Hunian Real-time
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Ambil keputusan ekspansi bisnis berdasarkan data yang akurat. Kosan menyusun data arus kas masuk-keluar secara otomatis, menganalisis tingkat okupansi hunian bulanan, serta menyajikan estimasi laba kotor dan laba bersih tanpa kesalahan hitung rumus manual.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Laporan Laba Rugi otomatis per properti</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Analitik performa sewa unit &amp; tingkat okupansi</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Ekspor laporan dalam satu klik (Excel/PDF)</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- SECTION 10: MULTI PROPERTI & MANAJEMEN TIM -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side copywriting -->
            <div class="lg:col-span-5 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Kolaborasi &amp; Kontrol
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Manajemen Multi Properti &amp; Pembagian Hak Akses Tim
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Kelola beberapa cabang kos secara aman dalam satu akun platform tunggal. Anda dapat mendaftarkan staf lapangan, manajer keuangan, atau pengawas keamanan, lalu memberikan hak akses terisolasi berdasarkan peran (Role-based Access Control) demi kerahasiaan arus kas utama Anda.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Workspace terisolasi untuk tiap cabang properti</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Pembagian peran yang jelas: Owner, Manager, Staff</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Audit log untuk melacak riwayat perubahan oleh staf</span>
                    </li>
                </ul>
            </div>

            <!-- Right side team roles selector layout -->
            <div class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-2xl p-6 relative overflow-hidden flex items-center justify-center min-h-[300px]">
                <div class="w-full max-w-sm space-y-3">
                    <!-- Owner card -->
                    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs">RA</div>
                            <div class="text-left">
                                <h5 class="text-xs font-bold text-slate-800">Rivaldi Alamsyah</h5>
                                <span class="text-[8px] text-slate-400 font-semibold">Seluruh Cabang Properti</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-slate-900 text-white text-[8px] font-black uppercase">OWNER</span>
                    </div>

                    <!-- Manager card -->
                    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between translate-x-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-indigo-650 text-white flex items-center justify-center font-bold text-xs">SP</div>
                            <div class="text-left">
                                <h5 class="text-xs font-bold text-slate-800">Siti Permata</h5>
                                <span class="text-[8px] text-slate-400 font-semibold">Cabang Dago Suites</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 text-[8px] font-black uppercase">MANAGER</span>
                    </div>

                    <!-- Staff card -->
                    <div class="bg-white border border-slate-200 rounded-xl p-3 shadow-sm flex items-center justify-between translate-x-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-655 flex items-center justify-center font-bold text-xs">PS</div>
                            <div class="text-left">
                                <h5 class="text-xs font-bold text-slate-800">Putra Setia</h5>
                                <span class="text-[8px] text-slate-400 font-semibold">Cabang Cihampelas</span>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[8px] font-black uppercase">STAFF</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 11: MOBILE APP / PROGRESSIVE WEB APP (PWA) -->
    <section class="py-24 bg-slate-50/40 border-y border-slate-250/10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            <!-- Left side visual mockup: Smartphone -->
            <div class="lg:col-span-6 flex items-center justify-center">
                <!-- Smart Phone frame -->
                <div class="w-56 h-[380px] bg-slate-900 rounded-[36px] p-2.5 shadow-2xl border-4 border-slate-850 relative">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-20 h-4 bg-slate-850 rounded-b-xl"></div>
                    <div class="w-full h-full bg-white rounded-[26px] overflow-hidden p-3.5 flex flex-col justify-between">
                        <!-- Top title bar in app -->
                        <div class="text-left space-y-3">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] font-black text-slate-800">Portal Penghuni</span>
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 dot-pulse"></span>
                            </div>
                            <!-- App Welcome details -->
                            <div class="p-3 bg-indigo-50 border border-indigo-100/70 rounded-xl space-y-1.5 text-indigo-700">
                                <h5 class="text-[10px] font-black">Halo Budi (Kamar 104)</h5>
                                <p class="text-[8px] font-semibold">Tagihan Sewa Bulan Ini:</p>
                                <h4 class="text-xs font-black font-mono">Rp 1.920.000</h4>
                            </div>
                        </div>
                        
                        <!-- Submit Receipt Button -->
                        <button class="w-full py-2 bg-indigo-650 text-white text-[9px] font-bold rounded-lg shadow-sm">
                            Kirim Bukti Pembayaran
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right side copywriting -->
            <div class="lg:col-span-6 space-y-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-600 tracking-wider uppercase">
                    Akses Instan
                </div>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Pengalaman Terbaik di Mobile dengan Portal PWA
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Kosan menyediakan aplikasi berbasis Progressive Web App (PWA) yang sangat ringan dan responsif. Baik pemilik maupun penghuni dapat mengakses seluruh fitur dari browser seluler secara instan tanpa perlu repot mengunduh aplikasi tambahan dari Google Play Store atau Apple App Store.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Akses instan di Android &amp; iOS tanpa install</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Sangat ringan dan tidak menghabiskan memori smartphone</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">✓</span>
                        <span>Dukungan notifikasi real-time untuk pengingat pembayaran</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- SECTION 12: INTEGRASI EKOSISTEM -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            <!-- Headers -->
            <div class="max-w-3xl mx-auto text-center space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Konektivitas Tanpa Batas</h2>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Terintegrasi dengan Berbagai Sistem Komunikasi &amp; Finansial
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xl mx-auto font-medium">
                    Koneksikan Kosan dengan alat kerja, dompet digital, dan gerbang pembayaran (payment gateway) yang sudah Anda gunakan sehari-hari demi efisiensi optimal.
                </p>
            </div>

            <!-- Integrations list grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- WhatsApp API -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-emerald-50 text-emerald-600 rounded uppercase">AKTIF</span>
                    <div class="w-10 h-10 rounded-full bg-emerald-550/10 text-emerald-600 flex items-center justify-center text-xl font-bold font-mono">WA</div>
                    <span class="text-[10px] font-black text-slate-800">WhatsApp API</span>
                </div>

                <!-- Midtrans / Payment Gateway -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-emerald-50 text-emerald-600 rounded uppercase">AKTIF</span>
                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold font-mono">PG</div>
                    <span class="text-[10px] font-black text-slate-800">Payment Gateway</span>
                </div>

                <!-- Email Notifications -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-emerald-50 text-emerald-600 rounded uppercase">AKTIF</span>
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-655 flex items-center justify-center text-xl font-bold font-mono">EM</div>
                    <span class="text-[10px] font-black text-slate-800">Email System</span>
                </div>

                <!-- Google Calendar -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-amber-50 text-amber-600 rounded uppercase">SOON</span>
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold font-mono">GC</div>
                    <span class="text-[10px] font-black text-slate-800">Google Calendar</span>
                </div>

                <!-- Cloud Storage -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-amber-50 text-amber-600 rounded uppercase">SOON</span>
                    <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold font-mono">CS</div>
                    <span class="text-[10px] font-black text-slate-800">Cloud Storage</span>
                </div>

                <!-- API Developer Access -->
                <div class="bg-slate-50 border border-slate-200/60 p-5 rounded-xl text-center space-y-3 relative overflow-hidden flex flex-col items-center justify-center">
                    <span class="absolute top-2 right-2 text-[7.5px] font-extrabold px-1.5 py-0.5 bg-amber-50 text-amber-600 rounded uppercase">SOON</span>
                    <div class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center text-xl font-bold font-mono">API</div>
                    <span class="text-[10px] font-black text-slate-800">Developer API</span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 13: KEAMANAN DATA -->
    <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.1),transparent_50%)]"></div>
        
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center relative z-10">
            <!-- Left side security copywriting -->
            <div class="lg:col-span-6 space-y-6 text-left">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-500/20 text-indigo-300 tracking-wider uppercase">
                    Keamanan Tingkat SaaS
                </div>
                <h3 class="text-3xl lg:text-4xl font-black tracking-tight leading-[1.15]">
                    Perlindungan Data Properti &amp; Keuangan Anda Adalah Prioritas Kami
                </h3>
                <p class="text-sm text-slate-350 leading-relaxed font-normal">
                    Kami memahami pentingnya kerahasiaan data operasional dan keuangan bisnis properti Anda. Platform Kosan dibangun di atas arsitektur server awan (cloud) berstandar keamanan tinggi, lengkap dengan proteksi enkripsi SSL, pembatasan hak akses yang ketat, dan pencadangan harian otomatis.
                </p>
                <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                        <span>Enkripsi Data SSL/TLS</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                        <span>Isolasi Multi-Tenant Database</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                        <span>Backup Harian Otomatis</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-[10px]">✓</span>
                        <span>Audit Log Aktivitas Staf</span>
                    </div>
                </div>
            </div>

            <!-- Right side security badge visual -->
            <div class="lg:col-span-6 flex justify-center">
                <!-- Glowing Shield Container -->
                <div class="relative p-8 bg-slate-800/80 border border-slate-700/50 rounded-2xl shadow-2xl flex flex-col items-center justify-center text-center space-y-4 max-w-sm">
                    <div class="w-16 h-16 rounded-full bg-indigo-500/10 text-indigo-400 flex items-center justify-center shadow-inner">
                        <!-- Security shield SVG -->
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">Arsitektur Terenkripsi</h4>
                        <p class="text-[10px] text-slate-400 font-semibold mt-1">Data sensitif penghuni dan rekening bank Anda terlindungi dengan standar enkripsi AES-256 bit di sisi server.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 14: FAQ -->
    <section class="py-24 bg-slate-50/30 border-y border-slate-200/50" x-data="{ openFaq: null }">
        <div class="max-w-4xl mx-auto px-6 space-y-16">
            <!-- Headers -->
            <div class="text-center space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Tanya &amp; Jawab</h2>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Pertanyaan yang Sering Diajukan Calon Pelanggan
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xl mx-auto font-medium">
                    Temukan jawaban cepat seputar proses pendaftaran, migrasi data, uji coba gratis, hingga dukungan teknis platform Kosan.
                </p>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 1 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 1 ? null : 1">
                        <span>Bagaimana proses implementasi Kosan untuk pertama kali?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 1 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 1" x-transition>
                        Prosesnya sangat mudah. Anda hanya perlu mendaftar akun, memasukkan informasi nama properti, mendefinisikan jumlah kamar sewa, dan platform langsung siap digunakan. Kami juga menyediakan panduan video onboard kilat untuk membantu pengaturan awal Anda kurang dari 5 menit.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 2 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 2 ? null : 2">
                        <span>Apakah masa uji coba gratis benar-benar 14 hari tanpa biaya?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 2 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 2" x-transition>
                        Ya, benar-benar gratis dan tanpa risiko. Anda mendapatkan akses penuh ke seluruh fitur premium platform selama 14 hari tanpa harus memasukkan informasi kartu kredit. Anda dapat membatalkan masa uji coba atau beralih ke paket berlangganan kapan saja.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 3 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 3 ? null : 3">
                        <span>Bagaimana platform Kosan menjaga keamanan data bisnis saya?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 3 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 3" x-transition>
                        Seluruh data finansial dan identitas penghuni disimpan secara terenkripsi menggunakan skema enkripsi SSL/TLS berkeamanan tinggi. Kami menggunakan arsitektur basis data multi-tenant yang mengisolasi data masing-masing pelanggan agar tidak tumpang tindih dengan pihak lain, serta melakukan pencadangan (backup) harian secara otomatis ke cloud storage terpisah.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 4 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 4 ? null : 4">
                        <span>Dapatkah saya melakukan migrasi data penghuni dari Excel ke Kosan?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 4 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 4" x-transition>
                        Tentu saja. Kami menyediakan template format Excel khusus untuk mengunggah seluruh data kamar dan profil penghuni Anda secara massal (bulk import) ke dalam sistem hanya dalam hitungan detik. Tim dukungan onboarding kami juga siap mendampingi proses impor data Anda tanpa biaya tambahan.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 5 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 5 ? null : 5">
                        <span>Bagaimana jika saya memerlukan bantuan dukungan teknis saat menggunakan platform?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 5 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 5" x-transition>
                        Tim CS kami siap membantu Anda melalui percakapan chat WhatsApp langsung, email tiket, atau panggilan bantuan selama jam operasional. Pengguna dengan paket bisnis tertentu juga akan mendapatkan nomor layanan prioritas khusus dengan SLA respon di bawah 15 menit.
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 6 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 6 ? null : 6">
                        <span>Perangkat apa saja yang kompatibel untuk mengakses Kosan?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 6 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 6" x-transition>
                        Platform Kosan dapat diakses secara optimal dari seluruh perangkat yang memiliki peramban web (browser). Baik komputer desktop, laptop, tablet iPad, hingga smartphone Android &amp; iOS. Karena menggunakan teknologi PWA, halaman akan memuat sangat cepat di seluruh jenis koneksi internet.
                    </div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 7 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 7 ? null : 7">
                        <span>Bagaimana skema paket berlangganan setelah masa uji coba gratis berakhir?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 7 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 7" x-transition>
                        Setelah 14 hari, Anda dapat memilih beberapa paket langganan transparan kami (mulai dari paket Starter untuk kosan skala kecil hingga paket Enterprise untuk manajemen multi-properti besar). Seluruh skema harga sangat transparan tanpa biaya tersembunyi, dan Anda bebas membatalkan langganan kapan saja tanpa ikatan kontrak tahunan.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 15: CALL TO ACTION (CTA) -->
    <section class="py-20 bg-gradient-to-tr from-indigo-900 via-indigo-950 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.25),transparent_45%)]"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Siap Mengotomatisasikan Bisnis Properti Kos Anda?
            </h2>
            <p class="text-indigo-200/90 text-sm max-w-xl mx-auto leading-relaxed font-normal">
                Bergabunglah dengan ratusan pengelola kos yang telah sukses meningkatkan efisiensi pembukuan finansial, mengurangi komplain menumpuk, dan menghemat ribuan jam kerja berharga.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                <x-button variant="primary" size="lg" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 !border-white w-full sm:w-auto text-center font-bold px-8 py-4 shadow-lg cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Mulai Uji Coba Gratis 14 Hari
                </x-button>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 border border-white/25 text-white font-bold text-base transition duration-200 hover:-translate-y-0.5 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                    </svg>
                    Hubungi Sales &amp; Demo
                </a>
            </div>
            
            <p class="text-xs text-indigo-300/80 font-medium">Tanpa kartu kredit &bull; Setup mudah dalam 2 menit &bull; Batalkan langganan kapan saja</p>
        </div>
    </section>

</x-marketing-layout>
