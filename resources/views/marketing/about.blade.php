<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- About / Org Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "AboutPage",
      "mainEntity": {
        "@@type": "Organization",
        "name": "Kosan",
        "description": "Sistem operasi manajemen bisnis kos berbasis multi-tenant yang dibangun dengan arsitektur modern.",
        "foundingDate": "2026",
        "founder": {
          "@@type": "Person",
          "name": "Rivan Alamsyah"
        }
      }
    }
    </script>
    @endpush

    <!-- About Custom Styles -->
    <style>
        .about-mesh {
            background-image: radial-gradient(circle at 10% 30%, rgba(99, 102, 241, 0.04), transparent 50%);
        }
    </style>

    <!-- Section 1: Hero Banner -->
    <section class="relative overflow-hidden pt-28 pb-12 text-center space-y-4 bg-slate-50/30 about-mesh">
        <div class="absolute top-0 right-1/4 w-80 h-80 bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Kisah &amp; Filosofi Produk
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Mentransformasi Operasional <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Bisnis Kos di Indonesia</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                Kami membangun sistem operasi manajemen kos yang aman, cepat, dan modern untuk pengelola dan pemilik hunian komersial.
            </p>
        </div>
    </section>

    <!-- Section 2: Mission & Vision (Elevated Cards) -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
            <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-sm transition duration-200 space-y-3">
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Misi Kami</h3>
                <p class="text-xs text-slate-500 leading-relaxed text-justify font-medium">
                    Menghilangkan kerumitan operasional pemilik kos. Dengan mengotomatisasi penerbitan faktur tagihan sewa, menyediakan verifikasi bukti transfer otomatis, dan memberikan portal digital mandiri bagi penghuni, kami mengembalikan waktu berharga pemilik kos dari beban administrasi manual.
                </p>
            </div>
            <div class="bg-slate-50 border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-sm transition duration-200 space-y-3">
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Visi Kami</h3>
                <p class="text-xs text-slate-500 leading-relaxed text-justify font-medium">
                    Menjadi fondasi perangkat lunak standar untuk pengelolaan properti hunian dan mikro-apartemen di Indonesia, yang memberdayakan pengelola kos untuk meningkatkan potensi imbal hasil properti tanpa perlu menambah beban staf administrasi.
                </p>
            </div>
        </div>
    </section>

    <!-- Section 3: Core Values Cards -->
    <section class="py-16 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Prinsip Utama</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Nilai-Nilai Utama Operasional</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200 space-y-3 text-left">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Transparansi Keuangan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Kami menjaga pembukuan faktur tagihan dan riwayat pelunasan secara transparan untuk menjamin audit keuangan yang akurat.</p>
                </div>
                
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200 space-y-3 text-left">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Isolasi Data Terjamin</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Setiap data ruang kerja properti dienkripsi dan diisolasi dengan batasan keamanan yang ketat. Akses data antar pemilik kos dicegah secara mutlak.</p>
                </div>
                
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200 space-y-3 text-left">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Inovasi Operasional</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Dari portal PWA penghuni hingga grafik keuangan interaktif, kami merancang pengalaman pengguna yang modern dan responsif.</p>
                </div>

                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition duration-200 space-y-3 text-left">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Dukungan Responsif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Kami mendampingi proses pendaftaran dan konfigurasi awal properti Anda agar manfaat otomatisasi langsung terasa sejak hari pertama.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Technology Stack -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center text-left">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md">Arsitektur Teknologi</span>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Dirancang untuk Kecepatan &amp; Stabilitas Tinggi</h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Kosan dibangun di atas kerangka kerja Laravel 12, dilengkapi reaktivitas real-time via Livewire dan Alpine.js, tata letak Tailwind CSS, serta sistem basis data MySQL yang tangguh.
                </p>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl grid grid-cols-2 gap-4 text-xs font-extrabold text-slate-700 text-center shadow-inner">
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Laravel 12</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Livewire</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Tailwind CSS</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">MySQL / Redis</div>
            </div>
        </div>
    </section>

    <!-- Section 4.5: Security & Compliance Certifications -->
    <section class="py-12 bg-slate-50/30 border-y border-slate-150">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-center text-center">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-2 border border-indigo-100">
                    <svg class="w-5 h-5 text-indigo-650" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-800">ISO 27001 Ready</h4>
                <p class="text-[10px] text-slate-400 font-medium">Arsitektur keamanan data terenkripsi standar internasional.</p>
            </div>
            
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-2 border border-indigo-100">
                    <svg class="w-5 h-5 text-indigo-650" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-800">Kominfo Registered</h4>
                <p class="text-[10px] text-slate-400 font-medium">Terdaftar sebagai Penyelenggara Sistem Elektronik resmi.</p>
            </div>

            <div class="space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-2 border border-indigo-100">
                    <svg class="w-5 h-5 text-indigo-650" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="text-xs font-bold text-slate-800">GDPR &amp; PDP Compliant</h4>
                <p class="text-[10px] text-slate-400 font-medium">Kebijakan keamanan &amp; hak privasi data penyewa terjaga ketat.</p>
            </div>
        </div>
    </section>

    <!-- Section 5: Strategic Roadmap 2027 (Interactive Timeline Track) -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Rencana Masa Depan</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Peta Jalan Pengembangan 2026/2027</h3>
            </div>
            
            <!-- Vertical Timeline Track -->
            <div class="relative border-l-2 border-indigo-200 ml-4 md:ml-32 space-y-8 text-left">
                <!-- Timeline item 1 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-indigo-600 border-4 border-white shadow-xs"></div>
                    <div class="md:absolute md:-left-36 md:top-1 md:w-28 text-right font-black text-indigo-650 text-xs uppercase">Q3 2026</div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
                        <h4 class="text-sm font-bold text-slate-900">Notifikasi WA Gateway Terintegrasi</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">Pengiriman otomatis tagihan sewa dan tanda terima pembayaran langsung ke WhatsApp penghuni tanpa hambatan.</p>
                    </div>
                </div>

                <!-- Timeline item 2 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-indigo-600 border-4 border-white shadow-xs"></div>
                    <div class="md:absolute md:-left-36 md:top-1 md:w-28 text-right font-black text-indigo-650 text-xs uppercase">Q4 2026</div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
                        <h4 class="text-sm font-bold text-slate-900">Virtual Account Auto-Reconciliation</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">Integrasi otomatisasi pembayaran via Virtual Account bank nasional (BCA, Mandiri, BRI) untuk verifikasi instan tanpa unggah manual.</p>
                    </div>
                </div>

                <!-- Timeline item 3 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-indigo-600 border-4 border-white shadow-xs"></div>
                    <div class="md:absolute md:-left-36 md:top-1 md:w-28 text-right font-black text-indigo-650 text-xs uppercase">Q1 2027</div>
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
                        <h4 class="text-sm font-bold text-slate-900">Smart IoT Metering</h4>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1 font-medium">Sinkronisasi data pencatatan meteran listrik/air otomatis berbasis IoT secara nirkabel langsung ke dasbor ruang kerja Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: Headquarters Info -->
    <section class="py-16 bg-white border-t border-slate-150">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-4">
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Kantor Utama &amp; Tim Pengembang</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed font-medium">
                Dikembangkan oleh Rivan Alamsyah bersama tim pakar teknologi properti di Bandung, Jawa Barat, Indonesia.
            </p>
        </div>
    </section>

</x-marketing-layout>
