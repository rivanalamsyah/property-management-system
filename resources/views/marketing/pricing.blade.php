<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- FAQ Schema for pricing questions -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [{
        "@@type": "Question",
        "name": "Apakah saya dapat mengubah batasan jumlah kamar kapan saja?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Ya, skala biaya penagihan bersifat dinamis. Biaya bulanan Anda akan disesuaikan secara proporsional berdasarkan jumlah kamar aktif di katalog ruang kerja Anda."
        }
      },{
        "@@type": "Question",
        "name": "Apakah ada biaya setup awal atau kontrak mengikat?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Tidak ada sama sekali. Kosan adalah platform berlangganan bulanan tanpa kontrak jangka panjang. Anda bebas membatalkan langganan kapan saja."
        }
      }]
    }
    </script>
    @endpush

    <!-- Pricing Custom Mesh Styles -->
    <style>
        .pricing-mesh-1 {
            background-image: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.05) 0%, transparent 50%);
        }
        .pricing-mesh-2 {
            background-image: radial-gradient(circle at 90% 80%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
        }
    </style>

    <!-- Section 1: Hero Banner -->
    <section class="relative overflow-hidden pt-28 pb-12 text-center space-y-4 bg-slate-50/30 pricing-mesh-1">
        <div class="absolute top-0 right-1/4 w-80 h-80 bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Rencana Tarif Transparan
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Investasi Terbaik untuk <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Efisiensi Properti Anda</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                Pilih paket yang sesuai dengan jumlah kamar aktif Anda. Mulai secara gratis untuk kos skala kecil, atau hitung simulasi penghematan di bawah ini.
            </p>
        </div>
    </section>

    <!-- Section 2: Alpine.js Interactive ROI Calculator -->
    <section class="py-12 bg-white pricing-mesh-2">
        <div class="max-w-4xl mx-auto px-6">
            <div x-data="{ 
                rooms: 20, 
                rent: 2500000,
                get totalBilling() { return this.rooms * this.rent },
                get adminHoursSaved() { return Math.round(this.rooms * 0.25) },
                get recoveredLosses() { return Math.round(this.totalBilling * 0.02) },
                get subscriptionCost() { return this.rooms <= 5 ? 0 : this.rooms * 15000 },
                get netSavings() { return Math.max(0, this.recoveredLosses + (this.adminHoursSaved * 100000) - this.subscriptionCost) }
            }" 
            class="p-6 sm:p-8 bg-slate-50/70 border border-slate-200/80 rounded-3xl space-y-8 shadow-inner backdrop-blur-md">
                
                <div class="text-center space-y-2">
                    <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Simulasi Penghematan Operasional Bulanan</h3>
                    <p class="text-xs text-slate-500 font-medium">Geser pengatur di bawah untuk menghitung penghematan waktu administrasi dan potensi pendapatan sewa yang terselamatkan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    <!-- Sliders -->
                    <div class="md:col-span-7 space-y-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-xs font-extrabold text-slate-800">
                                <label for="rooms-range">Jumlah Kamar Kos</label>
                                <span class="text-indigo-650 font-black font-mono text-sm" x-text="rooms + ' Kamar'"></span>
                            </div>
                            <input id="rooms-range" type="range" min="1" max="200" x-model="rooms" 
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-xs font-extrabold text-slate-800">
                                <label for="rent-range">Tarif Sewa Rata-Rata</label>
                                <span class="text-indigo-650 font-black font-mono text-sm" x-text="'Rp ' + (rent/1000000).toFixed(1) + ' Jt'"></span>
                            </div>
                            <input id="rent-range" type="range" min="1000000" max="10000000" step="500000" x-model="rent" 
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                        </div>
                    </div>

                    <!-- Computed Outputs in high contrast card -->
                    <div class="md:col-span-5 bg-white border border-slate-200/80 rounded-2xl p-5 space-y-3.5 shadow-sm text-left">
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5 font-semibold">
                            <span class="text-slate-500">Waktu Terhemat</span>
                            <span class="text-slate-850 font-bold font-mono" x-text="adminHoursSaved + ' jam/bln'"></span>
                        </div>
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5 font-semibold">
                            <span class="text-slate-500">Potensi Selamat</span>
                            <span class="text-slate-850 font-bold font-mono" x-text="'Rp ' + recoveredLosses.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5 font-semibold">
                            <span class="text-slate-500">Biaya Platform</span>
                            <span class="text-indigo-600 font-bold font-mono" x-text="rooms <= 5 ? 'Gratis' : 'Rp ' + subscriptionCost.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-[10px] font-extrabold text-slate-800 uppercase tracking-wider">Bersih Terhemat</span>
                            <span class="text-lg font-black text-emerald-600 font-mono" x-text="'Rp ' + netSavings.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Pricing Cards -->
    <section class="py-16 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            
            <!-- Tier 1: Gratis -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Pemula</span>
                    <h3 class="text-2xl font-black text-slate-900">Paket Gratis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Cocok untuk pemilik kos skala kecil yang baru memulai digitalisasi.</p>
                    <div class="text-3xl font-black text-slate-900 font-mono">Rp 0 <span class="text-xs font-normal text-slate-455">/selamanya</span></div>
                    
                    <ul class="text-xs text-slate-650 space-y-3 border-t border-slate-100 pt-4 font-semibold">
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Hingga 5 kamar aktif</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Pencatatan hunian &amp; kontrak</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Manajemen tiket kerusakan dasar</span>
                        </li>
                    </ul>
                </div>
                <div class="space-y-2 pt-2">
                    <x-button variant="outline" class="w-full text-center border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                        Mulai Gratis
                    </x-button>
                    <p class="text-[10px] text-center text-slate-400 font-medium">Tanpa kartu kredit &bull; Akses langsung</p>
                </div>
            </div>

            <!-- Tier 2: Pro (Featured with Rotating Border Glow Effect!) -->
            <div class="overflow-hidden rounded-3xl p-[1.5px] relative flex flex-col justify-stretch md:-translate-y-2 shadow-2xl bg-white border border-slate-200/50">
                <!-- Glowing background mask -->
                <div class="absolute inset-[-1000%] animate-[spin_6s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#818cf8_0%,#c084fc_25%,#e0e7ff_50%,#c084fc_75%,#818cf8_100%)]"></div>
                
                <!-- Inner container card -->
                <div class="bg-white rounded-[22px] p-6 relative flex flex-col justify-between h-full space-y-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200/50 uppercase tracking-wider">Pro</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[8.5px] font-black bg-indigo-600 text-white uppercase tracking-widest shadow-sm">Terpopuler</span>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900">Paket Pertumbuhan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Solusi lengkap untuk mengotomatisasikan pembukuan &amp; pelunasan sewa.</p>
                        <div class="text-3xl font-black text-indigo-600 font-mono">Rp 15rb <span class="text-xs font-normal text-slate-400">/kamar/bln</span></div>
                        
                        <ul class="text-xs text-slate-650 space-y-3 border-t border-slate-100 pt-4 font-semibold">
                            <li class="flex items-center gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span>Kamar tak terbatas (dinamis)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span>Faktur otomatis &amp; penagihan sewa</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span>Akses penuh PWA Portal Penghuni</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2 pt-2">
                        <x-button variant="primary" class="w-full text-center shadow-md shadow-indigo-500/20 cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                            Mulai Coba Gratis 14 Hari
                        </x-button>
                        <p class="text-[10px] text-center text-slate-400 font-medium">Bebas uji coba tanpa ikatan kartu kredit</p>
                    </div>
                </div>
            </div>

            <!-- Tier 3: Enterprise -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="px-2.5 py-0.5 rounded text-[9px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Kustom</span>
                    <h3 class="text-2xl font-black text-slate-900">Paket Enterprise</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Dirancang untuk korporasi pengelola sewa skala ratusan kamar.</p>
                    <div class="text-3xl font-black text-slate-900 font-mono">Hubungi Sales</div>
                    
                    <ul class="text-xs text-slate-655 space-y-3 border-t border-slate-100 pt-4 font-semibold">
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Integrasi Virtual Account kustom</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Akses prioritas API &amp; Webhook</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span>Perjanjian SLAs &amp; Akun Manajer Khusus</span>
                        </li>
                    </ul>
                </div>
                <div class="space-y-2 pt-2">
                    <x-button variant="outline" class="w-full text-center border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer" onclick="window.location.href='{{ route('contact') }}'">
                        Jadwalkan Demo
                    </x-button>
                    <p class="text-[10px] text-center text-slate-400 font-medium">Konsultasi gratis 1-on-1</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Buyer FAQs -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            <h3 class="text-2xl font-black text-slate-900 text-center tracking-tight">Pertanyaan yang Sering Diajukan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div class="space-y-2.5 p-5 rounded-2xl border border-slate-100 hover:bg-slate-50 transition duration-200">
                    <h4 class="font-bold text-slate-800 text-xs">Apakah saya dapat mengubah batasan jumlah kamar kapan saja?</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium">Ya, skala biaya penagihan bersifat dinamis. Biaya bulanan Anda akan disesuaikan secara proporsional berdasarkan jumlah kamar aktif di katalog ruang kerja Anda.</p>
                </div>
                
                <div class="space-y-2.5 p-5 rounded-2xl border border-slate-100 hover:bg-slate-50 transition duration-200">
                    <h4 class="font-bold text-slate-800 text-xs">Apakah ada biaya setup awal atau kontrak mengikat?</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium">Tidak ada sama sekali. Kosan adalah platform berlangganan bulanan tanpa kontrak jangka panjang. Anda bebas membatalkan langganan kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

</x-marketing-layout>
