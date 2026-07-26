<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    <!-- Section 1: Hero Header -->
    <section class="pt-20 pb-12 text-center space-y-4 bg-gradient-to-b from-indigo-50/20 via-white to-white">
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 text-indigo-600 uppercase tracking-widest">Legal &amp; Kepatuhan</span>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900">Kebijakan Privasi &amp; Perlindungan Data</h1>
        <p class="text-slate-500 text-sm max-w-lg mx-auto">
            Komitmen kami dalam menjaga kerahasiaan, keamanan, dan tata kelola data pemilik kos serta penghuni hunian.
        </p>
    </section>

    <!-- Section 2: Policy Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 space-y-10 text-slate-700 leading-relaxed text-sm">
            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">1. Pendahuluan</h2>
                <p>
                    Platform Kosan ("Kami") berkomitmen penuh untuk melindungi privasi dan keamanan data pribadi pengguna kami, baik pemilik kos, pengelola properti, maupun penghuni hunian. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, mengolah, menyimpan, dan melindungi informasi pribadi Anda saat menggunakan layanan platform SaaS Kosan.
                </p>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">2. Informasi yang Kami Kumpulkan</h2>
                <p>Untuk menjalankan fungsi operasional manajemen kos, kami mengumpulkan beberapa jenis data meliputi:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li><strong>Data Akun Pemilik/Pengelola:</strong> Nama lengkap, alamat email, nomor WhatsApp/telepon, nama bisnis/brand kos, dan informasi pembayaran langganan.</li>
                    <li><strong>Data Properti &amp; Kamar:</strong> Alamat lokasi kos, tipe unit kamar, harga sewa, dan data meteran utilitas (listrik/air).</li>
                    <li><strong>Data Identitas Penghuni:</strong> Nama penghuni, Nomor Induk Kependudukan (NIK), kontak darurat, foto profil, dan berkas kontrak sewa.</li>
                    <li><strong>Data Transaksi Keuangan:</strong> Nomor faktur tagihan, tanggal jatuh tempo, dan unggahan bukti transfer pembayaran bank.</li>
                </ul>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">3. Penggunaan Informasi</h2>
                <p>Informasi yang dikumpulkan digunakan secara eksklusif untuk tujuan operasional berikut:</p>
                <ul class="list-disc pl-5 space-y-1.5 text-slate-600">
                    <li>Menerbitkan dan mengotomatisasi faktur tagihan sewa bulanan secara akurat.</li>
                    <li>Memfasilitasi alur verifikasi bukti bayar antara penghuni dan pengelola kos.</li>
                    <li>Menyediakan akses login portal digital PWA khusus bagi penghuni terdaftar.</li>
                    <li>Menyajikan laporan keuangan dan grafik analisis bisnis untuk pemilik kos.</li>
                    <li>Mengirimkan notifikasi penting terkait jatuh tempo sewa dan pengumuman properti.</li>
                </ul>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">4. Keamanan &amp; Isolasi Data Multi-Tenant</h2>
                <p>
                    Kami menerapkan standar keamanan enkripsi SSL/TLS pada setiap jalur transmisi data. Setiap ruang kerja (*workspace*) properti diisolasi secara ketat menggunakan arsitektur multi-tenant, sehingga data suatu lokasi kos tidak dapat diakses oleh pemilik atau pihak lain di luar organisasi yang sah.
                </p>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">5. Penggunaan Cookie</h2>
                <p>
                    Platform kami menggunakan cookie untuk menyimpan sesi autentikasi pengguna, menganalisis lalu lintas platform, dan mengingat preferensi pengaturan ruang kerja Anda. Anda dapat mengontrol pengaturan cookie melalui spanduk persetujuan cookie yang tersedia.
                </p>
            </div>

            <div class="space-y-3">
                <h2 class="text-lg font-bold text-slate-900">6. Hak Pengguna &amp; Pembaharuan</h2>
                <p>
                    Pengguna berhak untuk memperbarui profil, mengunduh salinan data tagihan, atau mengajukan penutupan akun. Kami dapat memperbarui Kebijakan Privasi ini secara berkala untuk menyesuaikan perkembangan regulasi atau peningkatan sistem keamanan kami.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-100 text-xs text-slate-400">
                Terakhir Diperbarui: 23 Juli 2026 &bull; Tim Legal Kosan Platform
            </div>
        </div>
    </section>

</x-marketing-layout>
