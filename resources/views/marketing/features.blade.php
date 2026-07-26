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
        "name": "Fitur",
        "item": "{{ route('features') }}"
      }]
    }
    </script>
    @endpush

    <!-- Section 1: Hero Banner (UCD: Feature Value Proposition) -->
    <section class="pt-20 pb-16 bg-gradient-to-b from-indigo-50/30 via-slate-50 to-white text-center space-y-6">
        <div class="max-w-4xl mx-auto px-6 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                Kemampuan Produk &amp; Modul Utama
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-slate-900 leading-tight">
                Solusi Lengkap Mengelola &amp; Mengembangkan Bisnis Kos
            </h1>
            <p class="text-slate-600 text-base max-w-2xl mx-auto leading-relaxed">
                Jelajahi 10 modul utama yang dirancang untuk menggantikan spreadsheet manual, mempercepat pelunasan sewa, dan menertibkan alur perbaikan.
            </p>
        </div>
    </section>

    <!-- Deep Dive Features (10 UCD Sections) -->
    <div class="space-y-20 pb-24">
        <!-- Module 01: Dashboard Command Center -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 01</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pusat Kontrol Operasional (Executive Command Dashboard)</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Dapatkan gambaran menyeluruh tentang operasional bisnis kos Anda secara real-time. Pantau persentase keterisian kamar (okupansi), rasio pelunasan tagihan sewa bulanan, dan jumlah tiket keluhan perbaikan yang belum ditangani.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menghemat 5+ jam waktu rekapitulasi manual setiap minggu.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-3">
                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Tingkat Okupansi</span>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: 92%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-600 font-medium">
                        <span>22 Kamar Terisi</span>
                        <span class="font-extrabold text-slate-900">92%</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Module 02: Room & Inventory Management -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2 space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 02</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Kamar &amp; Pencatatan Meteran Listrik/Air</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Kelompokkan kamar berdasarkan gedung kos, lantai, dan tipe unit (Standar, Deluxe). Catat posisi meteran listrik (kWh) dan air saat check-in maupun check-out untuk menghindari perselisihan biaya tagihan.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Mencegah kerugian biaya listrik yang tidak terbebankan pada penghuni.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-slate-400 tracking-wider">Pencatatan Meteran Listrik</span>
                    <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-slate-700">Kamar 101</span>
                        <span class="text-xs font-extrabold text-indigo-600 font-mono">384.20 kWh</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Module 03: Tenant Management -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 03</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Profil &amp; Siklus Hidup Penghuni</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Simpan dokumen dan identitas penghuni secara rapi: NIK, tanggal lahir, kontak darurat, dan foto profil. Pantau status penghuni dari pengajuan awal, aktif menghuni, hingga mantan penghuni atau daftarkan ke daftar hitam (blacklist).
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menjaga tertib administrasi dan keamanan lingkungan kos.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">BW</div>
                    <div class="space-y-0.5">
                        <h4 class="text-xs font-bold text-slate-800">Bruce Wayne</h4>
                        <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200/50 uppercase">Penghuni Aktif</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Module 04: Contract & Deposit Management -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2 space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 04</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengelolaan Kontrak Hunian &amp; Deposit Jaminan</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Terbitkan kontrak sewa digital dengan skema pembayaran bulanan, triwulan, atau tahunan. Catat uang muka deposit jaminan dan hitung otomatis pengembalian sisa deposit dikurangi pemotongan klaim saat check-out.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menghindari sengketa pengembalian uang deposit saat masa sewa berakhir.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[9px] uppercase font-extrabold text-slate-400">Kontrak #CTR-2026-001</span>
                        <span class="text-[9px] font-bold text-emerald-600">Aktif</span>
                    </div>
                    <div class="text-xs text-slate-700 font-semibold">Deposit: Rp 1.000.000 (Tersimpan)</div>
                </div>
            </div>
        </section>

        <!-- Module 05: Billing & Automated Invoicing -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 05</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Otomatisasi Penagihan &amp; Invoicing</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Sistem menerbitkan faktur tagihan sewa bulanan secara otomatis beberapa hari sebelum tanggal jatuh tempo. Sertakan item tambahan seperti biaya parkir, laundry, wifi, atau tagihan listrik berbasis pemakaian meteran.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menekan rasio tunggakan sewa hingga 90% melalui penagihan tepat waktu.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-slate-400">Faktur #INV-2026-08</span>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-xs font-bold text-slate-900">Total Faktur:</span>
                        <span class="text-xs font-black text-indigo-600">Rp 2.150.000</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Module 06: Payment Verification & Bank Audit -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2 space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 06</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verifikasi Pembayaran &amp; Audit Rekening</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Verifikasi bukti transfer bank yang diunggah penghuni secara teliti. Tandai status faktur sebagai "Lunas" atau "Ditolak" lengkap dengan alasan penolakan untuk dikonfirmasi kembali oleh penghuni.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Mengeliminasi risiko manipulasi nota transfer bank palsu.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase font-extrabold text-slate-400">Transfer BCA</span>
                        <h5 class="text-xs font-bold text-slate-800">Rp 2.000.000</h5>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[8px] font-extrabold bg-emerald-50 text-emerald-600 border border-emerald-200/50 uppercase">Terverifikasi</span>
                </div>
            </div>
        </section>

        <!-- Module 07: Maintenance Complaints & Tickets -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 07</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Laporan Kerusakan &amp; Chat Petugas</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Terima tiket laporan kerusakan fasilitas dari penghuni secara terstruktur. Disposisikan penanganan perbaikan kepada staf teknisi dan berikan pembaruan status perbaikan kepada penghuni.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Meningkatkan tingkat kepuasan dan perpanjangan sewa penghuni.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-rose-500">Tiket Perbaikan #302</span>
                    <p class="text-xs font-bold text-slate-800">AC Kamar 204 Kurang Dingin</p>
                    <span class="inline-block px-2 py-0.5 rounded text-[8px] font-extrabold bg-amber-50 text-amber-600 border border-amber-200/50 uppercase">Dalam Penanganan Staf</span>
                </div>
            </div>
        </section>

        <!-- Module 08: Financial Reports & BI Analytics -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2 space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 08</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Keuangan &amp; Business Intelligence</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Visualisasikan tren arus kas bulanan, rasio okupansi kamar, dan total pengeluaran operasional. Ekspor laporan keuangan dalam format CSV/Excel untuk keperluan analisis lanjutan.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menyediakan data akurat untuk keputusan ekspansi properti baru.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-slate-400">Ekspor Laporan Keuangan</span>
                    <button class="w-full py-1.5 bg-slate-100 text-slate-700 font-bold text-xs rounded-lg border border-slate-200/60">Unduh Laporan CSV</button>
                </div>
            </div>
        </section>

        <!-- Module 09: Resident PWA Web App -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 09</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Portal Digital Penghuni berbasis PWA</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Memberikan akses login mandiri bagi penghuni melalui peramban HP tanpa instalasi rumit dari Play Store / App Store. Penghuni dapat mengecek riwayat pembayaran dan mengunduh faktur.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Menampilkan citra kos modern dan profesional di mata calon penghuni.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl text-center space-y-1">
                    <span class="text-xs font-bold text-indigo-600">PWA Resident Portal Active</span>
                    <p class="text-[10px] text-slate-400">Terhubung langsung dengan server utama</p>
                </div>
            </div>
        </section>

        <!-- Module 10: Multi-Tenant Workspace & Role Permissions -->
        <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="lg:order-2 space-y-4">
                <span class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Modul 10</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Multi-Properti &amp; Hak Akses Tim</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Kelola beberapa lokasi cabang kos dalam satu akun pengguna. Tetapkan peran dan izin akses khusus untuk manajer area, kasir keuangan, atau staf operasional lapangan.
                </p>
                <div class="p-3.5 bg-indigo-50/50 border border-indigo-100 rounded-2xl text-xs text-indigo-700 font-bold inline-block shadow-2xs">
                    💡 Nilai Bisnis: Memudahkan pengelolaan banyak cabang tanpa kerancuan data aset.
                </div>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl min-h-[220px] flex items-center justify-center shadow-inner">
                <div class="w-full max-w-xs bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-2">
                    <span class="text-[9px] uppercase font-extrabold text-slate-400">Pengaturan Ruang Kerja</span>
                    <div class="text-xs font-bold text-slate-800">Workspace: Kos Cihampelas Utama</div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bottom Feature CTA Banner -->
    <section class="py-16 bg-slate-900 text-white text-center">
        <div class="max-w-4xl mx-auto px-6 space-y-6">
            <h2 class="text-3xl font-black tracking-tight">Optimalkan Operasional Kos Anda dengan Kosan OS</h2>
            <p class="text-slate-400 text-sm max-w-lg mx-auto">Mulai uji coba gratis 14 hari dan rasakan kemudahan pengelolaan bisnis kos terintegrasi.</p>
            <div class="pt-2">
                <x-button variant="primary" size="lg" class="px-8 py-3.5" onclick="window.location.href='{{ route('register') }}'">
                    Mulai Uji Coba Gratis 14 Hari
                </x-button>
            </div>
        </div>
    </section>

</x-marketing-layout>
