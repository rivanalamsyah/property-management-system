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
        "name": "Harga",
        "item": "{{ route('pricing') }}"
      }]
    }
    </script>

    <!-- FAQ Schema for pricing questions -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FAQPage",
      "mainEntity": [{
        "@@type": "Question",
        "name": "Apakah tersedia uji coba gratis?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Ya, kami menyediakan uji coba gratis selama 14 hari dengan akses ke semua fitur premium tanpa memerlukan kartu kredit."
        }
      },{
        "@@type": "Question",
        "name": "Apakah memerlukan kartu kredit untuk mendaftar?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Tidak. Anda dapat mendaftar dan mencoba platform Kosan secara gratis selama 14 hari penuh tanpa memasukkan data kartu kredit."
        }
      },{
        "@@type": "Question",
        "name": "Apakah saya dapat mengubah batasan jumlah kamar kapan saja?",
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": "Ya, sistem langganan Kosan sangat fleksibel. Tagihan Anda akan disesuaikan secara otomatis berdasarkan jumlah kamar aktif pada setiap periode penagihan."
        }
      }]
    }
    </script>
    @endpush

    <!-- Pricing Custom Mesh & Gradient Styles -->
    <style>
        .pricing-mesh-1 {
            background-image: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.06) 0%, transparent 60%);
        }
        .pricing-mesh-2 {
            background-image: radial-gradient(circle at 90% 80%, rgba(168, 85, 247, 0.06) 0%, transparent 60%);
        }
        .pricing-glow-indigo {
            background-image: radial-gradient(circle at top right, rgba(99, 102, 241, 0.08), transparent 60%);
        }
    </style>

    <!-- SECTION 1: HERO SECTION -->
    <section class="relative overflow-hidden pt-28 pb-16 text-center space-y-6 bg-slate-50/40 pricing-mesh-1">
        <!-- Ambient mesh blurs -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10 animate-pulse"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 border border-indigo-100/80 text-indigo-750 shadow-2xs mx-auto">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Rencana Tarif Adil &amp; Tanpa Biaya Tersembunyi
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.1]">
                Investasi Cerdas untuk <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Efisiensi Bisnis Properti Anda</span>
            </h1>
            <p class="text-slate-550 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed font-medium">
                Pilih paket transparan yang tumbuh bersama skala properti Anda. Kurangi beban kerja manual administrasi, hilangkan risiko bukti transfer palsu, dan nikmati ROI positif sejak bulan pertama.
            </p>
        </div>

        <!-- Hero Actions -->
        <div class="space-y-4 pt-4">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 max-w-md mx-auto px-6">
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
            <!-- Trust badges below CTA -->
            <div class="flex flex-wrap items-center justify-center gap-5 text-[10.5px] font-bold text-slate-400 uppercase tracking-wider">
                <span>✓ Tanpa Kartu Kredit</span>
                <span>•</span>
                <span>✓ Onboarding Dibantu Staf</span>
                <span>•</span>
                <span>✓ Cancel Kapan Saja</span>
            </div>
        </div>
    </section>

    <!-- SECTION 2: KALKULATOR ROI INTERAKTIF -->
    <section class="py-16 bg-white pricing-mesh-2">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            <!-- Headers -->
            <div class="text-center space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Kalkulator Keuntungan</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">Hitung Estimasi Keuntungan Bersih Anda</h3>
                <p class="text-slate-500 text-xs sm:text-sm max-w-xl mx-auto font-medium">
                    Geser parameter di bawah sesuai kondisi bisnis properti Anda saat ini dan lihat berapa banyak waktu serta pengeluaran operasional yang berhasil diselamatkan menggunakan platform Kosan.
                </p>
            </div>

            <!-- Calculator Board -->
            <div x-data="{
                properties: 1,
                rooms: 20,
                rent: 2000000,
                staff: 1,
                adminHours: 3,
                get totalRevenue() { return this.rooms * this.rent },
                get hoursSaved() { return Math.round(this.rooms * this.adminHours * 0.75) },
                get staffCostSaved() { return this.hoursSaved * 40000 },
                get leakageSaved() { return Math.round(this.totalRevenue * 0.03) }, // assumes 3% loss due to manual delay / fraud
                get subscriptionCost() { return this.rooms <= 5 ? 0 : this.rooms * 15000 },
                get netBenefit() { return Math.max(0, (this.staffCostSaved + this.leakageSaved) - this.subscriptionCost) }
            }" class="p-6 sm:p-8 bg-slate-50 border border-slate-200 rounded-3xl grid grid-cols-1 lg:grid-cols-12 gap-8 shadow-inner">
                
                <!-- Inputs Column (7 Cols) -->
                <div class="lg:col-span-7 space-y-6 text-left">
                    <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-200 pb-2">Kondisi Bisnis Saat Ini</h4>
                    
                    <!-- Slider 1: Properties -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold text-slate-800">
                            <label for="properties-input">Jumlah Cabang / Properti</label>
                            <span class="text-indigo-650 font-extrabold font-mono" x-text="properties + ' Lokasi'"></span>
                        </div>
                        <input id="properties-input" type="range" min="1" max="10" x-model="properties" class="w-full h-2 bg-slate-250 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                    </div>

                    <!-- Slider 2: Rooms -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold text-slate-800">
                            <label for="rooms-input">Total Kamar Aktif</label>
                            <span class="text-indigo-650 font-extrabold font-mono" x-text="rooms + ' Kamar'"></span>
                        </div>
                        <input id="rooms-input" type="range" min="5" max="300" step="5" x-model="rooms" class="w-full h-2 bg-slate-250 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                    </div>

                    <!-- Slider 3: Rent -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold text-slate-800">
                            <label for="rent-input">Tarif Sewa Rata-rata / Bulan</label>
                            <span class="text-indigo-650 font-extrabold font-mono" x-text="'Rp ' + (rent/1000000).toFixed(1) + ' Juta'"></span>
                        </div>
                        <input id="rent-input" type="range" min="1000000" max="10000000" step="500000" x-model="rent" class="w-full h-2 bg-slate-250 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                    </div>

                    <!-- Slider 4: Staff Hours -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold text-slate-800">
                            <label for="hours-input">Waktu Kerja Admin (per Kamar/Bulan)</label>
                            <span class="text-indigo-650 font-extrabold font-mono" x-text="adminHours + ' Jam'"></span>
                        </div>
                        <input id="hours-input" type="range" min="1" max="10" x-model="adminHours" class="w-full h-2 bg-slate-250 rounded-lg appearance-none cursor-pointer accent-indigo-600" />
                    </div>
                </div>

                <!-- Outputs Column (5 Cols) -->
                <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-5 flex flex-col justify-between shadow-sm text-left">
                    <div class="space-y-4">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Hasil Analisis ROI</h4>
                        
                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-slate-500">Waktu Terhemat</span>
                            <span class="text-slate-800 font-bold font-mono" x-text="hoursSaved + ' Jam / Bln'"></span>
                        </div>

                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-slate-500">Pengurangan Kerja Manual</span>
                            <span class="text-slate-800 font-bold font-mono">Hingga 75%</span>
                        </div>

                        <div class="flex justify-between text-xs font-semibold">
                            <span class="text-slate-500">Estimasi Uang Terselamatkan</span>
                            <span class="text-slate-800 font-bold font-mono" x-text="'Rp ' + (staffCostSaved + leakageSaved).toLocaleString('id-ID')"></span>
                        </div>

                        <div class="flex justify-between text-xs font-semibold border-b border-slate-100 pb-3">
                            <span class="text-slate-500">Biaya Platform Kosan</span>
                            <span class="text-indigo-650 font-bold font-mono" x-text="rooms <= 5 ? 'Gratis' : 'Rp ' + subscriptionCost.toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-1.5">
                        <span class="text-[9px] uppercase font-extrabold text-slate-400 block tracking-widest">Keuntungan Bersih Tambahan</span>
                        <div class="text-2xl font-black text-emerald-600 font-mono" x-text="'Rp ' + netBenefit.toLocaleString('id-ID') + ' / Bln'"></div>
                        <span class="text-[9px] text-slate-400 font-semibold block">Telah dikurangi biaya berlangganan Kosan.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: PAKET HARGA -->
    <section class="py-20 bg-slate-50/40 border-y border-slate-200/50" x-data="{ billingPeriod: 'monthly' }">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            <!-- Headers -->
            <div class="max-w-3xl mx-auto text-center space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Rencana Langganan</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">Pilih Paket Sesuai Skala Properti Anda</h3>
                <p class="text-slate-550 text-xs sm:text-sm font-medium">
                    Tidak ada biaya terselubung. Tingkatkan kapasitas kamar aktif kapan saja atau batalkan langganan tanpa penalti.
                </p>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[10.5px] font-black bg-rose-50 border border-rose-200/50 text-rose-600 shadow-2xs mx-auto animate-pulse">
                    ⚡ Promo Terbatas: Diskon 70% Berlaku Hingga 2027!
                </div>

                <!-- Billing toggle -->
                <div class="flex justify-center pt-2">
                    <div class="relative bg-slate-200/60 p-1 rounded-xl flex items-center gap-1 border border-slate-250/30">
                        <button @click="billingPeriod = 'monthly'" :class="billingPeriod === 'monthly' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer">Bulanan</button>
                        <button @click="billingPeriod = 'yearly'" :class="billingPeriod === 'yearly' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                            Tahunan
                            <span class="px-1.5 py-0.5 rounded-md bg-indigo-50 text-indigo-600 text-[9px] font-extrabold uppercase">Hemat 2 Bulan</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cards grid (4 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                <!-- Paket Starter -->
                <div class="bg-white border border-slate-200 rounded-3xl p-5 shadow-xs flex flex-col justify-between space-y-6 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="space-y-5">
                        <div class="space-y-1 text-left">
                            <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-slate-100 text-slate-500 uppercase tracking-widest font-mono">STARTER</span>
                            <h4 class="text-lg font-black text-slate-900">Starter Plan</h4>
                            <p class="text-xs text-slate-450 leading-relaxed font-medium">Ideal untuk pemilik properti kos tunggal yang baru memulai.</p>
                        </div>
                        <div class="space-y-1.5 text-left">
                            <span class="text-xs font-bold text-slate-400 line-through">
                                <span x-show="billingPeriod === 'monthly'">Rp 149.000</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 1.490.000</span>
                            </span>
                            <div class="text-2xl font-black text-slate-900 font-mono text-left flex items-baseline gap-1">
                                <span x-show="billingPeriod === 'monthly'">Rp 44.700</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 447.000</span>
                                <span class="text-xs font-normal text-slate-450">/ <span x-text="billingPeriod === 'monthly' ? 'bln' : 'thn'"></span></span>
                            </div>
                        </div>
                        
                        <ul class="text-xs text-slate-600 space-y-3 border-t border-slate-100 pt-4 font-semibold text-left">
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Maksimal 5 Kamar Aktif</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Maksimal 5 Penghuni</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>1 Akun Staf Operasional</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>1 Lokasi / Properti</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>100 MB Penyimpanan Data</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Broadcast Pengumuman</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <x-button variant="outline" class="w-full text-center border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer text-xs py-2.5 font-bold !text-slate-800 hover:!text-slate-955" onclick="window.location.href='{{ route('register') }}'">
                            Mulai Coba Gratis
                        </x-button>
                        <p class="text-[9.5px] text-center text-slate-400 font-semibold">Uji coba 14 hari &bull; Cancel kapan saja</p>
                    </div>
                </div>

                <!-- Paket Professional -->
                <div class="bg-white border border-slate-200 rounded-3xl p-5 shadow-xs flex flex-col justify-between space-y-6 hover:shadow-md hover:-translate-y-1 transition duration-300">
                    <div class="space-y-5">
                        <div class="space-y-1 text-left">
                            <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-200/50 uppercase tracking-widest font-mono">PROFESSIONAL</span>
                            <h4 class="text-lg font-black text-slate-900">Professional Plan</h4>
                            <p class="text-xs text-slate-450 leading-relaxed font-medium">Bagus untuk properti standar dengan jumlah penghuni berkembang.</p>
                        </div>
                        <div class="space-y-1.5 text-left">
                            <span class="text-xs font-bold text-slate-400 line-through">
                                <span x-show="billingPeriod === 'monthly'">Rp 399.000</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 3.990.000</span>
                            </span>
                            <div class="text-2xl font-black text-slate-900 font-mono text-left flex items-baseline gap-1">
                                <span x-show="billingPeriod === 'monthly'">Rp 119.700</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 1.197.000</span>
                                <span class="text-xs font-normal text-slate-455">/ <span x-text="billingPeriod === 'monthly' ? 'bln' : 'thn'"></span></span>
                            </div>
                        </div>
                        
                        <ul class="text-xs text-slate-600 space-y-3 border-t border-slate-100 pt-4 font-semibold text-left">
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Maksimal 20 Kamar Aktif</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Maksimal 20 Penghuni</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>3 Akun Staf Operasional</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>1 Lokasi / Properti</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>1 GB Penyimpanan Data</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Portal PWA Penghuni</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <x-button variant="outline" class="w-full text-center border border-slate-200 bg-white hover:bg-slate-50 cursor-pointer text-xs py-2.5 font-bold !text-slate-800 hover:!text-slate-955" onclick="window.location.href='{{ route('register') }}'">
                            Mulai Coba Gratis
                        </x-button>
                        <p class="text-[9.5px] text-center text-slate-400 font-semibold">Uji coba 14 hari &bull; Cancel kapan saja</p>
                    </div>
                </div>

                <!-- Paket Business -->
                <div class="overflow-hidden rounded-3xl p-[1.5px] relative flex flex-col justify-stretch shadow-xl bg-white border border-slate-200/60 lg:-translate-y-2 transition duration-300">
                    <!-- Conic rotating border glow -->
                    <div class="absolute inset-[-1000%] animate-[spin_6s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#818cf8_0%,#c084fc_25%,#e0e7ff_50%,#c084fc_75%,#818cf8_100%)] pointer-events-none"></div>
                    
                    <div class="bg-white rounded-[22px] p-5 relative flex flex-col justify-between h-full space-y-6">
                        <div class="space-y-5">
                            <div class="flex justify-between items-center">
                                <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200/50 uppercase tracking-widest font-mono">BUSINESS</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black bg-indigo-650 text-white uppercase tracking-widest shadow-2xs">Best Value</span>
                            </div>
                            <h4 class="text-lg font-black text-slate-900 text-left">Business Plan</h4>
                            <p class="text-xs text-slate-550 leading-relaxed font-medium text-left">Sempurna untuk multi-lokasi properti dan bisnis skala menengah.</p>
                            <div class="space-y-1.5 text-left">
                                <span class="text-xs font-bold text-indigo-400/85 line-through">
                                    <span x-show="billingPeriod === 'monthly'">Rp 899.000</span>
                                    <span x-show="billingPeriod === 'yearly'">Rp 8.990.000</span>
                                </span>
                                <div class="text-2xl font-black text-indigo-650 font-mono text-left flex items-baseline gap-1">
                                    <span x-show="billingPeriod === 'monthly'">Rp 269.700</span>
                                    <span x-show="billingPeriod === 'yearly'">Rp 2.697.000</span>
                                    <span class="text-xs font-normal text-slate-400">/ <span x-text="billingPeriod === 'monthly' ? 'bln' : 'thn'"></span></span>
                                </div>
                            </div>
                            
                            <ul class="text-xs text-slate-655 space-y-3 border-t border-slate-100 pt-4 font-semibold text-left">
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>Maksimal 100 Kamar Aktif</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>Maksimal 100 Penghuni</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>10 Akun Staf Operasional</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>3 Lokasi / Properti</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>10 GB Penyimpanan Data</span>
                                </li>
                                <li class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">✓</span>
                                    <span>Laporan &amp; Analisis Laba</span>
                                </li>
                            </ul>
                        </div>
                        <div class="space-y-2">
                            <x-button variant="primary" class="w-full text-center shadow-md shadow-indigo-500/20 cursor-pointer text-xs py-2.5 font-bold" onclick="window.location.href='{{ route('register') }}'">
                                Mulai Coba Gratis
                            </x-button>
                            <p class="text-[9.5px] text-center text-slate-400 font-semibold">Uji coba 14 hari &bull; Cancel kapan saja</p>
                        </div>
                    </div>
                </div>

                <!-- Paket Enterprise -->
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-xs flex flex-col justify-between space-y-6 hover:shadow-lg hover:-translate-y-1 transition duration-300 text-white relative">
                    <div class="absolute top-3 right-3">
                        <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="space-y-1 text-left">
                            <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-500/25 text-indigo-300 border border-indigo-500/30 uppercase tracking-widest font-mono">ENTERPRISE</span>
                            <h4 class="text-lg font-black">Enterprise Plan</h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium text-left">Tingkatan premium dengan skalabilitas tanpa batas dan white-labeling.</p>
                        </div>
                        <div class="space-y-1.5 text-left">
                            <span class="text-xs font-bold text-slate-500 line-through">
                                <span x-show="billingPeriod === 'monthly'">Rp 1.999.000</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 19.990.000</span>
                            </span>
                            <div class="text-2xl font-black text-left font-mono flex items-baseline gap-1">
                                <span x-show="billingPeriod === 'monthly'">Rp 599.700</span>
                                <span x-show="billingPeriod === 'yearly'">Rp 5.997.000</span>
                                <span class="text-xs font-normal text-slate-500">/ <span x-text="billingPeriod === 'monthly' ? 'bln' : 'thn'"></span></span>
                            </div>
                        </div>
                        
                        <ul class="text-xs text-slate-350 space-y-3 border-t border-slate-800 pt-4 font-semibold text-left">
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Kamar Aktif Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Penghuni Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Staf &amp; Cabang Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>Domain Kustom Sendiri</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>White-label (Tanpa Brand Kosan)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-4 h-4 rounded-full bg-indigo-900/50 text-indigo-400 flex items-center justify-center flex-shrink-0">✓</span>
                                <span>100 GB Penyimpanan Data</span>
                            </li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <x-button variant="outline" class="w-full text-center border-0 bg-white hover:bg-slate-50 cursor-pointer text-xs py-2.5 font-bold !text-slate-900 hover:!text-slate-950" onclick="window.location.href='{{ route('contact') }}'">
                            Hubungi Penjualan
                        </x-button>
                        <p class="text-[9.5px] text-center text-slate-550 font-semibold">Demo kustom personal &bull; SLAs Uptime</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: PERBANDINGAN PAKET (TABLE) -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-6 space-y-12">
            <div class="text-center space-y-3">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Perbandingan Fitur Paket Selengkapnya</h3>
                <p class="text-slate-500 text-xs sm:text-sm font-medium">Bandingkan kapabilitas teknis di setiap rencana tarif berlangganan platform Kosan.</p>
            </div>

            <!-- Comparison Table Container -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-2xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-800 font-extrabold uppercase tracking-wider text-[10px]">
                                <th class="p-4 w-1/4">KAPABILITAS LAYANAN</th>
                                <th class="p-4 text-center">STARTER</th>
                                <th class="p-4 text-center">PRO</th>
                                <th class="p-4 text-center">BUSINESS</th>
                                <th class="p-4 text-center">ENTERPRISE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-650">
                            <!-- Row 1: Kamar -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Kapasitas Kamar Aktif</td>
                                <td class="p-4 text-center">Maksimal 5 Kamar</td>
                                <td class="p-4 text-center">Maksimal 20 Kamar</td>
                                <td class="p-4 text-center">Maksimal 100 Kamar</td>
                                <td class="p-4 text-center text-indigo-650 font-bold">Tanpa Batas</td>
                            </tr>
                            <!-- Row 2: Pengguna -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Jumlah Akun Pengguna / Staf</td>
                                <td class="p-4 text-center">1 Staf (Owner)</td>
                                <td class="p-4 text-center">Hingga 3 Staf</td>
                                <td class="p-4 text-center">Hingga 10 Staf</td>
                                <td class="p-4 text-center text-indigo-650 font-bold">Tanpa Batas</td>
                            </tr>
                            <!-- Row 3: WhastApp -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Notifikasi Tagihan WhatsApp</td>
                                <td class="p-4 text-center">Manual</td>
                                <td class="p-4 text-center text-emerald-600">✓ Otomatis Terjadwal</td>
                                <td class="p-4 text-center text-emerald-600">✓ Otomatis Terjadwal</td>
                                <td class="p-4 text-center text-emerald-600">✓ Otomatis Terjadwal</td>
                            </tr>
                            <!-- Row 4: Mutasi -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Rekonsiliasi Mutasi Bank BCA/Mandiri</td>
                                <td class="p-4 text-center text-slate-400">✕ Tidak Ada</td>
                                <td class="p-4 text-center text-emerald-600">✓ Verifikasi Cerdas</td>
                                <td class="p-4 text-center text-emerald-600">✓ Verifikasi Cerdas</td>
                                <td class="p-4 text-center text-emerald-600">✓ VA/Integrasi Kustom</td>
                            </tr>
                            <!-- Row 5: Portal Penghuni -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Portal Mandiri Penghuni (PWA)</td>
                                <td class="p-4 text-center text-slate-400">✕ Tidak Ada</td>
                                <td class="p-4 text-center text-emerald-600">✓ Ya</td>
                                <td class="p-4 text-center text-emerald-600">✓ Ya</td>
                                <td class="p-4 text-center text-emerald-600">✓ Ya</td>
                            </tr>
                            <!-- Row 6: Maintenance -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Tiket Manajemen Kerusakan</td>
                                <td class="p-4 text-center text-slate-400">✕ Tidak Ada</td>
                                <td class="p-4 text-center">✓ Alokasi Staf &amp; Foto</td>
                                <td class="p-4 text-center">✓ Alokasi Staf &amp; Foto</td>
                                <td class="p-4 text-center">✓ Alokasi Staf &amp; Foto</td>
                            </tr>
                            <!-- Row 7: Laporan & Analisis -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Laporan &amp; Analitik Laba Bisnis</td>
                                <td class="p-4 text-center text-slate-400">✕ Tidak Ada</td>
                                <td class="p-4 text-center">Laporan Dasar</td>
                                <td class="p-4 text-center text-indigo-650 font-bold">Analisis Laba Bisnis</td>
                                <td class="p-4 text-center text-indigo-650 font-bold">Sistem Custom / SLAs</td>
                            </tr>
                            <!-- Row 8: SLA -->
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-4 font-bold text-slate-800">Prioritas SLA Bantuan Support</td>
                                <td class="p-4 text-center">Email &bull; Jam Kerja</td>
                                <td class="p-4 text-center">WhatsApp &bull; Respon Cepat</td>
                                <td class="p-4 text-center">WhatsApp &bull; Respon Cepat</td>
                                <td class="p-4 text-center text-indigo-650 font-bold">Dedicated 24/7 Priority</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: MANFAAT YANG DIDAPAT -->
    <section class="py-20 bg-slate-50/40 border-y border-slate-200/50 glow-indigo">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            <!-- Header -->
            <div class="max-w-3xl mx-auto text-center space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Manfaat Bisnis Utama</h2>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">Investasi Berlangganan yang Melipatgandakan Nilai Operasional</h3>
                <p class="text-slate-500 text-xs sm:text-sm font-medium">Bukan sekadar deretan fitur teknis, tetapi tentang hasil nyata bagi profitabilitas bisnis properti Anda.</p>
            </div>

            <!-- Features list grid layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-650 flex items-center justify-center font-bold text-sm">✓</div>
                    <h4 class="text-base font-bold text-slate-900">Menghemat 80% Waktu Administrasi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Tinggalkan pencatatan manual. Faktur tagihan bulanan dikirim secara otomatis ke penyewa tanpa perlu Anda tulis manual satu per satu.</p>
                </div>
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-650 flex items-center justify-center font-bold text-sm">✓</div>
                    <h4 class="text-base font-bold text-slate-900">Akurasi Pembukuan &amp; Nol Human Error</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Kalkulasi sewa, deposit jaminan, dan tagihan listrik/air dikalkulasi secara presisi oleh sistem untuk menghindari perselisihan data.</p>
                </div>
                <div class="space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-650 flex items-center justify-center font-bold text-sm">✓</div>
                    <h4 class="text-base font-bold text-slate-900">Proteksi Keamanan Kas Utama</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Verifikasi mutasi bank BCA/Mandiri secara cerdas mendeteksi gambar struk transfer palsu atau tidak valid untuk mengamankan pendapatan sewa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: FAQ ACCORDION -->
    <section class="py-24 bg-slate-50/30 border-y border-slate-200/50" x-data="{ openFaq: null }">
        <div class="max-w-4xl mx-auto px-6 space-y-16">
            <!-- Headers -->
            <div class="text-center space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Tanya Jawab Harga</h2>
                <h3 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    Segala Hal yang Perlu Anda Ketahui Tentang Tarif
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed max-w-xl mx-auto font-medium">
                    Temukan jawaban atas pertanyaan finansial dan lisensi platform Kosan di bawah ini.
                </p>
            </div>

            <!-- Accordion List (10 FAQ items) -->
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 1 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 1 ? null : 1">
                        <span>Apakah tersedia uji coba gratis?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 1 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 1" x-transition>
                        Ya, kami menyediakan masa uji coba gratis selama 14 hari penuh. Anda dapat mengakses seluruh fitur premium platform tanpa batasan agar dapat merasakan langsung manfaat efisiensi sebelum memutuskan berlangganan.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 2 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 2 ? null : 2">
                        <span>Apakah memerlukan kartu kredit saat mendaftar?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 2 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 2" x-transition>
                        Tidak. Anda dapat langsung mendaftar menggunakan alamat email aktif Anda tanpa perlu memasukkan rincian kartu kredit atau rincian pembayaran apa pun untuk memulai uji coba gratis.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 3 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 3 ? null : 3">
                        <span>Apakah saya dapat membatalkan langganan kapan saja?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 3 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 3" x-transition>
                        Tentu saja. Kosan menggunakan skema berlangganan bulanan yang transparan tanpa ikatan kontrak tahunan yang mengikat. Anda dapat menonaktifkan atau membatalkan langganan Anda secara mandiri dari pengaturan kapan pun Anda mau.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 4 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 4 ? null : 4">
                        <span>Bagaimana metode dan proses pembayaran untuk paket Pro?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 4 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 4" x-transition>
                        Kami mendukung pembayaran aman melalui transfer bank (Virtual Account BCA, Mandiri, BRI, BNI), kartu kredit, e-wallet (GoPay, OVO), dan QRIS melalui payment gateway resmi yang terintegrasi di platform.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 5 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 5 ? null : 5">
                        <span>Apakah tarif sewa sudah termasuk semua fitur utama Kosan?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 5 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 5" x-transition>
                        Ya. Paket Pro (Pertumbuhan) membuka akses penuh ke 10 modul penting platform (Penagihan otomatis, rekonsiliasi mutasi bank BCA, PWA portal penghuni, manajemen staf, laporan rugi laba, dll) tanpa batasan fitur.
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 6 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 6 ? null : 6">
                        <span>Bagaimana jika jumlah kamar kos saya bertambah di tengah bulan?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 6 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 6" x-transition>
                        Lisensi Kosan dihitung berdasarkan jumlah kamar aktif di katalog Anda. Jika Anda menambahkan kamar baru, tagihan langganan Anda akan disesuaikan secara proporsional (prorated) pada tanggal penagihan berikutnya.
                    </div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 7 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 7 ? null : 7">
                        <span>Apakah tersedia diskon khusus untuk pembayaran tahunan?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 7 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 7" x-transition>
                        Ya, kami memberikan potongan harga sebesar 20% jika Anda memilih opsi penagihan tahunan langsung saat melakukan transaksi berlangganan paket Pro.
                    </div>
                </div>

                <!-- FAQ Item 8 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 8 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 8 ? null : 8">
                        <span>Apakah saya akan mendapatkan bantuan onboarding saat mendaftar?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 8 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 8" x-transition>
                        Tentu. Kami menyediakan panduan langkah-demi-langkah, materi tutorial video onboard, serta bantuan support live chat untuk memastikan Anda dapat mengatur properti Anda dengan benar tanpa kebingungan.
                    </div>
                </div>

                <!-- FAQ Item 9 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 9 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 9 ? null : 9">
                        <span>Bisakah tim Kosan membantu memindahkan data sewa saya dari Excel?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 9 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 9" x-transition>
                        Sangat bisa. Anda hanya perlu mendownload file template excel bulk import kami atau menghubungi tim spesialis migrasi kami. Kami akan merapikan dan mengimpor seluruh riwayat kamar dan penyewa Anda secara gratis.
                    </div>
                </div>

                <!-- FAQ Item 10 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 10 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 10 ? null : 10">
                        <span>Bagaimana jika saya memerlukan kustomisasi paket khusus?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 10 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-555 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 10" x-transition>
                        Bagi korporasi pengelola kos skala besar (>150 kamar) atau co-living dengan kebutuhan khusus (seperti integrasi API tertutup atau kustomisasi Virtual Account Mandiri), silakan hubungi tim penjualan kami untuk penawaran paket kustom.
                    </div>
                </div>
            </div>
        </div>
    </section>                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 7: GARANSI & JAMINAN KEPERCAYAAN -->
    <section class="py-24 bg-slate-950 text-white relative overflow-hidden" 
             x-data="{ 
                 activeTab: 'uptime',
                 simulatingBackup: false,
                 backupStep: 0,
                 backupStatus: '',
                 tenantSelected: 'A',
                 ping: 14,
                 runBackupSimulation() {
                     if (this.simulatingBackup) return;
                     this.simulatingBackup = true;
                     this.backupStep = 1;
                     this.backupStatus = 'Mencari snapshot database terenkripsi...';
                     
                     setTimeout(() => {
                         this.backupStep = 2;
                         this.backupStatus = 'Mengunduh snapshot aman (1.2 GB)...';
                         setTimeout(() => {
                             this.backupStep = 3;
                             this.backupStatus = 'Melakukan dekripsi AES-256 & verifikasi integritas SHA...';
                             setTimeout(() => {
                                 this.backupStep = 4;
                                 this.backupStatus = 'Restorasi sukses! 100% data keuangan & kamar pulih.';
                                 this.simulatingBackup = false;
                             }, 1000);
                         }, 900);
                     }, 850);
                 }
             }"
             x-init="setInterval(() => { ping = Math.floor(Math.random() * 5) + 12 }, 2000)">
        
        <!-- Ambient radial background glows -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.08),transparent_50%)]"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 space-y-16 relative z-10">
            <!-- Header Section -->
            <div class="text-center space-y-4 max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-extrabold bg-indigo-500/20 text-indigo-300 tracking-wider uppercase border border-indigo-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-ping"></span>
                    Keandalan Berlisensi
                </span>
                <h3 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                    Infrastruktur Kuat & Transparansi Tanpa Kompromi
                </h3>
                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                    Setiap rupiah investasi Anda dilindungi oleh arsitektur server modern berstandar enterprise yang siap menjamin keamanan dan kenyamanan operasional Anda.
                </p>
            </div>

            <!-- Main Interactive Component Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Left Side: Guarantees List (Tabs Controllers) -->
                <div class="lg:col-span-5 flex flex-col justify-center space-y-4">
                    <!-- Tab 1: Uptime SLA -->
                    <button class="w-full text-left p-5 border rounded-2xl transition duration-300 cursor-pointer flex gap-4 items-start"
                            :class="activeTab === 'uptime' ? 'bg-slate-900 border-indigo-500/60 shadow-lg shadow-indigo-500/10' : 'bg-slate-900/40 border-slate-900 hover:border-slate-800 hover:bg-slate-900/70'"
                            @click="activeTab = 'uptime'">
                        <div class="p-2.5 rounded-xl transition duration-300 bg-indigo-500/10 text-indigo-400"
                             :class="activeTab === 'uptime' ? 'bg-indigo-500 text-slate-950' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-100 flex items-center gap-2">
                                99.9% Uptime SLA
                                <span class="w-2 h-2 rounded-full bg-emerald-500" :class="activeTab === 'uptime' ? 'animate-ping' : ''"></span>
                            </h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">Server awan berkecepatan tinggi menjamin platform dapat diakses 24 jam penuh tanpa hambatan.</p>
                        </div>
                    </button>

                    <!-- Tab 2: Daily Backup -->
                    <button class="w-full text-left p-5 border rounded-2xl transition duration-300 cursor-pointer flex gap-4 items-start"
                            :class="activeTab === 'backup' ? 'bg-slate-900 border-indigo-500/60 shadow-lg shadow-indigo-500/10' : 'bg-slate-900/40 border-slate-900 hover:border-slate-800 hover:bg-slate-900/70'"
                            @click="activeTab = 'backup'">
                        <div class="p-2.5 rounded-xl transition duration-300 bg-indigo-500/10 text-indigo-400"
                             :class="activeTab === 'backup' ? 'bg-indigo-500 text-slate-950' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-100">Backup Otomatis Harian</h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">Seluruh log transaksi pembukuan di-backup ke cloud backup terpisah secara terjadwal otomatis.</p>
                        </div>
                    </button>

                    <!-- Tab 3: Database Isolation -->
                    <button class="w-full text-left p-5 border rounded-2xl transition duration-300 cursor-pointer flex gap-4 items-start"
                            :class="activeTab === 'security' ? 'bg-slate-900 border-indigo-500/60 shadow-lg shadow-indigo-500/10' : 'bg-slate-900/40 border-slate-900 hover:border-slate-800 hover:bg-slate-900/70'"
                            @click="activeTab = 'security'">
                        <div class="p-2.5 rounded-xl transition duration-300 bg-indigo-500/10 text-indigo-400"
                             :class="activeTab === 'security' ? 'bg-indigo-500 text-slate-950' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-100">Isolasi Database Tenant</h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">Arsitektur multi-tenant menjamin data sensitif penyewa Anda terisolasi aman dari properti lain.</p>
                        </div>
                    </button>

                    <!-- Tab 4: Zero Hidden Cost -->
                    <button class="w-full text-left p-5 border rounded-2xl transition duration-300 cursor-pointer flex gap-4 items-start"
                            :class="activeTab === 'transparency' ? 'bg-slate-900 border-indigo-500/60 shadow-lg shadow-indigo-500/10' : 'bg-slate-900/40 border-slate-900 hover:border-slate-800 hover:bg-slate-900/70'"
                            @click="activeTab = 'transparency'">
                        <div class="p-2.5 rounded-xl transition duration-300 bg-indigo-500/10 text-indigo-400"
                             :class="activeTab === 'transparency' ? 'bg-indigo-500 text-slate-950' : ''">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-100">Zero Hidden Cost</h4>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">Tanpa ada biaya implementasi terselubung. Skema harga transparan sesuai jumlah kamar aktif.</p>
                        </div>
                    </button>
                </div>

                <!-- Right Side: Simulation Panel -->
                <div class="lg:col-span-7 bg-slate-900/60 border border-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between min-h-[420px] relative backdrop-blur-xs">
                    <!-- Background ambient glow inside the card -->
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <!-- TAB 1: UPTIME SLA DETAILS -->
                    <div x-show="activeTab === 'uptime'" class="space-y-6 flex-1 flex flex-col justify-between" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <h5 class="text-indigo-400 font-extrabold text-xs uppercase tracking-wider">Server Status Monitor</h5>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Operational
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-100">Live Uptime Status &amp; Performance</h3>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                                Infrastruktur kami menggunakan cluster multi-zona yang mendistribusikan beban secara dinamis untuk menghindari kegagalan titik tunggal (single point of failure).
                            </p>
                        </div>

                        <!-- Mini Dashboard Visuals -->
                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 space-y-4 font-mono text-xs">
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-500 uppercase font-semibold">Node Jakarta</span>
                                    <div class="text-slate-200 font-extrabold text-sm">99.98%</div>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-500 uppercase font-semibold">Node Singapore</span>
                                    <div class="text-slate-200 font-extrabold text-sm">99.99%</div>
                                </div>
                                <div class="space-y-1 col-span-2 sm:col-span-1">
                                    <span class="text-[10px] text-slate-500 uppercase font-semibold">Avg Response</span>
                                    <div class="text-indigo-400 font-extrabold text-sm flex items-center gap-1">
                                        <span x-text="ping + 'ms'"></span>
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Heartbeat Line simulation -->
                            <div class="space-y-1.5">
                                <div class="flex justify-between text-[10px] text-slate-500 font-bold">
                                    <span>24H HEARTBEAT HISTORY</span>
                                    <span>SLA: 99.9% MET</span>
                                </div>
                                <div class="flex items-end gap-1 h-14 pt-2">
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-10 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-12 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-9 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-11 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-13 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-12 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-10 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-12 transition-all duration-300"></div>
                                    <div class="flex-1 bg-amber-400/85 rounded-xs h-7 transition-all duration-300" title="Latency spike - 0.01% drop"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-13 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-11 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-12 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-14 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-10 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-12 transition-all duration-300"></div>
                                    <div class="flex-1 bg-emerald-500/80 rounded-xs h-13 transition-all duration-300"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: DAILY BACKUP DETAILS -->
                    <div x-show="activeTab === 'backup'" class="space-y-6 flex-1 flex flex-col justify-between" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <div class="space-y-3">
                            <h5 class="text-indigo-400 font-extrabold text-xs uppercase tracking-wider">Disaster Recovery Simulation</h5>
                            <h3 class="text-xl font-bold text-slate-100">Jaminan Keamanan Data Terdistribusi</h3>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                                Data properti Anda di-backup ke dua server cloud terpisah secara harian. Uji keandalan backup Anda dengan menjalankan simulasi pemulihan sistem di bawah ini.
                            </p>
                        </div>

                        <!-- Recovery interactive simulation board -->
                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 space-y-4">
                            <!-- Progress Steps -->
                            <div class="space-y-3 font-mono text-[11px] text-slate-400">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] font-bold"
                                          :class="backupStep >= 1 ? (backupStep > 1 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-indigo-500/30 text-indigo-300 animate-pulse') : 'bg-slate-800 text-slate-600'">1</span>
                                    <span :class="backupStep === 1 ? 'text-indigo-400 font-bold' : (backupStep > 1 ? 'text-slate-400' : 'text-slate-600')">Koneksi &amp; Cari Backup Snapshot</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] font-bold"
                                          :class="backupStep >= 2 ? (backupStep > 2 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-indigo-500/30 text-indigo-300 animate-pulse') : 'bg-slate-800 text-slate-600'">2</span>
                                    <span :class="backupStep === 2 ? 'text-indigo-400 font-bold' : (backupStep > 2 ? 'text-slate-400' : 'text-slate-600')">Unduh Snapshot Database Terenkripsi</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] font-bold"
                                          :class="backupStep >= 3 ? (backupStep > 3 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-indigo-500/30 text-indigo-300 animate-pulse') : 'bg-slate-800 text-slate-600'">3</span>
                                    <span :class="backupStep === 3 ? 'text-indigo-400 font-bold' : (backupStep > 3 ? 'text-slate-400' : 'text-slate-600')">Dekripsi Kunci AES-256 &amp; Verifikasi Hash</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] font-bold"
                                          :class="backupStep >= 4 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-800 text-slate-600'">4</span>
                                    <span :class="backupStep === 4 ? 'text-emerald-400 font-bold' : 'text-slate-600'">Sistem Berhasil Dipulihkan</span>
                                </div>
                            </div>

                            <!-- Interactive Button or Success status -->
                            <div class="pt-2">
                                <template x-if="!simulatingBackup && backupStep !== 4">
                                    <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold transition cursor-pointer flex justify-center items-center gap-2 shadow-md shadow-indigo-600/10"
                                            @click="runBackupSimulation()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5" />
                                        </svg>
                                        Mulai Simulasi Pemulihan
                                    </button>
                                </template>
                                
                                <template x-if="simulatingBackup">
                                    <div class="w-full py-3 bg-slate-900 border border-slate-800 text-indigo-300 rounded-xl text-xs font-mono font-bold flex justify-center items-center gap-2.5">
                                        <!-- Mini spinner -->
                                        <svg class="animate-spin h-3.5 w-3.5 text-indigo-400" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="backupStatus"></span>
                                    </div>
                                </template>

                                <template x-if="backupStep === 4 && !simulatingBackup">
                                    <div class="space-y-3">
                                        <div class="w-full p-3 bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 rounded-xl text-xs font-mono font-bold flex items-center justify-between">
                                            <span class="flex items-center gap-2">✓ Restorasi Selesai! (Integritas 100%)</span>
                                            <span class="text-[10px] text-slate-500">Waktu: 0.8s</span>
                                        </div>
                                        <button class="w-full py-2.5 bg-slate-900 hover:bg-slate-850 border border-slate-800 rounded-xl text-slate-350 hover:text-slate-100 text-xs font-bold transition cursor-pointer text-center"
                                                @click="backupStep = 0; backupStatus = ''">
                                            Ulangi Simulasi
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: DATABASE ISOLATION DETAILS -->
                    <div x-show="activeTab === 'security'" class="space-y-6 flex-1 flex flex-col justify-between" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <div class="space-y-3">
                            <h5 class="text-indigo-400 font-extrabold text-xs uppercase tracking-wider">Multi-Tenant Security</h5>
                            <h3 class="text-xl font-bold text-slate-100">Database Terisolasi &amp; Terlindungi</h3>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                                Kami menerapkan pemisahan data yang ketat. Setiap akun pengguna/properti beroperasi di bawah skema isolasi data independen, memastikan data sensitif Anda tidak pernah bocor.
                            </p>
                        </div>

                        <!-- Tenant Interactive Visualizer -->
                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl p-5 space-y-4">
                            <div class="flex justify-between items-center text-[10.5px] font-bold text-slate-400">
                                <span>PILIH CABANG SIMULASI</span>
                                <span>ISOLATED PATHWAYS</span>
                            </div>

                            <!-- Selector buttons -->
                            <div class="grid grid-cols-2 gap-3">
                                <button class="py-2.5 px-3 rounded-xl border text-xs font-bold transition cursor-pointer flex items-center justify-center gap-2"
                                        :class="tenantSelected === 'A' ? 'bg-indigo-600 border-indigo-500 text-white' : 'bg-slate-900 border-slate-800 text-slate-400 hover:bg-slate-850'"
                                        @click="tenantSelected = 'A'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="tenantSelected === 'A' ? 'bg-white' : 'bg-slate-500'"></span>
                                    Cabang Kos A
                                </button>
                                <button class="py-2.5 px-3 rounded-xl border text-xs font-bold transition cursor-pointer flex items-center justify-center gap-2"
                                        :class="tenantSelected === 'B' ? 'bg-indigo-600 border-indigo-500 text-white' : 'bg-slate-900 border-slate-800 text-slate-400 hover:bg-slate-850'"
                                        @click="tenantSelected = 'B'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="tenantSelected === 'B' ? 'bg-white' : 'bg-slate-500'"></span>
                                    Cabang Kos B
                                </button>
                            </div>

                            <!-- Visual Diagram Mockup -->
                            <div class="p-3.5 bg-slate-900 border border-slate-850 rounded-xl flex items-center justify-between text-[10px] font-mono">
                                <!-- Tenant Icon -->
                                <div class="space-y-1 text-center w-20">
                                    <div class="p-2 bg-slate-800 rounded-lg text-slate-300 font-extrabold border border-slate-700" x-text="tenantSelected === 'A' ? 'KOS-A' : 'KOS-B'"></div>
                                    <span class="text-slate-500 block text-[8.5px]">Request User</span>
                                </div>

                                <!-- Connecting Animated Pathway -->
                                <div class="flex-1 px-4 relative flex items-center justify-center">
                                    <div class="w-full h-0.5 bg-slate-800 relative overflow-hidden">
                                        <div class="absolute top-0 h-full w-12 bg-gradient-to-r from-transparent via-indigo-400 to-transparent animate-[shimmer_1.5s_infinite_linear]"
                                             :class="tenantSelected === 'A' ? '' : 'hidden'"></div>
                                        <div class="absolute top-0 h-full w-12 bg-gradient-to-r from-transparent via-indigo-400 to-transparent animate-[shimmer_1.5s_infinite_linear]"
                                             :style="{ animationDelay: '0.7s' }"
                                             :class="tenantSelected === 'B' ? '' : 'hidden'"></div>
                                    </div>
                                </div>

                                <!-- Firewall Gateway -->
                                <div class="px-2.5 py-2.5 bg-indigo-950 border border-indigo-900 text-indigo-300 rounded-xl text-center flex flex-col items-center">
                                    <svg class="w-4 h-4 animate-pulse-soft" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span class="text-[7.5px] mt-1 text-indigo-455 font-extrabold uppercase tracking-widest">GATEWAY</span>
                                </div>

                                <!-- Connecting Animated Pathway 2 -->
                                <div class="flex-1 px-4 relative flex items-center justify-center">
                                    <div class="w-full h-0.5 bg-slate-800 relative overflow-hidden">
                                        <div class="absolute top-0 h-full w-12 bg-gradient-to-r from-transparent via-indigo-400 to-transparent animate-[shimmer_1.5s_infinite_linear]"
                                             :class="tenantSelected === 'A' ? '' : 'hidden'"></div>
                                        <div class="absolute top-0 h-full w-12 bg-gradient-to-r from-transparent via-indigo-400 to-transparent animate-[shimmer_1.5s_infinite_linear]"
                                             :style="{ animationDelay: '0.7s' }"
                                             :class="tenantSelected === 'B' ? '' : 'hidden'"></div>
                                    </div>
                                </div>

                                <!-- Target Isolated Database -->
                                <div class="space-y-1 text-center w-20">
                                    <div class="p-2 rounded-lg font-extrabold border transition duration-300 bg-indigo-900/40 border-indigo-500/50 text-indigo-300"
                                         x-text="tenantSelected === 'A' ? 'DB_TENANT_A' : 'DB_TENANT_B'"></div>
                                    <span class="text-slate-500 block text-[8.5px]">Isolated Data</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 4: ZERO HIDDEN COST DETAILS -->
                    <div x-show="activeTab === 'transparency'" class="space-y-6 flex-1 flex flex-col justify-between" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <div class="space-y-3">
                            <h5 class="text-indigo-400 font-extrabold text-xs uppercase tracking-wider">Pricing Integrity</h5>
                            <h3 class="text-xl font-bold text-slate-100">Transparansi Biaya Mutlak</h3>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                                Kami berkomitmen penuh pada model bisnis SaaS yang adil. Tidak ada biaya implementasi tersembunyi, tidak ada biaya administrasi bulanan terpisah, dan tidak ada biaya upgrade.
                            </p>
                        </div>

                        <!-- Cost Comparison Visual -->
                        <div class="bg-slate-950/80 border border-slate-800 rounded-2xl overflow-hidden text-xs">
                            <div class="grid grid-cols-3 bg-slate-900/50 border-b border-slate-800 p-3 text-[10px] font-bold text-slate-400 uppercase">
                                <span>Jenis Investasi</span>
                                <span class="text-indigo-400">Kosan Platform</span>
                                <span>Software Tradisional</span>
                            </div>
                            <div class="divide-y divide-slate-900">
                                <div class="grid grid-cols-3 p-3 text-slate-300">
                                    <span class="font-medium text-slate-400">Biaya Setup &amp; Inisiasi</span>
                                    <span class="text-emerald-400 font-bold">Gratis (Rp 0)</span>
                                    <span class="text-slate-500 font-mono">Rp 1.500.000+</span>
                                </div>
                                <div class="grid grid-cols-3 p-3 text-slate-300">
                                    <span class="font-medium text-slate-400">Migrasi Data Kamar</span>
                                    <span class="text-emerald-450 font-bold">Gratis Dibantu Staf</span>
                                    <span class="text-slate-500 font-mono">Rp 500.000</span>
                                </div>
                                <div class="grid grid-cols-3 p-3 text-slate-300">
                                    <span class="font-medium text-slate-400">Pembalasan &amp; Fitur Baru</span>
                                    <span class="text-emerald-450 font-bold">Gratis Selamanya</span>
                                    <span class="text-slate-500 font-mono">Berbayar Berkala</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 8: CALL TO ACTION (CTA) -->
    <section class="py-20 bg-gradient-to-tr from-indigo-900 via-indigo-950 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.25),transparent_45%)]"></div>
        
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Mulai Optimalkan Keuntungan Properti Anda Sekarang
            </h2>
            <p class="text-indigo-200/90 text-sm max-w-xl mx-auto leading-relaxed font-normal">
                Dapatkan bantuan onboarding gratis dan layanan migrasi data dari Excel oleh tim spesialis kami selama masa promosi bulan ini.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                <x-button variant="primary" size="lg" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 !border-white w-full sm:w-auto text-center font-bold px-8 py-4 shadow-lg cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
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
