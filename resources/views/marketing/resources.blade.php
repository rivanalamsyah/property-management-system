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

    <!-- Section 1: Hero Banner (UCD: Information Discovery Focus) -->
    <section class="pt-20 pb-12 text-center space-y-4 bg-gradient-to-b from-indigo-50/30 via-white to-white">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
            Pusat Panduan &amp; Blog
        </span>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">Panduan, Artikel &amp; Insight Bisnis Kos</h1>
        <p class="text-slate-600 text-sm max-w-lg mx-auto leading-relaxed">
            Temukan panduan praktis, panduan operasional, dan saran hukum sewa-menyewa dari spesialis pertumbuhan properti.
        </p>
        <!-- Search input box -->
        <div class="max-w-md mx-auto pt-4 px-6">
            <div class="flex gap-2">
                <input type="text" placeholder="Cari artikel, panduan, atau FAQ..." aria-label="Cari artikel atau panduan"
                       class="flex-1 px-4 py-2.5 bg-white border border-slate-200/80 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-2xs transition" />
                <x-button variant="primary" size="sm" class="px-5">Cari</x-button>
            </div>
        </div>
    </section>

    <!-- Section 2: Category Filter Grid -->
    <section class="py-6 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap justify-center gap-2">
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white cursor-pointer shadow-2xs">Semua Artikel</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Operasional Properti</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Keuangan &amp; Penagihan</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Hubungan Penghuni</button>
            <button class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200/60 transition cursor-pointer">Studi Kasus</button>
        </div>
    </section>

    <!-- Section 3: Featured Article Showcase -->
    <section class="py-12 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="p-8 bg-white border border-slate-200/80 rounded-3xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center shadow-sm">
                <div class="aspect-[4/3] bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-2xl flex items-center justify-center text-white text-lg font-bold shadow-md">
                    Panduan Utama 2026
                </div>
                <div class="space-y-4">
                    <span class="text-[10px] font-extrabold text-indigo-600 uppercase tracking-widest">Operasional Properti</span>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Cara Memaksimalkan Okupansi &amp; Pendapatan Kos-Kosan di Tahun 2026</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Panduan komprehensif tentang cara menata alokasi kamar, menyusun fasilitas unggulan, dan menarik calon penghuni baru untuk menekan durasi kamar kosong.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="text-xs font-bold text-slate-800">Rivan Alamsyah</span>
                        <span class="text-[10px] text-slate-400 font-medium">&bull; 8 menit baca</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Articles Grid -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <x-card :hover="true" class="space-y-4">
                <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider">Keuangan &amp; Penagihan</span>
                <h4 class="text-base font-bold text-slate-900 tracking-tight">Panduan Rekonsiliasi Otomatis Transfer Bank BCA/Mandiri</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Cara mencocokkan mutasi rekening bank dengan daftar tagihan bulanan tanpa kesalahan verifikasi manual.</p>
                <p class="text-[10px] text-slate-400 font-medium pt-2">12 Jul 2026 &bull; 5 menit baca</p>
            </x-card>

            <x-card :hover="true" class="space-y-4">
                <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider">Hubungan Penghuni</span>
                <h4 class="text-base font-bold text-slate-900 tracking-tight">Menyusun Aturan &amp; Tata Tertib Kos yang Efektif</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Cara merumuskan tata tertib kos mengenai jam berkunjung, batas jam malam, dan ketenangan untuk mencegah konflik antar penghuni.</p>
                <p class="text-[10px] text-slate-400 font-medium pt-2">08 Jul 2026 &bull; 4 menit baca</p>
            </x-card>

            <x-card :hover="true" class="space-y-4">
                <span class="text-[9px] font-extrabold text-indigo-600 uppercase tracking-wider">Operasional Properti</span>
                <h4 class="text-base font-bold text-slate-900 tracking-tight">Panduan Kelola Check-In &amp; Check-Out Penghuni</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Langkah sistematis mencatat posisi meteran listrik awal, menghitung sisa deposit jaminan, dan menginspeksi kerusakan kamar.</p>
                <p class="text-[10px] text-slate-400 font-medium pt-2">02 Jul 2026 &bull; 6 menit baca</p>
            </x-card>
        </div>
    </section>

    <!-- Section 5: Detailed Case Study Showcase -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="p-8 bg-gradient-to-r from-indigo-900 to-indigo-950 text-white rounded-3xl space-y-6 relative overflow-hidden shadow-xl">
                <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-500/20 text-indigo-200 border border-indigo-400/30 uppercase tracking-widest">Studi Kasus Pembeli</span>
                <h3 class="text-3xl font-black tracking-tight leading-tight">Bagaimana Kos Cihampelas 10 Mencapai Pelunasan 99.2% dalam 3 Bulan</h3>
                <p class="text-xs text-indigo-200/90 max-w-2xl leading-relaxed">
                    Pelajari strategi pengelolaan 48 unit kamar kos di Bandung yang sukses memangkas penagihan sewa manual hingga 80% dengan menerapkan otomatisasi faktur Kosan.
                </p>
                <x-button variant="primary" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 font-bold" onclick="window.location.href='{{ route('register') }}'">
                    Baca Studi Kasus Lengkap
                </x-button>
            </div>
        </div>
    </section>

    <!-- Section 6: Upcoming Webinar Registration -->
    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-6 text-center space-y-6">
            <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold bg-indigo-50 text-indigo-600 uppercase tracking-widest">Webinar Interaktif</span>
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Strategi Mengembangkan Bisnis Kos Komersial di Era Digital</h3>
            <p class="text-xs text-slate-500 max-w-lg mx-auto">Ikuti sesi konsultasi langsung bersama pakar manajemen properti seputar strategi pelunasan sewa tepat waktu.</p>
            
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Masukkan alamat email Anda..." required aria-label="Alamat Email Webinar"
                       class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                <x-button variant="primary" size="sm" type="submit">Daftar Webinar Gratis</x-button>
            </form>
        </div>
    </section>

</x-marketing-layout>
