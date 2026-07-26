<x-marketing-layout :meta_title="$meta_title" :meta_description="$meta_description" :canonical="$canonical">

    @push('schema')
    <!-- JSON-LD FAQ & WebSite Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "{{ route('resources') }}?search={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    @endpush

    <!-- Section 1: Hero Banner (UCD: Instant Value & Low Cognitive Load) -->
    <section class="relative overflow-hidden pt-20 pb-16 md:pt-28 md:pb-24 bg-gradient-to-b from-indigo-50/30 via-slate-50 to-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(99,102,241,0.06),transparent_55%)]"></div>
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10 space-y-6">
            <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-white border border-indigo-100 text-indigo-600 shadow-2xs">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                Terbaru: Sinkronisasi Multi-Properti &amp; Manajemen Ruang Kerja
            </span>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-slate-900 max-w-4xl mx-auto leading-[1.1]">
                {{ $heroContent['heading'] ?? 'Otomatisasi Penagihan & Pengelolaan Bisnis Kos dalam Satu Aplikasi' }}
            </h1>
            
            <p class="text-slate-600 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed font-normal">
                {{ $heroContent['subtitle'] ?? 'Kosan mengelola seluruh operasional kos Anda: penerbitan tagihan sewa otomatis, verifikasi bukti transfer bank instan, pengelolaan kontrak hunian, serta portal digital PWA untuk penghuni.' }}
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-4">
                <x-button variant="primary" size="lg" class="w-full sm:w-auto text-center px-8 py-3.5 shadow-md shadow-indigo-500/20" onclick="window.location.href='{{ $heroContent['button_url'] ?? route('register') }}'">
                    {{ $heroContent['button_label'] ?? 'Coba Gratis 14 Hari' }}
                </x-button>
                <x-button variant="outline" size="lg" class="w-full sm:w-auto text-center px-8 py-3.5" onclick="window.location.href='{{ route('contact') }}'">
                    Jadwalkan Demo Studio
                </x-button>
            </div>
            
            <p class="text-xs text-slate-400 font-medium">Tanpa kartu kredit &bull; Pengaturan ruang kerja instan &bull; Batalkan kapan saja</p>
        </div>
    </section>

    <!-- Section 2: Logo Cloud / Social Proof (UCD: Establish Immediate Credibility) -->
    <section class="py-10 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-4">
            <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Dipercaya oleh ratusan pemilik kos &amp; pengelola hunian di Indonesia</h3>
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16 opacity-60">
                <span class="text-base sm:text-lg font-extrabold tracking-tight text-slate-800">CIHAMPELAS RESIDENCE</span>
                <span class="text-base sm:text-lg font-extrabold tracking-tight text-slate-800">DAGO ACCOMMODATION</span>
                <span class="text-base sm:text-lg font-extrabold tracking-tight text-slate-800">WAYNE PROPERTIES</span>
                <span class="text-base sm:text-lg font-extrabold tracking-tight text-slate-800">PARADISE KOS</span>
            </div>
        </div>
    </section>

    <!-- Section 3: Problem Breakdown (UCD: Pain Point Resonance) -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Masalah Utama Operasional</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mengapa Pengelolaan Kos Manual Menyita Waktu &amp; Berisiko</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Spreadsheet dan grup chat WhatsApp tidak dirancang untuk mengelola properti secara terstruktur. Berikut kendala operasional yang kami selesaikan.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <x-card :hover="true" class="space-y-4">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Penagihan Sewa Terlambat &amp; Lupa Ditagih</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Menghitung sewa, biaya listrik/air, dan menulis pesan penagihan satu per satu memakan waktu berhari-hari. Penagihan yang terlambat membuat pembayaran sewa tertunda.
                    </p>
                </x-card>
                
                <!-- Card 2 -->
                <x-card :hover="true" class="space-y-4">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Bukti Transfer Palsu &amp; Rekonsiliasi Sulit</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penghuni mengirim foto bukti transfer. Memeriksa kesesuaian transaksi dengan mutasi rekening secara manual sangat rentan kesalahan manusia dan risiko bukti transfer palsu.
                    </p>
                </x-card>
                
                <!-- Card 3 -->
                <x-card :hover="true" class="space-y-4">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Laporan Kerusakan Kamar Berantakan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Keluhan kebocoran dan kerusakan fasilitas menumpuk di chat WhatsApp. Tanpa sistem tiket perbaikan, penanganan teknisi menjadi lambat dan tidak terpantau.
                    </p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Section 4: Platform Overview (UCD: System Capability & Status Visibility) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-3 max-w-xl">
                    <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Ikhtisar Platform</h2>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Sistem Pengelolaan Kos Terpadu dalam Satu Dashboard</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Kosan menyediakan ruang kerja operasional yang aman, mengisolasi data antar properti kos, serta mengotomatisasi alur penagihan sewa secara terpusat.
                    </p>
                </div>
                <div class="flex gap-6 border-l-2 border-indigo-100 pl-6 flex-shrink-0">
                    <div>
                        <h4 class="text-3xl font-black text-indigo-600">99.2%</h4>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Tingkat pelunasan sewa</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-black text-indigo-600">80%</h4>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Hemat waktu admin</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center pt-4">
                <!-- Specs list -->
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-bold text-xs">1</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Pusat Kontrol Pemilik (Command Center)</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Pantau total pendapatan, tingkat keterisian kamar (okupansi), status penagihan sewa, dan laporan perbaikan aktif dalam satu layar.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-bold text-xs">2</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Delegasi Hak Akses Manajer &amp; Staf</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Undang manajer untuk mengaudit status kamar, serta berikan akses staf untuk menangani check-in penghuni dan verifikasi pembayaran bulanan.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center flex-shrink-0 font-bold text-xs">3</div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 tracking-tight">Portal Mandiri Penghuni (Resident PWA)</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Berikan akses login mandiri bagi penghuni untuk melihat faktur tagihan, mengunggah bukti transfer, melaporkan kerusakan fasilitas, dan mengajukan check-out.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Preview Graphic Mock -->
                <div class="p-6 bg-slate-50 border border-slate-200/80 rounded-3xl relative overflow-hidden shadow-inner min-h-[300px] flex items-center justify-center">
                    <div class="w-full max-w-sm bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xl space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <span class="text-xs font-bold text-slate-800">Kos Cihampelas Utama</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/50">92% Terisi</span>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">101</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">102</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">103</div>
                            <div class="aspect-square bg-rose-50 border border-rose-200/60 rounded-xl flex items-center justify-center text-[10px] text-rose-700 font-extrabold">104</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">201</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">202</div>
                            <div class="aspect-square bg-rose-50 border border-rose-200/60 rounded-xl flex items-center justify-center text-[10px] text-rose-700 font-extrabold">203</div>
                            <div class="aspect-square bg-emerald-50 border border-emerald-200/60 rounded-xl flex items-center justify-center text-[10px] text-emerald-700 font-extrabold">204</div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] text-slate-400 pt-2 border-t border-slate-100 font-medium">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Hijau = Terisi</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Merah = Kosong</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Fitur Unggulan (UCD: Chunking & Feature Categorization) -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Fitur Unggulan</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dirancang Khusus untuk Efisiensi Bisnis Kos &amp; Hunian</h3>
                <p class="text-sm text-slate-500">Segala kebutuhan untuk mengotomatisasi penagihan sewa, mengelola kontrak, menganalisis keuangan, dan menangani perbaikan.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Katalog Kamar &amp; Meteran Listrik</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Kelola tipe kamar, fasilitas, tingkat okupansi, dan pencatatan meteran listrik/air secara akurat.</p>
                </x-card>
                
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Pelacak Kontrak Aktif</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Simpan periode sewa, kelola uang muka deposit jaminan, dan sediakan checklist saat penghuni check-out.</p>
                </x-card>
                
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Otomatisasi Penagihan &amp; Invoicing</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Terbitkan faktur sewa bulanan secara otomatis lengkap dengan komponen item biaya tambahan (laundry, wifi, dll).</p>
                </x-card>
                
                <x-card :hover="true" class="space-y-3">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Laporan Keuangan &amp; BI Analytics</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Visualisasikan arus kas bulanan, rasio pelunasan tagihan sewa, dan simpan preset laporan keuangan.</p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Section 6: Business Value (UCD: Financial Impact & ROI Focus) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Nilai Bisnis</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Maksimalkan Arus Kas &amp; Pertahankan Okupansi Kamar</h3>
                <p class="text-sm text-slate-500">Kosan memangkas beban kerja administratif hingga 80%, meningkatkan imbal hasil investasi properti Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2.5">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Rekonsiliasi Pembayaran Instan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penghuni mengunggah bukti bayar via portal digital. Staf Anda cukup mencocokkan nomor referensi transaksi bank secara cepat di dashboard.
                    </p>
                </div>
                
                <div class="space-y-2.5">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Mencegah Kerugian Deposit Jaminan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Klaim kerusakan kamar, pemotongan tunggakan listrik, dan pengembalian sisa deposit dihitung secara otomatis saat check-out.
                    </p>
                </div>
                
                <div class="space-y-2.5">
                    <h4 class="text-lg font-bold text-slate-900 tracking-tight">Meminimalkan Durasi Kamar Kosong</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pantau tanggal berakhirnya kontrak 30 hari sebelumnya. Tandai kamar sebagai "segera tersedia" untuk menarik calon penghuni baru.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: Dashboard Preview Mock (UCD: Visual Product Proof) -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Preview Dashboard</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Desain Modern dengan Standar Perbankan</h3>
            </div>
            
            <div class="bg-white border border-slate-200/80 rounded-3xl shadow-2xl p-6 max-w-4xl mx-auto space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 font-mono">kosan.test/dashboard/analytics</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Total Pendapatan</span>
                        <p class="text-xl font-black text-slate-900">Rp 74.200.000</p>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Kontrak Aktif</span>
                        <p class="text-xl font-black text-slate-900">48 Aktif</p>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-1">
                        <span class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Tingkat Pelunasan</span>
                        <p class="text-xl font-black text-slate-900">99.2% Tepat Waktu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Resident Portal PWA Preview (UCD: Tenant Adoption Assurance) -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase tracking-widest">Pengalaman Penghuni</span>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Portal Digital Berbasis PWA untuk Penghuni Kos</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Tingkatkan kenyamanan dan kepuasan penghuni dengan Progressive Web App (PWA) modern. Penghuni dapat mengecek tagihan, mengunggah bukti transfer, dan memantau status perbaikan tanpa perlu mengunduh aplikasi rumit.
                </p>
                <ul class="space-y-2.5 text-xs text-slate-650 font-medium">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Dapat diinstal langsung di layar utama smartphone iOS &amp; Android
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Notifikasi pengingat otomatis untuk penagihan sewa dan pengumuman
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Alur komplain fasilitas langsung terhubung dengan staf teknisi
                    </li>
                </ul>
            </div>
            
            <div class="flex items-center justify-center">
                <div class="w-64 h-[420px] bg-slate-900 rounded-[36px] p-3 shadow-2xl relative border-4 border-slate-800">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-4 bg-slate-800 rounded-b-xl z-20"></div>
                    <div class="w-full h-full bg-white rounded-[28px] overflow-hidden p-4 space-y-4">
                        <div class="flex items-center justify-between pt-1">
                            <span class="text-[10px] font-bold text-slate-800">Bruce Wayne</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="p-3 bg-indigo-600 text-white rounded-xl space-y-1 shadow-xs">
                            <span class="text-[8px] uppercase tracking-wider">Kamar Aktif</span>
                            <h4 class="text-xs font-bold">Kamar 101 &bull; Kos Cihampelas</h4>
                        </div>
                        <div class="border-t border-slate-100 pt-3 space-y-2">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Faktur Tagihan Bulanan</span>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-800">Rp 2.000.000</span>
                                <span class="text-[8px] px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-200/50 font-extrabold uppercase">Belum Dibayar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Pricing Preview (UCD: Pricing Transparency) -->
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-4">
                <h2 class="text-xs font-extrabold text-indigo-600 uppercase tracking-widest">Paket Terjangkau</h2>
                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Harga Transparan Berkelanjutan Sesuai Skala Bisnis</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Baik Anda mengelola 5 kamar kos atau ratusan unit di berbagai lokasi, kami menyediakan paket yang fleksibel dan efisien.
                </p>
                <div class="pt-2">
                    <a href="{{ route('pricing') }}" class="text-indigo-600 font-bold hover:underline text-sm inline-flex items-center gap-1.5">
                        Hitung Estimasi Penghematan Operasional Anda &rarr;
                    </a>
                </div>
            </div>
            
            <x-card class="p-2 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xl font-extrabold text-slate-900">Paket Pertumbuhan</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Pilihan terbaik untuk pengelola kos profesional.</p>
                    </div>
                    <span class="text-2xl font-black text-indigo-600">Rp 15rb<span class="text-xs font-normal text-slate-400">/kamar/bln</span></span>
                </div>
                
                <ul class="text-xs text-slate-600 space-y-2.5 border-t border-slate-100 pt-4 font-medium">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Hingga 100 kamar per ruang kerja
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Penagihan sewa &amp; otomatisasi faktur
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Akses penuh portal digital penghuni (PWA)
                    </li>
                </ul>
            </x-card>
        </div>
    </section>

    <!-- Section 10: Strong Bottom CTA (UCD: Peak-End Rule Final Conversion) -->
    <section class="py-20 bg-gradient-to-tr from-indigo-900 via-indigo-950 to-slate-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(99,102,241,0.2),transparent_45%)]"></div>
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                Siap Mengotomatisasi Bisnis Kos Anda Sekarang?
            </h2>
            <p class="text-indigo-200/90 text-sm max-w-xl mx-auto leading-relaxed font-normal">
                Bergabunglah dengan ratusan pemilik kos yang telah menghemat waktu penagihan sewa, menekan kamar kosong, dan meningkatkan efisiensi operasional.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2">
                <x-button variant="primary" size="lg" class="!bg-white !text-indigo-950 hover:!bg-indigo-50 !border-white w-full sm:w-auto text-center font-bold px-8 py-3.5 shadow-lg" onclick="window.location.href='{{ route('register') }}'">
                    Coba Gratis 14 Hari
                </x-button>
                <x-button variant="outline" size="lg" class="!border-indigo-400/30 !text-white hover:!bg-white/10 w-full sm:w-auto text-center px-8 py-3.5" onclick="window.location.href='{{ route('contact') }}'">
                    Jadwalkan Demo Studio
                </x-button>
            </div>
            <p class="text-xs text-indigo-300/80 font-medium">Tanpa komitmen &bull; Batalkan atau tingkatkan paket kapan saja</p>
        </div>
    </section>

</x-marketing-layout>
