<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- Organizations Contact / FAQ Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "ContactPage",
      "mainEntity": {
        "@@type": "Organization",
        "name": "Kosan",
        "telephone": "+62-812-3456-7890",
        "email": "support@kosan.test"
      }
    }
    </script>
    @endpush

    <!-- Contact Custom Styles -->
    <style>
        .contact-mesh {
            background-image: radial-gradient(circle at 90% 10%, rgba(99, 102, 241, 0.04), transparent 50%);
        }
    </style>

    <!-- Section 1: Hero Banner -->
    <section class="relative overflow-hidden pt-28 pb-12 text-center space-y-4 bg-slate-50/30 contact-mesh">
        <div class="absolute top-0 left-1/4 w-80 h-80 bg-indigo-400/5 rounded-full blur-3xl pointer-events-none -z-10"></div>
        
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white border border-slate-200/60 text-slate-800 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Hubungi Tim Sales &amp; Konsultasi
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Konsultasikan Kebutuhan <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600">Bisnis Kos Anda</span>
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                Jadwalkan demo khusus, dapatkan dukungan migrasi data, atau diskusikan opsi paket kustom bersama spesialis pertumbuhan properti kami.
            </p>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left: Livewire Form Section inside glass box -->
            <div class="lg:col-span-6 bg-slate-50/50 border border-slate-200/80 rounded-3xl p-6 shadow-inner">
                <livewire:marketing.contact-form />
            </div>

            <!-- Right: Details, Channels, Hours, Maps -->
            <div class="lg:col-span-6 space-y-8 text-left">
                <!-- Communication Channels Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-xs hover:shadow-md transition duration-200 space-y-2 text-xs group">
                        <span class="font-bold text-slate-900">Saluran WhatsApp Resmi</span>
                        <p class="text-slate-500 leading-relaxed font-medium">Bantuan langsung via chat untuk diskusi seputar operasional kos.</p>
                        <a href="https://wa.me/6281234567890?text=Halo%20tim%20Kosan%2C%20saya%20tertarik%20untuk%20menjadwalkan%20demo%20dasbor%20dan%20tanya%20tentang%20paket%20kustom%20untuk%20bisnis%20kos%20saya." target="_blank" rel="noopener noreferrer" class="text-indigo-600 font-extrabold hover:underline inline-block pt-2">
                            Chat via WhatsApp +62 812 3456 7890 &rarr;
                        </a>
                    </div>

                    <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-xs hover:shadow-md transition duration-200 space-y-2 text-xs group">
                        <span class="font-bold text-slate-900">Pertanyaan Umum &amp; Kerjasama</span>
                        <p class="text-slate-500 leading-relaxed font-medium">Hubungan korporat, kepatuhan legal, dan integrasi API kustom.</p>
                        <a href="mailto:business@kosan.test" class="text-indigo-600 font-extrabold hover:underline inline-block pt-2">
                            business@kosan.test &rarr;
                        </a>
                    </div>
                </div>

                <!-- Office Location & Map Preview (Visual Card) -->
                <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-xs space-y-3">
                    <span class="text-[10px] font-extrabold text-slate-900 uppercase tracking-widest bg-slate-50 px-2.5 py-1 rounded-md border border-slate-100">Lokasi Kantor Utama</span>
                    <div class="bg-slate-50 border border-slate-150 rounded-2xl p-5 flex items-center gap-3 text-slate-655 shadow-inner">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0 text-indigo-600">
                            📍
                        </div>
                        <div class="text-xs font-semibold">
                            <h5 class="text-slate-800 font-bold">Bandung HQ</h5>
                            <p class="text-slate-500 mt-0.5">Jl. Dago Giri No. 45, Bandung, Jawa Barat 40142</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Support & Office Hours -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs font-semibold text-slate-655">
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-900">Layanan Pelanggan</h4>
                        <p class="text-slate-500 leading-relaxed font-medium">
                            Sudah menjadi pengguna platform Kosan? Akses pusat dokumentasi atau buat tiket bantuan teknis secara langsung dari menu pengaturan dasbor Anda.
                        </p>
                    </div>

                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-900">Jam Operasional</h4>
                        <p class="text-slate-500 leading-relaxed font-medium">
                            Senin - Jumat<br>
                            09.00 - 17.00 WIB (GMT+7)<br>
                            Tutup pada hari libur nasional
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Buyer FAQs -->
    <section class="py-16 bg-slate-50/50 border-t border-slate-150">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            <h3 class="text-2xl font-black text-slate-900 text-center tracking-tight">Pertanyaan yang Sering Diajukan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-sm transition space-y-2">
                    <h4 class="font-bold text-slate-800 text-xs">Berapa lama durasi demo platform?</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium">Umumnya berlangsung 20-30 menit. Sesi fokus menampilkan simulasi konfigurasi multi-properti, otomatisasi interval penagihan sewa, dan portal digital penghuni.</p>
                </div>
                
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-sm transition space-y-2">
                    <h4 class="font-bold text-slate-800 text-xs">Apakah ada batasan jumlah properti saat demo?</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium">Tidak ada batasan. Spesialis produk kami akan mensimulasikan struktur multi-properti (workspace) untuk menggambarkan kemudahan tata kelola banyak cabang.</p>
                </div>
            </div>
        </div>
    </section>

</x-marketing-layout>
