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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-xs font-semibold">
                            <h5 class="text-slate-800 font-bold">Bandung HQ</h5>
                            <p class="text-slate-500 mt-0.5">Jl. Dago Giri No. 45, Bandung, Jawa Barat 40142</p>
                        </div>
                    </div>
                    <!-- Google Maps Embed -->
                    <div class="overflow-hidden rounded-2xl border border-slate-150 aspect-[16/9] w-full">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.2462316499317!2d107.6186835749725!3d-6.861054367123991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e0d9b4b08709%3A0xc3bde8290f6c2455!2sJl.%20Dago%20Giri%20No.45%2C%20Mekarwangi%2C%20Kec.%20Lembang%2C%20Kabupaten%20Bandung%20Barat%2C%20Jawa%20Barat%2040391!5e0!3m2!1sid!2sid!4v1722137000000!5m2!1sid!2sid" 
                            class="w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
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
    <section class="py-24 bg-slate-50/30 border-t border-slate-150" x-data="{ openFaq: null }">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            <div class="text-center space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">FAQ</h2>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h3>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 1 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 1 ? null : 1">
                        <span>Berapa lama durasi demo platform?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 1 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 1" x-transition>
                        Umumnya berlangsung 20-30 menit. Sesi fokus menampilkan simulasi konfigurasi multi-properti, otomatisasi interval penagihan sewa, dan portal digital penghuni.
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition duration-200" :class="openFaq === 2 ? 'shadow-md border-indigo-200' : 'hover:border-slate-350'">
                    <button class="w-full text-left px-6 py-5 font-bold text-slate-800 flex justify-between items-center text-sm sm:text-base hover:bg-slate-50/50 transition cursor-pointer"
                            @click="openFaq = openFaq === 2 ? null : 2">
                        <span>Apakah ada batasan jumlah properti saat demo?</span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-350" :class="openFaq === 2 ? 'rotate-180 text-indigo-600' : ''" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div class="px-6 pb-5 text-xs sm:text-sm text-slate-550 leading-relaxed font-medium transition-all duration-300"
                         x-show="openFaq === 2" x-transition>
                        Tidak ada batasan. Spesialis produk kami akan mensimulasikan struktur multi-properti (workspace) untuk menggambarkan kemudahan tata kelola banyak cabang.
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-marketing-layout>
