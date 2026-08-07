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

    <!-- Section 2: Latar Belakang & Mengapa Kami Membangun Kosan -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-8 text-left">
            <div class="space-y-3">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md">Latar Belakang</span>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">Mengapa Kami Membangun Kosan</h2>
            </div>
            <p class="text-sm text-slate-550 leading-relaxed font-medium">
                Mengelola kos-kosan di Indonesia sering kali masih menggunakan metode konvensional: pencatatan di buku fisik, spreadsheet yang rumit, hingga penagihan manual lewat chat WhatsApp yang menyita waktu. Hal ini tidak hanya memicu miskomunikasi antara pemilik dan penghuni, tetapi juga memicu risiko kebocoran keuangan, hilangnya deposit jaminan, dan bukti transfer palsu.
            </p>
            <p class="text-sm text-slate-550 leading-relaxed font-medium">
                Kosan hadir sebagai jawaban atas tantangan tersebut. Kami membangun sistem operasi manajemen kos yang tangguh untuk membebaskan pemilik kos dari beban kerja administratif yang repetitif, sehingga mereka dapat fokus mengembangkan skala bisnis properti mereka.
            </p>
        </div>
    </section>

    <!-- Section 3: Nilai Tambah Properti (Property ROI) -->
    <section class="py-20 bg-slate-50/50 border-y border-slate-200/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Dampak Nyata</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Meningkatkan Keuntungan &amp; Efisiensi</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 text-left">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">✓</div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Rasio Okupansi Lebih Tinggi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Portal digital yang modern dan transparan meningkatkan loyalitas penghuni lama serta menarik minat calon penyewa baru secara signifikan.</p>
                </div>
                
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 text-left">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">✓</div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Nol Bukti Transfer Palsu</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Verifikasi data bank yang presisi menghilangkan risiko kecurangan manipulasi nota transfer pembayaran sewa bulanan oleh oknum penyewa.</p>
                </div>
                
                <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 text-left">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">✓</div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Hemat 80% Waktu Staf</h4>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium">Otomatisasi tagihan, pembuatan laporan keuangan rugi-laba instan, dan tiket keluhan otomatis menghemat puluhan jam kerja admin bulanan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Layanan Onboarding & Migrasi Data -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center text-left">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded-md">Layanan Eksklusif</span>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Migrasi Data Instan Dibantu Tim Spesialis Kami</h3>
                <p class="text-sm text-slate-500 leading-relaxed font-medium">
                    Khawatir repot memindahkan puluhan data penghuni dan kamar dari Excel atau buku fisik? Tim migrasi Kosan siap membantu merapikan, memformat, dan mengimpor seluruh data properti Anda secara gratis tanpa ada kendala operasional berjalan.
                </p>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl space-y-4 shadow-inner text-xs font-semibold text-slate-700">
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <span>Format data Excel Anda dirapikan oleh tim ahli kami</span>
                </div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <span>Bulk import data kamar dan penyewa dalam hitungan detik</span>
                </div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    <span>Pelatihan langsung bagi staf operasional kos Anda</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Kantor Utama & Tim Pengembang -->
    <section class="py-20 bg-slate-50/50 border-t border-slate-200/50">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Tim Kami</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Kantor Utama &amp; Tim Pengembang</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed font-medium">Kosan dirancang dan dikembangkan dengan dedikasi tinggi oleh para profesional berpengalaman.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                <!-- Card 1: Office info -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between text-left space-y-6">
                    <div class="space-y-4">
                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200/50 uppercase tracking-wider font-mono">HEADQUARTERS</span>
                        <h4 class="text-lg font-black text-slate-900">Kantor Operasional Utama</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Kosan HQ berlokasi di pusat inovasi teknologi Bandung, Jawa Barat. Kami menyediakan layanan dukungan pelanggan, migrasi data, dan kemitraan strategis langsung dari kantor operasional kami.
                        </p>
                    </div>
                    <div class="space-y-2.5 pt-4 border-t border-slate-100 text-xs font-semibold text-slate-600">
                        <div class="flex items-center gap-2.5">
                            <span class="text-indigo-600">📍</span>
                            <span>Jl. Ir. H. Juanda No. 150, Dago, Bandung, Jawa Barat</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="text-indigo-600">✉️</span>
                            <span>support@kosan.id / info@kosan.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="text-indigo-600">📞</span>
                            <span>+62 (22) 420-1926</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Developer Team -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col justify-between text-left space-y-6">
                    <div class="space-y-4">
                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-200/50 uppercase tracking-wider font-mono">DEVELOPER</span>
                        <h4 class="text-lg font-black text-slate-900">Pimpinan Pengembangan</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">
                            Dipimpin oleh **Rivan Alamsyah**, arsitek perangkat lunak utama bersama tim insinyur properti yang berfokus membangun produk SaaS berkinerja tinggi, aman, dan dirancang khusus untuk operasional riil di Indonesia.
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <div class="w-12 h-12 rounded-full bg-indigo-150 text-indigo-600 flex items-center justify-center font-black text-base shadow-inner">
                            RA
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-900">Rivan Alamsyah</h5>
                            <p class="text-[10px] text-indigo-600 font-extrabold uppercase tracking-wider">Founder &amp; Principal Architect</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-marketing-layout>
