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

    <!-- Section 1: Hero Banner (UCD: Low Friction Demo Request) -->
    <section class="pt-20 pb-12 text-center space-y-4 bg-gradient-to-b from-indigo-50/30 via-white to-white">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
            Hubungi Tim Sales &amp; Konsultasi
        </span>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">Konsultasikan Kebutuhan Bisnis Kos Anda</h1>
        <p class="text-slate-600 text-sm max-w-lg mx-auto leading-relaxed">
            Jadwalkan demo khusus, dapatkan dukungan integrasi, atau diskusikan opsi paket kustom bersama spesialis pertumbuhan properti kami.
        </p>
    </section>

    <!-- Main Content Area -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left: Livewire Form Section -->
            <div class="space-y-6">
                <livewire:marketing.contact-form />
            </div>

            <!-- Right: Details, Channels, Hours, Maps -->
            <div class="space-y-8">
                <!-- Communication Channels Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-card :hover="true" class="space-y-2 text-xs">
                        <span class="font-bold text-slate-900">Saluran WhatsApp Resmi</span>
                        <p class="text-slate-500">Bantuan langsung via chat untuk diskusi seputar operasional kos.</p>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="text-indigo-600 font-bold hover:underline inline-block pt-1">
                            Chat via WhatsApp +62 812 3456 7890 &rarr;
                        </a>
                    </x-card>

                    <x-card :hover="true" class="space-y-2 text-xs">
                        <span class="font-bold text-slate-900">Pertanyaan Umum &amp; Kerjasama</span>
                        <p class="text-slate-500">Hubungan korporat, kepatuhan legal, dan integrasi API kustom.</p>
                        <a href="mailto:business@kosan.test" class="text-indigo-600 font-bold hover:underline inline-block pt-1">
                            business@kosan.test &rarr;
                        </a>
                    </x-card>
                </div>

                <!-- Office Location & Map Preview -->
                <x-card class="min-h-[180px] flex flex-col justify-between text-xs space-y-4">
                    <span class="font-extrabold text-slate-900 uppercase tracking-wider">Lokasi Kantor Utama</span>
                    <div class="flex-1 bg-slate-50 border border-slate-200/80 rounded-2xl p-6 flex items-center justify-center text-slate-500 font-mono text-xs shadow-inner">
                        📍 Jl. Dago Giri No. 45, Bandung, Jawa Barat 40142
                    </div>
                </x-card>

                <!-- Customer Support & Office Hours -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div class="space-y-1.5">
                        <h4 class="font-bold text-slate-900">Layanan Pelanggan</h4>
                        <p class="text-slate-500 leading-relaxed">
                            Sudah menjadi pengguna platform Kosan? Akses pusat dokumentasi atau buat tiket bantuan teknis secara langsung dari menu pengaturan ruang kerja Anda.
                        </p>
                    </div>

                    <div class="space-y-1.5">
                        <h4 class="font-bold text-slate-900">Jam Operasional</h4>
                        <p class="text-slate-500 leading-relaxed">
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
    <section class="py-16 bg-slate-50/50 border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6 space-y-8">
            <h3 class="text-xl font-extrabold text-slate-900 text-center tracking-tight">Pertanyaan yang Sering Diajukan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card class="space-y-1.5">
                    <h4 class="font-bold text-slate-900">Berapa lama durasi demo platform?</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Umumnya berlangsung 20-30 menit. Sesi fokus menampilkan simulasi konfigurasi multi-properti, otomatisasi interval penagihan sewa, dan portal digital penghuni.</p>
                </x-card>
                
                <x-card class="space-y-1.5">
                    <h4 class="font-bold text-slate-900">Apakah tersedia bantuan pendaftaran awal (onboarding)?</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Ya! Untuk ruang kerja dengan kapasitas di atas 50 kamar, tim teknis kami siap membantu mengimpor daftar kamar dan mendampingi integrasi staf operasional Anda.</p>
                </x-card>
            </div>
        </div>
    </section>

</x-marketing-layout>
