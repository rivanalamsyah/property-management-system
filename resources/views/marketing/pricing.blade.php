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

    <!-- Section 1: Hero Banner (UCD: Clear Value & Pricing Intent) -->
    <section class="pt-20 pb-12 text-center space-y-4 bg-gradient-to-b from-indigo-50/30 via-white to-white">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
            Paket Terjangkau &amp; Transparan
        </span>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">Harga Transparan Berkelanjutan Sesuai Skala Bisnis</h1>
        <p class="text-slate-600 text-sm max-w-lg mx-auto leading-relaxed">
            Pilih paket yang sesuai dengan jumlah kamar Anda. Mulai gratis untuk kos skala kecil, atau hitung estimasi penghematan operasional Anda di bawah ini.
        </p>
    </section>

    <!-- Section 2: Alpine.js Interactive ROI Calculator (UCD: User Control & Freedom) -->
    <section class="py-12 bg-white">
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
            class="p-8 bg-slate-50 border border-slate-200/80 rounded-3xl space-y-8 shadow-inner">
                
                <div class="text-center space-y-2">
                    <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Simulasi Penghematan Operasional Bulanan</h3>
                    <p class="text-xs text-slate-500">Geser pengatur di bawah untuk menghitung penghematan waktu administrasi dan potensi pendapatan yang terselamatkan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <!-- Sliders -->
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-slate-800">
                                <label for="rooms-range">Jumlah Kamar Kos</label>
                                <span class="text-indigo-600 font-extrabold" x-text="rooms + ' Kamar'"></span>
                            </div>
                            <input id="rooms-range" type="range" min="1" max="200" x-model="rooms" 
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-bold text-slate-800">
                                <label for="rent-range">Rata-Rata Sewa Bulanan</label>
                                <span class="text-indigo-600 font-extrabold" x-text="'Rp ' + (rent/1000000).toFixed(1) + ' Jt'"></span>
                            </div>
                            <input id="rent-range" type="range" min="1000000" max="10000000" step="500000" x-model="rent" 
                                   class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                        </div>
                    </div>

                    <!-- Computed Outputs -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 space-y-4 shadow-sm">
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5">
                            <span class="text-slate-500">Waktu Admin Terhemat</span>
                            <span class="font-bold text-slate-800" x-text="adminHoursSaved + ' jam/bln'"></span>
                        </div>
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5">
                            <span class="text-slate-500">Potensi Pendapatan Terelakkan</span>
                            <span class="font-bold text-slate-800" x-text="'Rp ' + recoveredLosses.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between text-xs border-b border-slate-100 pb-2.5">
                            <span class="text-slate-500">Biaya Platform Bulanan</span>
                            <span class="font-bold text-indigo-600" x-text="rooms <= 5 ? 'Gratis' : 'Rp ' + subscriptionCost.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Estimasi Penghematan</span>
                            <span class="text-xl font-black text-emerald-600" x-text="'Rp ' + netSavings.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Pricing Cards (UCD: Von Restorff Effect & Visual Contrast) -->
    <section class="py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tier 1: Gratis -->
            <x-card class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Pemula</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Paket Gratis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Cocok untuk pemilik kos skala kecil yang baru memulai otomatisasi digital.</p>
                    <div class="text-3xl font-black text-slate-900">Rp 0 <span class="text-xs font-normal text-slate-400">/selamanya</span></div>
                    
                    <ul class="text-xs text-slate-600 space-y-2.5 border-t border-slate-100 pt-4 font-medium">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Hingga 5 kamar aktif
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pencatatan penghuni &amp; kontrak
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Manajemen tiket keluhan dasar
                        </li>
                    </ul>
                </div>
                <x-button variant="outline" class="w-full text-center" onclick="window.location.href='{{ route('register') }}'">
                    Mulai Gratis
                </x-button>
            </x-card>

            <!-- Tier 2: Pertumbuhan (Featured) -->
            <div class="relative bg-white border-2 border-indigo-600 rounded-3xl p-6 shadow-2xl flex flex-col justify-between space-y-6 transform md:-translate-y-2">
                <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-[10px] font-black bg-indigo-600 text-white uppercase tracking-widest shadow-md">Paling Populer</span>
                <div class="space-y-4 pt-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-600 uppercase tracking-wider">Pertumbuhan</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Paket Pro</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Solusi lengkap untuk pengelola kos profesional yang ingin menghemat waktu.</p>
                    <div class="text-3xl font-black text-indigo-600">Rp 15rb <span class="text-xs font-normal text-slate-400">/kamar/bln</span></div>
                    
                    <ul class="text-xs text-slate-600 space-y-2.5 border-t border-slate-100 pt-4 font-medium">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Kamar tanpa batas (fleksibel)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Otomatisasi tagihan &amp; faktur bulanan
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Akses penuh portal PWA penghuni
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Ekspor laporan keuangan &amp; BI Analytics
                        </li>
                    </ul>
                </div>
                <x-button variant="primary" class="w-full text-center py-3" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
                </x-button>
            </div>

            <!-- Tier 3: Enterprise -->
            <x-card class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase tracking-wider">Kustom</span>
                    <h3 class="text-2xl font-extrabold text-slate-900">Enterprise</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Khusus pemilik jaringan kos skala besar, apartemen, atau properti komersial.</p>
                    <div class="text-3xl font-black text-slate-900">Hubungi Kami</div>
                    
                    <ul class="text-xs text-slate-600 space-y-2.5 border-t border-slate-100 pt-4 font-medium">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Multi-ruang kerja &amp; cabang tak terbatas
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Custom API &amp; Integrasi Payment Gateway
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Dedicated Account Manager &amp; SLA 99.9%
                        </li>
                    </ul>
                </div>
                <x-button variant="outline" class="w-full text-center" onclick="window.location.href='{{ route('contact') }}'">
                    Hubungi tim Sales
                </x-button>
            </x-card>
        </div>
    </section>

    <!-- Section 4: Feature Comparison Grid -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-8">
            <h3 class="text-2xl font-extrabold text-slate-900 text-center tracking-tight">Tabel Perbandingan Fitur Paket</h3>
            <x-table :headers="['Fitur Platform', 'Paket Pemula', 'Paket Pro', 'Enterprise']">
                <tr>
                    <td class="px-6 py-4 text-xs font-bold text-slate-800">Jumlah Kamar Aktif</td>
                    <td class="px-6 py-4 text-xs text-slate-600">Maks. 5 Kamar</td>
                    <td class="px-6 py-4 text-xs font-bold text-indigo-600">Tak Terbatas</td>
                    <td class="px-6 py-4 text-xs text-slate-600">Tak Terbatas</td>
                </tr>
                <tr class="bg-slate-50/50">
                    <td class="px-6 py-4 text-xs font-bold text-slate-800">Otomatisasi Tagihan &amp; Faktur</td>
                    <td class="px-6 py-4 text-xs text-rose-500 font-bold">&cross;</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Ya</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Ya</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-xs font-bold text-slate-800">Portal PWA Penghuni Digital</td>
                    <td class="px-6 py-4 text-xs text-slate-600">Dasar</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Penuh</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Penuh</td>
                </tr>
                <tr class="bg-slate-50/50">
                    <td class="px-6 py-4 text-xs font-bold text-slate-800">Ekspor Laporan Keuangan CSV</td>
                    <td class="px-6 py-4 text-xs text-rose-500 font-bold">&cross;</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Ya</td>
                    <td class="px-6 py-4 text-xs text-emerald-600 font-bold">&check; Ya</td>
                </tr>
            </x-table>
        </div>
    </section>

    <!-- Section 5: Trust Badges -->
    <section class="py-12 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-4 space-y-1">
                <span class="text-xl font-black text-indigo-600">99.9%</span>
                <p class="text-xs font-bold text-slate-700">Uptime Server SLA</p>
            </div>
            <div class="p-4 space-y-1">
                <span class="text-xl font-black text-indigo-600">256-Bit</span>
                <p class="text-xs font-bold text-slate-700">Enkripsi SSL/TLS</p>
            </div>
            <div class="p-4 space-y-1">
                <span class="text-xl font-black text-indigo-600">100%</span>
                <p class="text-xs font-bold text-slate-700">Isolasi Data Aset</p>
            </div>
            <div class="p-4 space-y-1">
                <span class="text-xl font-black text-indigo-600">24/7</span>
                <p class="text-xs font-bold text-slate-700">Bantuan Support</p>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="py-16 bg-slate-900 text-white text-center">
        <div class="max-w-4xl mx-auto px-6 space-y-6">
            <h2 class="text-3xl font-black tracking-tight">Mulai Otomatisasi Bisnis Kos Anda Hari Ini</h2>
            <p class="text-slate-400 text-sm max-w-lg mx-auto">Daftar sekarang untuk uji coba gratis 14 hari tanpa biaya tersembunyi.</p>
            <div class="pt-2">
                <x-button variant="primary" size="lg" class="px-8 py-3.5" onclick="window.location.href='{{ route('register') }}'">
                    Mulai Uji Coba Gratis 14 Hari
                </x-button>
            </div>
        </div>
    </section>

</x-marketing-layout>
