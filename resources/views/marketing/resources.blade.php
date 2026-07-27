<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- Articles Hub Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Blog",
      "name": "Pusat Panduan & Artikel Kosan",
      "description": "Panduan praktis dan artikel dari pakar untuk meningkatkan okupansi kos dan mengotomatisasi penagihan sewa.",
      "publisher": {
        "@@type": "Organization",
        "name": "Kosan"
      }
    }
    </script>
    @endpush

    <!-- Resources Custom Styles -->
    <style>
        .resources-mesh {
            background-image: radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.04), transparent 50%);
        }
    </style>

    <!-- Section 1: Hero Banner -->
    <section class="relative overflow-hidden pt-28 pb-12 text-center space-y-4 bg-slate-50/30 resources-mesh">
        <div class="absolute top-0 left-1/4 w-80 h-80 bg-purple-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Pusat Panduan &amp; Blog
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Insight &amp; Panduan <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Bisnis Properti Modern</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                Temukan tips praktis, panduan operasional hunian, dan saran regulasi hukum sewa dari spesialis bisnis properti kami.
            </p>
            
            <!-- Search Input Box -->
            <div class="max-w-md mx-auto pt-4 relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                <div class="relative flex gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                    <input type="text" placeholder="Cari panduan sewa, tips hunian, dll..." aria-label="Cari artikel atau panduan"
                           class="flex-1 px-4 py-2.5 bg-transparent border-0 text-xs text-slate-900 placeholder-slate-400 focus:ring-0 focus:outline-hidden" />
                    <x-button variant="primary" size="sm" class="px-5 cursor-pointer">Cari</x-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Category Filter Grid -->
    <section class="py-6 bg-white border-b border-slate-150">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-2">
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white cursor-pointer shadow-xs">Semua Artikel</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-655 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Operasional Properti</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-655 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Keuangan &amp; Penagihan</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-655 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Hubungan Penghuni</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-655 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Studi Kasus</button>
        </div>
    </section>

    <!-- Section 3: Featured Article Showcase -->
    <section class="py-12 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="p-6 bg-white border border-slate-200/80 rounded-3xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center shadow-sm hover:shadow-md transition-shadow group">
                <!-- Cover frame -->
                <div class="aspect-[4/3] overflow-hidden rounded-2xl shadow-inner border border-slate-100 bg-slate-550 relative">
                    <img src="{{ asset('assets/images/blog/featured_2026.png') }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500" alt="Panduan Utama 2026">
                </div>
                <div class="space-y-4 text-left">
                    <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md">Operasional Properti</span>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Cara Memaksimalkan Okupansi &amp; Pendapatan Kos-Kosan di Tahun 2026</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">
                        Panduan komprehensif tentang cara menata alokasi kamar, menyusun fasilitas unggulan, dan menarik calon penghuni baru untuk menekan durasi kamar kosong.
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-xs font-bold text-slate-700">
                        <span>Rivan Alamsyah</span>
                        <span class="text-[10px] text-slate-400 font-medium font-mono">&bull; 8 menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Articles Grid -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full group">
                <div class="h-40 bg-slate-100 overflow-hidden flex-shrink-0 relative">
                    <img src="{{ asset('assets/images/blog/bank_reconciliation.png') }}" class="w-full h-full object-cover group-hover:scale-101.5 transition duration-300" alt="Bank Reconciliation">
                </div>
                <div class="p-5 flex flex-col justify-between flex-1 text-left">
                    <div class="space-y-3">
                        <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md">Keuangan &amp; Penagihan</span>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Panduan Rekonsiliasi Otomatis Transfer Bank BCA/Mandiri</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Cara mencocokkan mutasi rekening bank dengan daftar tagihan bulanan tanpa kesalahan verifikasi manual.</p>
                    </div>
                    <p class="text-[9.5px] text-slate-400 font-bold font-mono pt-4">12 Jul 2026 &bull; 5 menit baca</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full group">
                <div class="h-40 bg-slate-100 overflow-hidden flex-shrink-0 relative">
                    <img src="{{ asset('assets/images/blog/rules_guide.png') }}" class="w-full h-full object-cover group-hover:scale-101.5 transition duration-300" alt="Rules Guide">
                </div>
                <div class="p-5 flex flex-col justify-between flex-1 text-left">
                    <div class="space-y-3">
                        <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md">Hubungan Penghuni</span>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Menyusun Aturan &amp; Tata Tertib Kos yang Efektif</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Cara merumuskan tata tertib kos mengenai jam berkunjung, batas jam malam, dan ketenangan untuk mencegah konflik.</p>
                    </div>
                    <p class="text-[9.5px] text-slate-400 font-bold font-mono pt-4">08 Jul 2026 &bull; 4 menit baca</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-md hover:-translate-y-1 transition duration-200 flex flex-col h-full group">
                <div class="h-40 bg-slate-100 overflow-hidden flex-shrink-0 relative">
                    <img src="{{ asset('assets/images/blog/checkout_guide.png') }}" class="w-full h-full object-cover group-hover:scale-101.5 transition duration-300" alt="Checkout Guide">
                </div>
                <div class="p-5 flex flex-col justify-between flex-1 text-left">
                    <div class="space-y-3">
                        <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md">Operasional Properti</span>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Panduan Kelola Check-In &amp; Check-Out Penghuni</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Langkah sistematis mencatat posisi meteran listrik awal, menghitung sisa deposit jaminan, dan menginspeksi kamar.</p>
                    </div>
                    <p class="text-[9.5px] text-slate-400 font-bold font-mono pt-4">02 Jul 2026 &bull; 6 menit baca</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Case Study Showcase -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="p-8 bg-gradient-to-r from-indigo-900 to-indigo-950 text-white rounded-3xl space-y-6 relative overflow-hidden shadow-xl text-left">
                <!-- Backlight glow -->
                <div class="absolute inset-y-0 right-0 w-80 bg-[radial-gradient(circle_at_right,rgba(99,102,241,0.25),transparent_60%)]"></div>

                <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-500/20 text-indigo-200 border border-indigo-400/30 uppercase tracking-widest">Studi Kasus Bisnis</span>
                <h3 class="text-3xl font-black tracking-tight leading-tight">Bagaimana Kos Cihampelas Utama Mencapai Pelunasan Sewa 99.2% dalam 3 Bulan</h3>
                <p class="text-xs text-indigo-200/90 max-w-2xl leading-relaxed font-medium">
                    Pelajari strategi pengelolaan 48 unit kamar kos di Bandung yang sukses memangkas penagihan sewa manual hingga 80% dengan menerapkan otomatisasi faktur Kosan.
                </p>
                <x-button variant="primary" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 font-extrabold cursor-pointer" onclick="window.location.href='{{ route('register') }}'">
                    Baca Studi Kasus Lengkap
                </x-button>
            </div>
        </div>
    </section>

    <!-- Section 6: Upcoming Webinar Registration -->
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6 text-center space-y-6">
            <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-600 border border-indigo-150/50 uppercase tracking-widest">Webinar Interaktif</span>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Strategi Mengembangkan Bisnis Kos Komersial di Era Digital</h3>
            <p class="text-xs text-slate-500 max-w-lg mx-auto font-medium">Ikuti sesi konsultasi langsung bersama pakar manajemen properti seputar strategi pelunasan sewa tepat waktu.</p>
            
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Masukkan alamat email Anda..." required aria-label="Alamat Email Webinar"
                       class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                <x-button variant="primary" size="sm" type="submit" class="cursor-pointer">Daftar Webinar Gratis</x-button>
            </form>
        </div>
    </section>

</x-marketing-layout>
