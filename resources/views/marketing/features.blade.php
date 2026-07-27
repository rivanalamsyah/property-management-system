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

    <!-- Custom Micro-animations Styles for Features page -->
    <style>
        .feature-grid-glow {
            background-image: radial-gradient(circle at top right, rgba(99, 102, 241, 0.04), transparent 60%);
        }
        @keyframes meterPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }
        .meter-pulse-dot {
            animation: meterPulse 1.8s infinite;
        }
    </style>

    <!-- Section 1: Hero Banner (Value Proposition) -->
    <section class="relative overflow-hidden pt-28 pb-16 text-center space-y-6 bg-slate-50/30">
        <!-- Ambient mesh blurs -->
        <div class="absolute top-0 left-1/3 w-[350px] h-[350px] bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Kosan OS v2.4 Feature Capabilities
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-slate-900 leading-tight">
                Modul Canggih untuk <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Efisiensi Kos Maksimal</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-2xl mx-auto leading-relaxed font-medium">
                Gantikan proses manual dengan 10 modul otomatisasi terintegrasi. Dirancang untuk mempercepat pelunasan sewa, merapikan pembukuan, dan memperlancar alur komplain.
            </p>
        </div>
    </section>

    <!-- Deep Dive Features (10 UCD Sections Grouped by Tabs) -->
    <div x-data="{ activeTab: 'properti' }" class="pb-24 space-y-16">
        <!-- Tabs Navigation inside glass card -->
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white/80 backdrop-blur-md border border-slate-200/60 p-2 rounded-2xl shadow-sm flex flex-wrap justify-center gap-2">
                <button @click="activeTab = 'properti'" :class="activeTab === 'properti' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" class="px-5 py-3 rounded-xl text-xs font-extrabold transition cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Pengelolaan Properti (Modul 1-4)</span>
                </button>
                <button @click="activeTab = 'keuangan'" :class="activeTab === 'keuangan' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" class="px-5 py-3 rounded-xl text-xs font-extrabold transition cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Keuangan &amp; Verifikasi (Modul 5-8)</span>
                </button>
                <button @click="activeTab = 'penghuni'" :class="activeTab === 'penghuni' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50'" class="px-5 py-3 rounded-xl text-xs font-extrabold transition cursor-pointer flex items-center gap-2">
                    <svg class="w-4 h-4 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span>Portal Penghuni (Modul 9-10)</span>
                </button>
            </div>
        </div>

        <div class="space-y-24">
            <!-- GROUP 1: properti -->
            <div x-show="activeTab === 'properti'" x-transition class="space-y-24">
                
                <!-- Module 01: Executive Command Dashboard -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 01</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Pusat Kontrol Eksekutif (Command Dashboard)</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Pantau kesehatan finansial dan operasional seluruh unit dari satu layar sentral. Dapatkan visualisasi okupansi harian, status kas masuk, serta ringkasan tiket komplain yang butuh delegasi secepatnya.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mengurangi waktu audit mingguan pemilik kos hingga 5 jam.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Command Center Simulator -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner relative"
                         x-data="{ revenue: 42200000 }" x-init="setInterval(() => { revenue += 1500000 }, 4000)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Executive Overview</span>
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="text-[8.5px] uppercase font-bold text-slate-400">Total Pendapatan (Bulan Ini)</span>
                                <div class="flex items-baseline gap-2">
                                    <h4 class="text-xl font-black text-slate-800 font-mono">Rp <span x-text="revenue.toLocaleString('id-ID')"></span></h4>
                                    <span class="text-[9px] font-extrabold text-emerald-600">+12%</span>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between text-[9px] font-bold text-slate-650">
                                    <span>Tingkat Keterisian Kamar</span>
                                    <span>92.4%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: 92%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 02: Room & Utilities Management -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 lg:order-2 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 02</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Manajemen Kamar &amp; Pencatatan Meteran Digital</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Kelompokkan kamar berdasarkan gedung, lantai, atau tipe tarif. Dukung pencatatan posisi kWh meteran listrik/air secara digital yang mudah dicocokkan saat tagihan bulanan diterbitkan.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mengeliminasi perselisihan tagihan air/listrik dengan penghuni.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Meter Simulator -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ kwh: 384.20 }" x-init="setInterval(() => { kwh = +(kwh + 0.05).toFixed(2) }, 1000)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-4">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Meter Listrik Pintar</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 meter-pulse-dot"></span>
                                    <span class="text-[8px] text-slate-400 font-bold font-mono">Live kWh</span>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-slate-900 rounded-xl border border-slate-800 flex justify-between items-center text-white">
                                <div class="space-y-0.5">
                                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Kamar 102 (VIP)</span>
                                    <h5 class="text-xs font-bold text-slate-200">BCA Prabayar</h5>
                                </div>
                                <div class="text-xl font-black text-emerald-400 font-mono tracking-widest">
                                    <span x-text="kwh.toFixed(2)"></span> <span class="text-[10px] text-slate-400">kWh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 03: Tenant Management -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 03</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Manajemen Profil &amp; Riwayat Penghuni</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Simpan dokumen identitas penghuni (KTP/KTM), nomor kontak darurat, serta data check-in check-out secara terpusat. Dilengkapi status deteksi otomatis blacklist untuk penghuni bermasalah.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Tertib administrasi hukum sesuai regulasi sewa hunian daerah.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Staggered Avatar list -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner relative overflow-hidden group">
                        <div class="absolute -inset-10 bg-indigo-100/10 pointer-events-none rounded-full blur-xl transition-all duration-500 group-hover:scale-110"></div>
                        
                        <div class="w-full max-w-sm space-y-3 relative z-10">
                            <!-- Card 1 -->
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-3 shadow-md flex items-center justify-between transition-transform duration-300 hover:-translate-y-0.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-650 text-white flex items-center justify-center font-bold text-xs shadow-sm">RA</div>
                                    <div class="text-left">
                                        <h5 class="text-xs font-bold text-slate-800">Rivaldi Alamsyah</h5>
                                        <span class="text-[8.5px] text-slate-400 font-medium">Kamar 101 &bull; Aktif</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[8px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/40">LUNAS</span>
                            </div>

                            <!-- Card 2 -->
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-3 shadow-md flex items-center justify-between transition-transform duration-300 hover:-translate-y-0.5 translate-x-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">SP</div>
                                    <div class="text-left">
                                        <h5 class="text-xs font-bold text-slate-800">Siti Permata</h5>
                                        <span class="text-[8.5px] text-slate-400 font-medium">Kamar 203 &bull; Aktif</span>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[8px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200/40">PENDING</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 04: Contract & Deposit Management -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 lg:order-2 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 04</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Pelacak Kontrak Digital &amp; Deposit Jaminan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Kelola periode sewa aktif, cetak otomatis faktur jaminan deposit saat pendaftaran, serta hitung otomatis pemotongan deposit sewa jika ada tunggakan tagihan saat checkout.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mengamankan properti dari kerugian kerusakan fasilitas lewat sistem deposit deposit.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Contract Builder -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ approved: false }" x-init="setInterval(() => { approved = !approved }, 3000)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-3 relative overflow-hidden">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] uppercase font-extrabold text-slate-400">Kontrak Sewa #CTR-018</span>
                                <span class="text-[8px] font-mono text-slate-450">Tgl: 27 Jul 2026</span>
                            </div>
                            
                            <div class="space-y-1 text-left">
                                <h5 class="text-xs font-bold text-slate-800">Skema: Sewa Kamar Bulanan</h5>
                                <p class="text-[10px] text-slate-500">Masa Kontrak: 12 Bulan (Juli 2026 - Juli 2027)</p>
                            </div>

                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-150 flex justify-between items-center">
                                <span class="text-[9px] font-bold text-slate-650">Jaminan Deposit:</span>
                                <span class="text-xs font-black text-slate-800">Rp 1.000.000</span>
                            </div>

                            <div class="flex items-center gap-2 justify-center pt-2">
                                <span class="w-2 h-2 rounded-full transition-colors duration-300"
                                      :class="approved ? 'bg-emerald-500' : 'bg-amber-400'"></span>
                                <span class="text-[9px] font-extrabold uppercase tracking-widest text-slate-600"
                                      x-text="approved ? 'Dokumen Disetujui' : 'Menunggu Tanda Tangan'"></span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- GROUP 2: keuangan -->
            <div x-show="activeTab === 'keuangan'" x-transition class="space-y-24">
                
                <!-- Module 05: Invoicing & Billing -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 05</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Otomatisasi Penagihan &amp; Pembuatan Faktur</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Faktur tagihan bulanan dibuat secara otomatis dan dikirim melalui WhatsApp &amp; email ke penghuni sebelum tanggal jatuh tempo. Bebas hitung satu per satu pengeluaran laundry atau tambahan listrik token.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Meningkatkan pelunasan tagihan tepat waktu hingga 95%.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Invoice Builder Loop -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ total: 1500000, activeAddon: false }" x-init="setInterval(() => { activeAddon = !activeAddon; total = activeAddon ? 1620000 : 1500000 }, 2500)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-3 text-left">
                            <span class="text-[9px] uppercase font-extrabold text-slate-400">Preview Invoice #INV-2026</span>
                            
                            <div class="space-y-1.5 text-xs text-slate-700 font-semibold border-y border-slate-100 py-2">
                                <div class="flex justify-between">
                                    <span>Biaya Kamar Sewa</span>
                                    <span>Rp 1.500.000</span>
                                </div>
                                <div class="flex justify-between text-indigo-600 transition-opacity duration-300" :class="activeAddon ? 'opacity-100' : 'opacity-30'">
                                    <span>Tambahan Laundry (Bulanan)</span>
                                    <span>Rp 120.000</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-1">
                                <span class="text-xs font-bold text-slate-800">Total Tagihan:</span>
                                <span class="text-sm font-black text-indigo-600 font-mono transition-all duration-300" x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 06: Verification & Bank Ledger Audit -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 lg:order-2 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 06</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Verifikasi Bukti Transfer Bank Instan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Cocokkan nomor transaksi bank yang dikirim penghuni secara langsung. Konfirmasi otomatis status transaksi lunas atau kirim alasan penolakan jika nomor referensi mutasi tidak ditemukan.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mengamankan keuangan dari penipuan manipulasi gambar struk transfer bank.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Verification pulse -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ matching: true }" x-init="setInterval(() => { matching = !matching }, 3500)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-4 text-left relative overflow-hidden">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] uppercase font-extrabold text-slate-400">Verifikasi Bukti Transfer</span>
                                <span class="text-[8.5px] font-bold text-indigo-600 font-mono">BCA Bank</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="space-y-0.5">
                                    <span class="text-[8.5px] uppercase font-bold text-slate-450">Mutasi BCA Terlacak</span>
                                    <h5 class="text-xs font-black text-slate-800">Rp 1.500.000</h5>
                                </div>
                                
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                     :class="matching ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/50' : 'bg-indigo-50 text-indigo-600 border border-indigo-200/50'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" x-show="matching" d="M5 13l4 4L19 7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" x-show="!matching" d="M12 8v4l3 3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 07: Maintenance Tickets -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 07</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Manajemen Laporan Kerusakan &amp; Tiket Teknisi</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Fasilitasi laporan komplain penghuni (seperti kebocoran air, AC mati, dll) lewat tiket digital. Delegasikan langsung penugasan kerja kepada teknisi internal dan pantau status penyelesaiannya secara transparan.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mempertahankan durasi tinggal penghuni kos lewat respon perbaikan yang tanggap.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Ticket life cycle simulator -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ step: 1 }" x-init="setInterval(() => { step = step === 3 ? 1 : step + 1 }, 3000)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-4 text-left">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                                <span class="text-[9px] uppercase font-extrabold text-slate-400">Laporan Keluhan #309</span>
                                <span class="text-[8.5px] px-2 py-0.5 rounded-full font-extrabold uppercase"
                                      :class="step === 1 ? 'bg-rose-50 text-rose-600 border border-rose-200/40' : step === 2 ? 'bg-amber-50 text-amber-600 border border-amber-200/40' : 'bg-emerald-50 text-emerald-600 border border-emerald-200/40'"
                                      x-text="step === 1 ? 'Diajukan' : step === 2 ? 'Staf Ditugaskan' : 'Selesai'"></span>
                            </div>

                            <div class="space-y-1">
                                <h5 class="text-xs font-bold text-slate-800">Judul Laporan: Saluran Air Kamar Mandi Tersumbat</h5>
                                <p class="text-[9.5px] text-slate-500 font-medium">Pelapor: Kamar 104 (Budi Santoso)</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 08: Financial & Business Analytics -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 lg:order-2 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 08</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Analisis Keuangan &amp; Business Intelligence</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Visualisasikan data arus kas masuk-keluar secara akurat, profitabilitas antar gedung kos, dan laporan rugi laba bersih bulanan secara instan untuk kebutuhan ekspansi.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mempermudah penentuan tarif kamar ideal sesuai analisis okupansi pasar.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: SVG Bar charts animation on load/hover -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner group">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-4 text-left">
                            <span class="text-[9px] uppercase font-extrabold text-slate-400">Pertumbuhan Kas Properti</span>
                            
                            <!-- Simple custom inline SVG Bar Chart -->
                            <div class="flex items-end justify-between h-24 pt-4 border-b border-slate-100">
                                <div class="w-8 bg-indigo-200 rounded-t-lg transition-all duration-700 group-hover:h-[40%]" style="height: 25%"></div>
                                <div class="w-8 bg-indigo-300 rounded-t-lg transition-all duration-700 group-hover:h-[60%]" style="height: 40%"></div>
                                <div class="w-8 bg-indigo-400 rounded-t-lg transition-all duration-700 group-hover:h-[75%]" style="height: 55%"></div>
                                <div class="w-8 bg-indigo-600 rounded-t-lg transition-all duration-700 group-hover:h-[95%]" style="height: 70%"></div>
                            </div>
                            
                            <div class="flex justify-between text-[8px] text-slate-400 font-bold font-mono">
                                <span>Maret</span>
                                <span>April</span>
                                <span>Mei</span>
                                <span>Juni (Live)</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- GROUP 3: penghuni -->
            <div x-show="activeTab === 'penghuni'" x-transition class="space-y-24">
                
                <!-- Module 09: PWA Resident Portal -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 09</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Portal Digital Mandiri Penghuni (PWA App)</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Permudah penghuni kos dengan portal berbasis PWA yang ringan. Penghuni dapat mengecek nominal tagihan sewa, mengunggah bukti bayar, dan melacak proses tiket keluhan dari smartphone masing-masing.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mengurangi beban admin operasional hingga 80% lewat portal sewa mandiri.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Smartphone screen mock -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner">
                        <div class="w-48 h-[240px] bg-slate-900 rounded-[28px] p-2 shadow-xl border-4 border-slate-800 relative">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-16 h-3 bg-slate-800 rounded-b-lg"></div>
                            <div class="w-full h-full bg-white rounded-[20px] overflow-hidden p-2.5 flex flex-col justify-between">
                                <div class="space-y-2 text-left">
                                    <span class="text-[8px] font-extrabold text-slate-400">Portal Penghuni</span>
                                    <div class="p-2 bg-indigo-50 text-indigo-700 rounded-lg space-y-0.5 border border-indigo-100">
                                        <h6 class="text-[9px] font-black">Kamar 102 &bull; Tagihan Aktif</h6>
                                        <p class="text-[8px] font-medium font-mono">Rp 1.500.000</p>
                                    </div>
                                </div>
                                <button class="w-full py-1.5 bg-indigo-600 text-white font-bold text-[8.5px] rounded-lg shadow-sm">Kirim Bukti Bayar</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Module 10: Multi-Tenant Workspace & Role-based Access Control -->
                <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center feature-grid-glow py-8 rounded-3xl border border-transparent hover:border-slate-200/30 transition duration-300">
                    <div class="lg:col-span-5 lg:order-2 space-y-4">
                        <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md">Modul 10</span>
                        <h3 class="text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">Hak Akses Multi-Tenant &amp; Pembagian Tim</h3>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            Atur izin delegasi khusus bagi manajer kos cabang atau staf lapangan. Mengisolasi pencatatan keuangan dan data hunian antar cabang properti agar tidak terjadi tumpang tindih data.
                        </p>
                        <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-[11px] text-indigo-700 font-bold inline-flex items-center gap-2 shadow-2xs">
                            <svg class="w-4.5 h-4.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Dampak ROI: Mempermudah skalabilitas pengelolaan properti dari 1 hingga puluhan lokasi cabang.</span>
                        </div>
                    </div>
                    
                    <!-- Interactive Visual Mockup: Workspace switcher dropdown demo -->
                    <div class="lg:col-span-7 p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[260px] flex items-center justify-center shadow-inner"
                         x-data="{ activeWorkspace: 'Cihampelas Residence', open: false }" x-init="setInterval(() => { open = !open }, 3000)">
                        <div class="w-full max-w-sm bg-white border border-slate-200/85 rounded-2xl p-4 shadow-xl space-y-3 text-left relative min-h-[140px]">
                            <span class="text-[9px] uppercase font-extrabold text-slate-400">Pilih Cabang Properti</span>
                            
                            <!-- Dropdown Sim -->
                            <div class="p-2.5 border border-slate-200 rounded-xl flex justify-between items-center cursor-pointer bg-slate-50">
                                <span class="text-xs font-bold text-slate-800" x-text="activeWorkspace"></span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>

                            <!-- Simulating Dropdown items -->
                            <div class="absolute left-4 right-4 bg-white border border-slate-200 rounded-xl shadow-lg p-1.5 space-y-1 z-20 transition-all duration-300"
                                 x-show="open" x-transition>
                                <div class="px-3 py-2 text-xs font-bold text-slate-800 hover:bg-slate-50 rounded-lg">Cihampelas Residence</div>
                                <div class="px-3 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg" @click="activeWorkspace = 'Dago Suites'; open = false">Dago Suites</div>
                                <div class="px-3 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg" @click="activeWorkspace = 'Paradise Residence'; open = false">Paradise Residence</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Bottom Feature CTA Banner -->
    <section class="py-20 bg-gradient-to-tr from-indigo-900 via-indigo-950 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.25),transparent_45%)]"></div>
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Siap Mengoptimalisasi Bisnis Kos Anda Sekarang?
            </h2>
            <p class="text-indigo-200/90 text-sm max-w-xl mx-auto leading-relaxed font-normal">
                Mulai uji coba gratis 14 hari dan nikmati kemudahan pengelolaan hunian tanpa batas ruang kerja.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                <x-button variant="primary" size="lg" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 !border-white w-full sm:w-auto text-center font-bold px-8 py-3.5 shadow-lg cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Mulai Uji Coba Gratis
                </x-button>
                <x-button variant="outline" size="lg" class="!border-indigo-400/30 !text-white hover:!bg-white/10 w-full sm:w-auto text-center px-8 py-3.5 cursor-pointer" onclick="window.location.href='{{ route('contact') }}'">
                    Hubungi Sales &amp; Demo
                </x-button>
            </div>
            <p class="text-xs text-indigo-300/80 font-medium">Tanpa kartu kredit &bull; Pengaturan 2 menit &bull; Batalkan kapan saja</p>
        </div>
    </section>

</x-marketing-layout>
