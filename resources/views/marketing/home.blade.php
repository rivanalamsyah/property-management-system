<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- JSON-LD FAQ & WebSite Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ route('resources') }}?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    @endpush

    <!-- Custom Styling for Interactive Elements -->
    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
        
        .isometric-container {
            perspective: 1200px;
        }
        .isometric-layer {
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .isometric-container:hover .layer-1 {
            transform: rotateX(52deg) rotateZ(-45deg) translateZ(-90px) !important;
            opacity: 0.55;
        }
        .isometric-container:hover .layer-2 {
            transform: rotateX(52deg) rotateZ(-45deg) translateZ(15px) !important;
        }
        .isometric-container:hover .layer-3 {
            transform: rotateX(52deg) rotateZ(-45deg) translateZ(120px) !important;
        }
        
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(1.08); }
        }
        .pulse-glow {
            animation: pulseGlow 6s ease-in-out infinite;
        }
    </style>

    <!-- Section 1: Redesigned Hero Banner (Split Grid with CSS 3D Isometric Exploded House) -->
    <section class="relative overflow-hidden pt-28 pb-20 lg:pt-36 lg:pb-32 bg-slate-50/40 border-b border-slate-200/50">
        <!-- Ambient mesh blurs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none -z-10 animate-[pulse_8s_infinite]"></div>
        <div class="absolute bottom-10 right-1/4 w-[400px] h-[400px] bg-purple-400/10 rounded-full blur-3xl pointer-events-none -z-10 animate-[pulse_10s_infinite_2s]"></div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center relative z-10">
            <!-- Left Column: Premium Value Pitch & Actions -->
            <div class="lg:col-span-6 space-y-6 text-left">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    Kosan OS v2.4: Multi-Tenant Workspace &amp; Auto-Reconcile
                </span>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.08]">
                    {!! isset($heroContent['heading']) && $heroContent['heading'] !== 'Otomatisasi Penagihan & Pengelolaan Bisnis Kos dalam Satu Aplikasi' 
                        ? $heroContent['heading'] 
                        : 'Kelola Kos-Kosan Otomatis &amp; <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Bebas Stres</span>' !!}
                </h1>
                
                <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-lg font-medium">
                    {{ $heroContent['subtitle'] ?? 'Otomatisasi tagihan sewa bulanan, verifikasi instan bukti bayar bank tanpa manipulasi nota, cetak kontrak digital secara aman, dan sediakan portal PWA mandiri bagi penghuni.' }}
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-3 pt-3">
                    <x-button variant="primary" size="lg" class="w-full sm:w-auto text-center px-8 py-3.5 shadow-md shadow-indigo-500/25 transition duration-200 hover:-translate-y-0.5 active:translate-y-0 text-xs font-bold cursor-pointer" onclick="window.location.href='{{ $heroContent['button_url'] ?? route('register') }}'">
                        {{ $heroContent['button_label'] ?? 'Coba Gratis 14 Hari' }}
                    </x-button>
                    <x-button variant="outline" size="lg" class="w-full sm:w-auto text-center px-8 py-3.5 border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold transition duration-200 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer" onclick="window.location.href='{{ route('contact') }}'">
                        Hubungi Sales &amp; Demo
                    </x-button>
                </div>
                
                <div class="flex items-center gap-4 pt-4 text-xs font-bold text-slate-400">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <span class="text-slate-600">4.9 / 5</span>
                    </div>
                    <span>&bull;</span>
                    <span>1,200+ Juragan Kos bergabung</span>
                    <span>&bull;</span>
                    <span>No CC Required</span>
                </div>
            </div>

            <!-- Right Column: Interactive WebGL Three.js 3D House View -->
            <div class="lg:col-span-6 relative pt-12 lg:pt-0 min-h-[450px] flex items-center justify-center">
                <!-- Backlight Glow Spot -->
                <div class="absolute -inset-10 bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 rounded-full blur-3xl -z-10 pulse-glow"></div>

                <!-- WebGL Canvas Viewport Wrapper -->
                <div class="w-full h-[400px] relative">
                    <canvas id="three-house-canvas" class="w-full h-full relative z-10 cursor-grab active:cursor-grabbing outline-hidden"></canvas>
                </div>

                <!-- Floating Interactive Widget: Real-time Auto Verification Message -->
                <div class="absolute top-[10px] left-[5px] sm:left-[-15px] z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-3 shadow-lg flex items-center gap-3 animate-[bounce_4.5s_infinite] pointer-events-none">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="text-left space-y-0.5">
                        <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Verifikasi Berhasil</span>
                        <h4 class="text-xs font-bold text-slate-800">Kamar 202 &bull; Lunas</h4>
                    </div>
                </div>

                <!-- Floating Interactive Widget 2: Occupancy Gauge Map -->
                <div class="absolute bottom-[-10px] right-[5px] sm:right-[-15px] z-30 bg-white/90 backdrop-blur-md border border-slate-200/80 rounded-2xl p-4 shadow-lg space-y-2 animate-[bounce_5.5s_infinite_1.5s] pointer-events-none max-w-[200px]">
                    <div class="flex justify-between items-center gap-6">
                        <span class="text-[9px] uppercase font-extrabold text-slate-400">Okupansi Kamar</span>
                        <span class="text-xs font-black text-indigo-600">92.4%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: 92%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Logo Cloud / Social Proof (Ticker Marquee Style) -->
    <section class="py-10 bg-white border-y border-slate-200/50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-6">
            <h3 class="text-[11px] font-black text-slate-450 uppercase tracking-widest">Dipercaya oleh ratusan pemilik kos &amp; pengelola hunian di Indonesia</h3>
            
            <div class="relative w-full overflow-hidden">
                <!-- Linear Gradient fading edges -->
                <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                <div class="flex gap-16 items-center whitespace-nowrap animate-marquee w-max">
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">CIHAMPELAS RESIDENCE</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">DAGO ACCOMMODATION</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">WAYNE PROPERTIES</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">PARADISE KOS</span>
                    <!-- Duplicate for infinite effect -->
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">CIHAMPELAS RESIDENCE</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">DAGO ACCOMMODATION</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">WAYNE PROPERTIES</span>
                    <span class="text-xs sm:text-sm font-extrabold tracking-widest text-slate-500 uppercase px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl">PARADISE KOS</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Problem Breakdown (Split Panel Layout with Hover Effects) -->
    <section class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left Side Title -->
            <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-24">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Masalah Utama Operasional</h2>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">Mengapa Pengelolaan Kos Manual Menyita Waktu &amp; Berisiko</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Spreadsheet dan grup chat WhatsApp tidak dirancang untuk mengelola properti secara terstruktur. Berikut kendala operasional yang kami selesaikan.
                </p>
                <div class="pt-4 hidden lg:block">
                    <div class="w-16 h-1 bg-indigo-600 rounded-full"></div>
                </div>
            </div>
            
            <!-- Right Side Staggered Problem Cards -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Card 1 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center flex-shrink-0 group-hover:rotate-6 transition-transform">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Penagihan Manual Menyita Waktu</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed pl-14">
                        Menghitung sewa, biaya listrik/air, dan menulis pesan penagihan satu per satu memakan waktu berhari-hari. Penagihan yang terlambat membuat pembayaran sewa tertunda.
                    </p>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center flex-shrink-0 group-hover:rotate-6 transition-transform">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Bukti Transfer Palsu &amp; Rekonsiliasi Sulit</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed pl-14">
                        Penghuni mengirim foto bukti transfer. Memeriksa kesesuaian transaksi dengan mutasi rekening secara manual sangat rentan kesalahan manusia dan risiko bukti transfer palsu.
                    </p>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 space-y-4 group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 group-hover:rotate-6 transition-transform">
                            <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Laporan Kerusakan Kamar Berantakan</h4>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed pl-14">
                        Keluhan kebocoran dan kerusakan fasilitas menumpuk di chat WhatsApp. Tanpa sistem tiket perbaikan, penanganan teknisi menjadi lambat dan tidak terpantau.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Platform Overview (Interactive Grid with Real-time Simulation) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-100">
                <div class="space-y-3 max-w-xl">
                    <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Ikhtisar Platform</h2>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Sistem Pengelolaan Kos Terpadu dalam Satu Dashboard</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Kosan menyediakan ruang kerja operasional yang aman, mengisolasi data antar properti kos, serta mengotomatisasi alur penagihan sewa secara terpusat.
                    </p>
                </div>
                <div class="flex gap-8 border-l-2 border-indigo-150 pl-6 flex-shrink-0">
                    <div>
                        <h4 class="text-4xl font-black text-indigo-600">99.2%</h4>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase mt-0.5 tracking-wider">Tingkat pelunasan sewa</p>
                    </div>
                    <div>
                        <h4 class="text-4xl font-black text-indigo-600">80%</h4>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase mt-0.5 tracking-wider">Hemat waktu admin</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Specs list -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="flex gap-4 p-5 hover:bg-slate-50 rounded-2xl border border-transparent hover:border-slate-150 transition duration-200">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-extrabold text-xs">1</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Pusat Kontrol Pemilik (Command Center)</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Pantau total pendapatan, tingkat keterisian kamar (okupansi), status penagihan sewa, dan laporan perbaikan aktif dalam satu layar.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 p-5 hover:bg-slate-50 rounded-2xl border border-transparent hover:border-slate-150 transition duration-200">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-extrabold text-xs">2</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Delegasi Hak Akses Manajer &amp; Staf</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Undang manajer untuk mengaudit status kamar, serta berikan akses staf untuk menangani check-in penghuni dan verifikasi pembayaran bulanan.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 p-5 hover:bg-slate-50 rounded-2xl border border-transparent hover:border-slate-150 transition duration-200">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-extrabold text-xs">3</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Portal Mandiri Penghuni (Resident PWA)</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Berikan akses login mandiri bagi penghuni untuk melihat faktur tagihan, mengunggah bukti transfer, melaporkan kerusakan fasilitas, dan mengajukan check-out.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Preview Graphic Mock with checking dynamic loop simulation -->
                <div class="lg:col-span-6 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl relative overflow-hidden shadow-inner min-h-[300px] flex items-center justify-center"
                     x-data="{ checkedIn: false }" x-init="setInterval(() => { checkedIn = !checkedIn }, 3500)">
                    <div class="w-full max-w-sm bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-4 relative">
                        <!-- Top status bar -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <span class="text-xs font-bold text-slate-800">Kos Cihampelas Utama</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold transition-colors duration-300"
                                  :class="checkedIn ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/50' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/50'">
                                <span x-text="checkedIn ? '93% Terisi' : '92% Terisi'"></span>
                            </span>
                        </div>
                        
                        <!-- Rooms Grid -->
                        <div class="grid grid-cols-4 gap-2.5">
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">101</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">102</div>
                            
                            <!-- Simulating check-in room -->
                            <div class="aspect-square rounded-xl flex items-center justify-center text-[10px] font-extrabold transition-all duration-300"
                                 :class="checkedIn ? 'bg-emerald-50 border border-emerald-200/60 text-emerald-700 scale-105 shadow-md shadow-emerald-500/10' : 'bg-rose-50 border border-rose-200/60 text-rose-700'">
                                103
                            </div>
                            
                            <div class="aspect-square bg-rose-50 border border-rose-200/60 rounded-xl flex items-center justify-center text-[10px] text-rose-700 font-extrabold">104</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">201</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">202</div>
                            <div class="aspect-square bg-rose-50 border border-rose-200/60 rounded-xl flex items-center justify-center text-[10px] text-rose-700 font-extrabold">203</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">204</div>
                        </div>
                        
                        <div class="flex justify-between items-center text-[10px] text-slate-400 pt-2 border-t border-slate-100 font-medium">
                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Terisi</span>
                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Kosong</span>
                        </div>

                        <!-- Absolute Dynamic Simulation Alert Bubble -->
                        <div class="absolute bottom-1/3 left-1/2 -translate-x-1/2 w-44 bg-slate-900 text-white p-2.5 rounded-xl shadow-2xl text-[9px] font-bold text-center border border-slate-800 transition-all duration-300"
                             x-show="checkedIn" x-transition>
                            🎉 Kamar 103 Baru Check-in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Fitur Unggulan (Modern Glassmorphic Cards) -->
    <section class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Fitur Unggulan</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Dirancang Khusus untuk Efisiensi Bisnis Kos &amp; Hunian</h3>
                <p class="text-sm text-slate-500">Segala kebutuhan untuk mengotomatisasi penagihan sewa, mengelola kontrak, menganalisis keuangan, dan menangani perbaikan.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-lg hover:-translate-y-1 transition duration-200 space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Katalog Kamar &amp; Meteran Listrik</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Kelola tipe kamar, fasilitas, tingkat okupansi, dan pencatatan meteran listrik/air secara akurat.</p>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-lg hover:-translate-y-1 transition duration-200 space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Pelacak Kontrak Aktif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Simpan periode sewa, kelola uang muka deposit jaminan, dan sediakan checklist saat penghuni check-out.</p>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-lg hover:-translate-y-1 transition duration-200 space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Otomatisasi Penagihan &amp; Invoicing</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Terbitkan faktur sewa bulanan secara otomatis lengkap dengan komponen item biaya tambahan (laundry, wifi, dll).</p>
                </div>
                
                <!-- Card 4 -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-lg hover:-translate-y-1 transition duration-200 space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Laporan Keuangan &amp; BI Analytics</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Visualisasikan arus kas bulanan, rasio pelunasan tagihan sewa, dan simpan preset laporan keuangan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: Business Value (Large KPI & ROI Focus Layout) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Nilai Bisnis</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Maksimalkan Arus Kas &amp; Pertahankan Okupansi Kamar</h3>
                <p class="text-sm text-slate-500">Kosan memangkas beban kerja administratif hingga 80%, meningkatkan imbal hasil investasi properti Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3 p-5 rounded-3xl border border-slate-100 hover:bg-slate-50 transition duration-200">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Rekonsiliasi Pembayaran Instan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penghuni mengunggah bukti bayar via portal digital. Staf Anda cukup mencocokkan nomor referensi transaksi bank secara cepat di dashboard.
                    </p>
                </div>
                
                <div class="space-y-3 p-5 rounded-3xl border border-slate-100 hover:bg-slate-50 transition duration-200">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Mencegah Kerugian Deposit Jaminan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Klaim kerusakan kamar, pemotongan tunggakan listrik, dan pengembalian sisa deposit dihitung secara otomatis saat check-out.
                    </p>
                </div>
                
                <div class="space-y-3 p-5 rounded-3xl border border-slate-100 hover:bg-slate-50 transition duration-200">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Meminimalkan Durasi Kamar Kosong</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pantau tanggal berakhirnya kontrak 30 hari sebelumnya. Tandai kamar sebagai "segera tersedia" untuk menarik calon penghuni baru.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: Dashboard Preview Mock (UCD: Mac-style Window Screenshot Wrapper) -->
    <section class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Preview Dashboard</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Desain Modern dengan Standar Perbankan</h3>
            </div>
            
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-2xl p-4 max-w-4xl mx-auto space-y-4 group">
                <!-- Top Header Panel -->
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-rose-500"></span>
                        <span class="w-3.5 h-3.5 rounded-full bg-amber-500"></span>
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 font-mono">app.kosan.id/dashboard/analytics</span>
                </div>
                
                <!-- Realistic high-res mockup render -->
                <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-sm relative">
                    <img src="{{ asset('assets/images/hero/dashboard_mockup.png') }}" class="w-full object-cover group-hover:scale-[1.005] transition-transform duration-500" alt="Kosan Analytics Dashboard Screenshot">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Resident Portal PWA Preview (Beautified Metallic Phone Mockup) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100/50 uppercase tracking-widest">Pengalaman Penghuni</span>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-none">Portal Digital Berbasis PWA untuk Penghuni Kos</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Tingkatkan kenyamanan dan kepuasan penghuni dengan Progressive Web App (PWA) modern. Penghuni dapat mengecek tagihan, mengunggah bukti transfer, dan memantau status perbaikan tanpa perlu mengunduh aplikasi rumit.
                </p>
                <ul class="space-y-3.5 text-xs text-slate-650 font-semibold">
                    <li class="flex items-center gap-2.5">
                        <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Dapat diinstal langsung di layar utama smartphone iOS &amp; Android</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Notifikasi pengingat otomatis untuk penagihan sewa dan pengumuman</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <div class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Alur komplain fasilitas langsung terhubung dengan staf teknisi</span>
                    </li>
                </ul>
            </div>
            
            <div class="flex items-center justify-center">
                <!-- Metallic Phone Mockup frame with notch -->
                <div class="w-68 h-[440px] bg-slate-900 rounded-[40px] p-3 shadow-2xl relative border-[5px] border-slate-850">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-4.5 bg-slate-850 rounded-b-2xl z-20"></div>
                    <div class="w-full h-full bg-slate-50 rounded-[30px] overflow-hidden p-4 space-y-4 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between pt-1 border-b border-slate-100 pb-2">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-[9px]">BW</div>
                                    <span class="text-[9px] font-bold text-slate-800">Bruce Wayne</span>
                                </div>
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            </div>
                            <div class="p-3 bg-indigo-600 text-white rounded-xl space-y-1 shadow-sm">
                                <span class="text-[8px] uppercase tracking-wider font-extrabold text-indigo-200">Kamar Aktif</span>
                                <h4 class="text-xs font-bold">Kamar 101 &bull; Kos Cihampelas</h4>
                            </div>
                            <div class="pt-1 space-y-2">
                                <span class="text-[8.5px] font-extrabold text-slate-400 uppercase tracking-wider">Faktur Tagihan Bulanan</span>
                                <div class="flex justify-between items-center bg-white border border-slate-150 p-2.5 rounded-xl">
                                    <span class="text-xs font-black text-slate-800">Rp 2.000.000</span>
                                    <span class="text-[7.5px] px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-200/50 font-black uppercase">Belum Bayar</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <button class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-sm text-center">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Pricing Preview (UCD: Pricing Transparency) -->
    <section class="py-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Paket Terjangkau</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Harga Transparan Berkelanjutan Sesuai Skala Bisnis</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Baik Anda mengelola 5 kamar kos atau ratusan unit di berbagai lokasi, kami menyediakan paket yang fleksibel dan efisien.
                </p>
                <div class="pt-2">
                    <a href="{{ route('pricing') }}" class="text-indigo-600 font-bold hover:underline text-xs inline-flex items-center gap-1.5">
                        Hitung Estimasi Penghematan Operasional Anda &rarr;
                    </a>
                </div>
            </div>
            
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-lg space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xl font-extrabold text-slate-900">Paket Pertumbuhan</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Pilihan terbaik untuk pengelola kos profesional.</p>
                    </div>
                    <span class="text-2xl font-black text-indigo-600">Rp 15rb<span class="text-xs font-normal text-slate-400">/kamar/bln</span></span>
                </div>
                
                <ul class="text-xs text-slate-650 space-y-3.5 border-t border-slate-100 pt-4 font-semibold">
                    <li class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Hingga 100 kamar per ruang kerja</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Penagihan sewa &amp; otomatisasi faktur</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Akses penuh portal digital penghuni (PWA)</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Section 9.5: Client Testimonials (UCD: Trust & Authority) -->
    @if(isset($testimonials) && $testimonials->count() > 0)
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Testimonial Pengguna</h2>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Dipercaya Oleh Ratusan Juragan Kos di Seluruh Indonesia</h3>
                    <p class="text-sm text-slate-500">Mendengar langsung cerita sukses pemilik properti yang beralih ke Kosan.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($testimonials as $testi)
                        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between space-y-6 hover:shadow-md transition duration-200">
                            <div class="space-y-4">
                                <!-- Star Rating -->
                                <div class="flex text-amber-400 gap-0.5">
                                    @for($i = 0; $i < ($testi->rating ?? 5); $i++)
                                        <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <p class="text-xs text-slate-650 leading-relaxed italic">
                                    "{{ $testi->review }}"
                                </p>
                            </div>
                            
                            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                                @if($testi->avatar)
                                    <img src="{{ asset($testi->avatar) }}" alt="{{ $testi->customer_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-150" />
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                        {{ substr($testi->customer_name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="space-y-0.5">
                                    <h4 class="text-xs font-bold text-slate-900">{{ $testi->customer_name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $testi->position }} - {{ $testi->company }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Section 10: Strong Bottom CTA (UCD: Peak-End Rule Final Conversion) -->
    <section class="py-24 bg-gradient-to-tr from-indigo-900 via-indigo-950 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.25),transparent_45%)]"></div>
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Siap Mengotomatisasi Bisnis Kos Anda Sekarang?
            </h2>
            <p class="text-indigo-200/90 text-sm max-w-xl mx-auto leading-relaxed font-normal">
                Bergabunglah dengan ratusan pemilik kos yang telah menghemat waktu penagihan sewa, menekan kamar kosong, dan meningkatkan efisiensi operasional.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                <x-button variant="primary" size="lg" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 !border-white w-full sm:w-auto text-center font-bold px-8 py-3.5 shadow-lg cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
                </x-button>
                <x-button variant="outline" size="lg" class="!border-indigo-400/30 !text-white hover:!bg-white/10 w-full sm:w-auto text-center px-8 py-3.5 cursor-pointer" onclick="window.location.href='{{ route('contact') }}'">
                    Jadwalkan Demo Studio
                </x-button>
            </div>
            <p class="text-xs text-indigo-300/80 font-medium">Tanpa komitmen &bull; Batalkan atau tingkatkan paket kapan saja</p>
        </div>
    </section>

    <!-- Three.js Library & WebGL Architectural House Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('three-house-canvas');
            if (!canvas) return;

            // Scene and Camera Setup
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, canvas.clientWidth / canvas.clientHeight, 0.1, 100);
            camera.position.set(5.5, 4.5, 5.5);

            // WebGL Renderer
            const renderer = new THREE.WebGLRenderer({
                canvas: canvas,
                alpha: true,
                antialias: true
            });
            renderer.setSize(canvas.clientWidth, canvas.clientHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;

            // Handle Resize
            const resizeObserver = new ResizeObserver(entries => {
                for (let entry of entries) {
                    const width = entry.contentRect.width;
                    const height = entry.contentRect.height;
                    camera.aspect = width / height;
                    camera.updateProjectionMatrix();
                    renderer.setSize(width, height);
                }
            });
            resizeObserver.observe(canvas.parentElement);

            // House Main Group
            const houseGroup = new THREE.Group();
            scene.add(houseGroup);

            // Base Platform
            const baseGeo = new THREE.BoxGeometry(4.2, 0.15, 4.2);
            const baseMat = new THREE.MeshStandardMaterial({ color: 0xe2e8f0, roughness: 0.8 });
            const baseMesh = new THREE.Mesh(baseGeo, baseMat);
            baseMesh.position.y = -0.075;
            baseMesh.receiveShadow = true;
            houseGroup.add(baseMesh);

            // Swimming Pool
            const poolGeo = new THREE.PlaneGeometry(1.2, 2.2);
            const poolMat = new THREE.MeshStandardMaterial({ color: 0x0ea5e9, roughness: 0.1, metalness: 0.8 });
            const poolMesh = new THREE.Mesh(poolGeo, poolMat);
            poolMesh.rotation.x = -Math.PI / 2;
            poolMesh.position.set(1.2, 0.01, -0.4);
            houseGroup.add(poolMesh);

            // First Floor Building
            const firstFloorGeo = new THREE.BoxGeometry(2.2, 1.2, 2.2);
            const wallMat = new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.5 });
            const firstFloor = new THREE.Mesh(firstFloorGeo, wallMat);
            firstFloor.position.y = 0.6;
            firstFloor.castShadow = true;
            firstFloor.receiveShadow = true;
            houseGroup.add(firstFloor);

            // Front Window (Glass)
            const winGeo = new THREE.PlaneGeometry(1.6, 0.8);
            const glassMat = new THREE.MeshStandardMaterial({ color: 0x818cf8, roughness: 0.05, metalness: 0.95, transparent: true, opacity: 0.5 });
            const windowMesh = new THREE.Mesh(winGeo, glassMat);
            windowMesh.position.set(0, 0.6, 1.11);
            houseGroup.add(windowMesh);

            // Front Door
            const doorGeo = new THREE.BoxGeometry(0.5, 0.9, 0.05);
            const woodMat = new THREE.MeshStandardMaterial({ color: 0x78350f, roughness: 0.7 });
            const doorMesh = new THREE.Mesh(doorGeo, woodMat);
            doorMesh.position.set(0.85, 0.45, 1.1);
            houseGroup.add(doorMesh);

            // Slab Separator
            const slabGeo = new THREE.BoxGeometry(2.5, 0.1, 2.5);
            const darkConcrete = new THREE.MeshStandardMaterial({ color: 0x334155, roughness: 0.7 });
            const slab = new THREE.Mesh(slabGeo, darkConcrete);
            slab.position.y = 1.25;
            slab.castShadow = true;
            slab.receiveShadow = true;
            houseGroup.add(slab);

            // Second Floor Building
            const secondFloorGeo = new THREE.BoxGeometry(1.6, 1.0, 1.8);
            const secondFloor = new THREE.Mesh(secondFloorGeo, wallMat);
            secondFloor.position.set(-0.25, 1.8, -0.1);
            secondFloor.castShadow = true;
            secondFloor.receiveShadow = true;
            houseGroup.add(secondFloor);

            // Top Window (Glass)
            const topWinGeo = new THREE.PlaneGeometry(1.2, 0.7);
            const topWindow = new THREE.Mesh(topWinGeo, glassMat);
            topWindow.position.set(-0.25, 1.8, 0.81);
            houseGroup.add(topWindow);

            // Roof Canopy
            const roofGeo = new THREE.BoxGeometry(1.9, 0.08, 2.1);
            const roof = new THREE.Mesh(roofGeo, darkConcrete);
            roof.position.set(-0.25, 2.34, -0.1);
            roof.castShadow = true;
            houseGroup.add(roof);

            // Tiny Tree Decoration
            const trunkGeo = new THREE.CylinderGeometry(0.06, 0.06, 0.8);
            const trunkMat = new THREE.MeshStandardMaterial({ color: 0x451a03, roughness: 0.9 });
            const trunk = new THREE.Mesh(trunkGeo, trunkMat);
            trunk.position.set(-1.4, 0.4, 1.3);
            trunk.castShadow = true;
            houseGroup.add(trunk);

            const leafGeo = new THREE.SphereGeometry(0.35, 8, 8);
            const leafMat = new THREE.MeshStandardMaterial({ color: 0x10b981, roughness: 0.8 });
            const leaf = new THREE.Mesh(leafGeo, leafMat);
            leaf.position.set(-1.4, 0.8, 1.3);
            leaf.castShadow = true;
            houseGroup.add(leaf);

            // Scene Lighting
            const ambient = new THREE.AmbientLight(0xffffff, 0.75);
            scene.add(ambient);

            const sunLight = new THREE.DirectionalLight(0xffffff, 0.85);
            sunLight.position.set(6, 10, 4);
            sunLight.castShadow = true;
            sunLight.shadow.mapSize.width = 1024;
            sunLight.shadow.mapSize.height = 1024;
            sunLight.shadow.bias = -0.001;
            scene.add(sunLight);

            // Orbit Target orientation
            camera.lookAt(0, 0.8, 0);

            // Mouse interaction logic
            let mouseX = 0;
            let mouseY = 0;
            let targetRotationX = 0;
            let targetRotationY = 0;

            window.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
                    mouseX = (x / rect.width) * 2 - 1;
                    mouseY = -(y / rect.height) * 2 + 1;
                }
            });

            // Loop ticket
            const tick = () => {
                // Autospin base
                targetRotationY += 0.003;

                // Adjust targets with mouse
                const rotY = targetRotationY + mouseX * 0.45;
                const rotX = mouseY * 0.15;

                // Smooth damp rotation
                houseGroup.rotation.y += (rotY - houseGroup.rotation.y) * 0.05;
                houseGroup.rotation.x += (rotX - houseGroup.rotation.x) * 0.05;

                renderer.render(scene, camera);
                window.requestAnimationFrame(tick);
            };
            tick();
        });
    </script>

</x-marketing-layout>