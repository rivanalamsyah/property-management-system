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

    <!-- Section 1: Hero Banner (UCD: Story & Credibility) -->
    <section class="pt-20 pb-12 text-center space-y-4 bg-gradient-to-b from-indigo-50/30 via-white to-white">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
            Kisah &amp; Filosofi Produk
        </span>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">Mentransformasi Operasional Bisnis Kos di Indonesia</h1>
        <p class="text-slate-600 text-sm max-w-lg mx-auto leading-relaxed">
            Kami membangun sistem operasi manajemen kos yang aman, cepat, dan modern untuk pengelola dan pemilik hunian komersial.
        </p>
    </section>

    <!-- Section 2: Mission & Vision -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-3">
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Misi Kami</h3>
                <p class="text-xs text-slate-500 leading-relaxed text-justify">
                    Menghilangkan kerumitan operasional pemilik kos. Dengan mengotomatisasi penerbitan faktur tagihan sewa, menyediakan verifikasi bukti transfer otomatis, dan memberikan portal digital mandiri bagi penghuni, kami mengembalikan waktu berharga pemilik kos dari beban administrasi manual.
                </p>
            </div>
            <div class="space-y-3">
                <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Visi Kami</h3>
                <p class="text-xs text-slate-500 leading-relaxed text-justify">
                    Menjadi fondasi perangkat lunak standar untuk pengelolaan properti hunian dan mikro-apartemen di Indonesia, yang memberdayakan pengelola kos untuk meningkatkan potensi imbal hasil properti tanpa perlu menambah beban staf administrasi.
                </p>
            </div>
        </div>
    </section>

    <!-- Section 3: Core Values Cards (UCD: Trust Pillars) -->
    <section class="py-16 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Prinsip Utama</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Nilai-Nilai Utama Operasional</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Transparansi Keuangan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Kami menjaga pembukuan faktur tagihan dan riwayat pelunasan secara transparan untuk menjamin audit keuangan yang akurat.</p>
                </x-card>
                
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Isolasi Data Terjamin</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Setiap data ruang kerja properti dienkripsi dan diisolasi dengan batasan keamanan yang ketat. Akses data antar pemilik kos dicegah secara mutlak.</p>
                </x-card>
                
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Inovasi Operasional</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Dari portal PWA penghuni hingga grafik keuangan interaktif, kami merancang pengalaman pengguna yang modern dan responsif.</p>
                </x-card>

                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Dukungan Pelanggan Responsif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Kami mendampingi proses pendaftaran dan konfigurasi awal properti Anda agar manfaat otomatisasi langsung terasa sejak hari pertama.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Section 4: Technology Stack -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Arsitektur Teknologi</span>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Dirancang untuk Kecepatan &amp; Stabilitas Tinggi</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Kosan dibangun di atas kerangka kerja Laravel 12, dilengkapi reaktivitas real-time via Livewire dan Alpine.js, tata letak Tailwind CSS, serta sistem basis data MySQL yang tangguh.
                </p>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl grid grid-cols-2 gap-4 text-xs font-bold text-slate-700 text-center shadow-inner">
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Laravel 12</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Livewire</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">Tailwind CSS</div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">MySQL / Redis</div>
            </div>
        </div>
    </section>

    <!-- Section 5: Strategic Roadmap 2027 -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            <div class="text-center space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Rencana Masa Depan</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rencana Strategis Pengorganisasian 2027</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-card class="space-y-2">
                    <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider">Q3 2026</span>
                    <h4 class="text-sm font-bold text-slate-900">Notifikasi WA Gateway</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Pengiriman notifikasi tagihan bulanan langsung via API WhatsApp ke smartphone penghuni.</p>
                </x-card>

                <x-card class="space-y-2">
                    <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider">Q4 2026</span>
                    <h4 class="text-sm font-bold text-slate-900">Virtual Account Auto-Reconciliation</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Integrasi otomatisasi pembayaran via Virtual Account BCA/Mandiri/BRI.</p>
                </x-card>

                <x-card class="space-y-2">
                    <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-wider">Q1 2027</span>
                    <h4 class="text-sm font-bold text-slate-900">Smart IoT Metering</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Pencatatan meteran listrik/air otomatis berbasis sensor IoT langsung ke dashboard.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Section 6: Headquarters Info -->
    <section class="py-16 bg-white border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-4">
            <h3 class="text-xl font-extrabold text-slate-900 tracking-tight">Kantor Utama &amp; Tim Pengembang</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                Dikembangkan oleh Rivan Alamsyah bersama tim pakar teknologi properti di Bandung, Jawa Barat, Indonesia.
            </p>
        </div>
    </section>

</x-marketing-layout>
