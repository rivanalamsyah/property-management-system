<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsMenu;
use App\Models\CmsGlobal;
use App\Models\CmsFaq;
use App\Models\CmsTestimonial;
use App\Models\CmsPartner;
use App\Models\CmsBanner;
use App\Models\CmsMedia;
use App\Models\CmsRedirect;
use App\Models\CmsBlogCategory;
use App\Models\CmsBlogTag;
use App\Models\CmsBlogArticle;
use App\Enums\CmsPublishStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================================
        // 1. Predefined Pages
        // ====================================================================
        $pages = [
            ['name' => 'Beranda',         'slug' => 'home',      'seo_title' => 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart',          'seo_description' => 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).'],
            ['name' => 'Fitur',           'slug' => 'features',  'seo_title' => 'Fitur Lengkap Aplikasi Pengelolaan Kos - Kosan',                  'seo_description' => 'Jelajahi 10 modul unggulan Kosan: otomatisasi tagihan sewa, pencatatan meteran listrik, pengelolaan kontrak hunian, hingga laporan keuangan real-time.'],
            ['name' => 'Harga',           'slug' => 'pricing',   'seo_title' => 'Paket & Harga Aplikasi Kos - Transparan & Terjangkau | Kosan',    'seo_description' => 'Mulai gratis hingga 5 kamar. Pilih paket pertumbuhan sesuai skala properti Anda. Tanpa biaya tersembunyi, batalkan kapan saja.'],
            ['name' => 'Panduan & Blog',  'slug' => 'resources', 'seo_title' => 'Pusat Panduan, Artikel & Insight Pengelolaan Kos - Kosan',         'seo_description' => 'Temukan panduan praktis, studi kasus, dan tips meningkatkan tingkat okupansi serta efisiensi penagihan kos dari pakar manajemen hunian.'],
            ['name' => 'Tentang Kami',    'slug' => 'about',     'seo_title' => 'Tentang Kami - Sistem Operasi Bisnis Kos Modern | Kosan',          'seo_description' => 'Pelajari misi, arsitektur teknologi, dan standar keamanan data Kosan dalam mentransformasi operasional bisnis hunian di Indonesia.'],
            ['name' => 'Kontak',          'slug' => 'contact',   'seo_title' => 'Hubungi Kami & Jadwalkan Demo Platform - Kosan',                   'seo_description' => 'Konsultasikan kebutuhan operasional kos Anda dengan tim spesialis kami atau jadwalkan demo langsung untuk melihat cara kerja sistem.'],
            ['name' => 'Kebijakan Privasi','slug' => 'privacy',  'seo_title' => 'Kebijakan Privasi & Perlindungan Data - Kosan',                   'seo_description' => 'Baca kebijakan privasi lengkap Kosan terkait pengumpulan, penggunaan, dan perlindungan data pengguna dan penghuni kos.'],
            ['name' => 'Syarat & Ketentuan','slug' => 'terms',   'seo_title' => 'Syarat & Ketentuan Penggunaan Platform Kosan',                    'seo_description' => 'Pahami syarat dan ketentuan layanan platform manajemen kos Kosan sebelum menggunakan layanan kami.'],
        ];

        $createdPages = [];
        foreach ($pages as $p) {
            $createdPages[$p['slug']] = CmsPage::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'name'            => $p['name'],
                    'status'          => CmsPublishStatus::PUBLISHED,
                    'seo_title'       => $p['seo_title'],
                    'seo_description' => $p['seo_description'],
                    'published_at'    => now(),
                ]
            );
        }

        // ====================================================================
        // 2. CMS Sections for Home Page
        // ====================================================================
        $homeSections = [
            [
                'type'          => 'hero',
                'name'          => 'Hero Banner Utama',
                'content'       => [
                    'heading'      => 'Otomatisasi Penagihan & Pengelolaan Bisnis Kos dalam Satu Platform',
                    'subtitle'     => 'Kelola alokasi kamar, otomatisasi penagihan sewa bulanan, verifikasi bukti transfer secara otomatis, dan sediakan portal digital penghuni (PWA).',
                    'body'         => 'Tinggalkan rekapan spreadsheet yang membosankan. Kosan memberikan transparansi penuh dan efisiensi operasional bagi pemilik kos modern Indonesia.',
                    'button_label' => 'Coba Gratis 14 Hari',
                    'button_url'   => '/register',
                    'secondary_label' => 'Lihat Demo',
                    'secondary_url'   => '/demo',
                ],
                'display_order' => 1,
            ],
            [
                'type'          => 'stats',
                'name'          => 'Platform Statistics',
                'content'       => [
                    'heading'  => 'Dipercaya Ratusan Pemilik Kos di Seluruh Indonesia',
                    'subtitle' => 'Angka nyata yang membuktikan efisiensi operasional bisnis kos-kosan.',
                    'features' => [
                        ['title' => '99.2%', 'description' => 'Tingkat pelunasan tagihan sewa tepat waktu'],
                        ['title' => '3.4 Jam', 'description' => 'Rata-rata waktu penyelesaian keluhan perbaikan'],
                        ['title' => '10.000+', 'description' => 'Kamar dan unit hunian aktif terkelola nasional'],
                        ['title' => '850+', 'description' => 'Properti kos dan boarding house terdaftar aktif'],
                    ],
                ],
                'display_order' => 2,
            ],
            [
                'type'          => 'feature_grid',
                'name'          => 'Fitur Unggulan Grid',
                'content'       => [
                    'heading'  => 'Semua yang Anda Butuhkan untuk Mengelola Kos Profesional',
                    'subtitle' => 'Dari penagihan otomatis hingga laporan keuangan real-time, semua tersedia dalam satu platform.',
                    'features' => [
                        ['icon' => 'receipt', 'title' => 'Penagihan Otomatis',        'description' => 'Invoice sewa diterbitkan otomatis setiap bulan. Penghuni terima notifikasi langsung.'],
                        ['icon' => 'shield',  'title' => 'Verifikasi Pembayaran',    'description' => 'Rekonsiliasi bukti transfer bank secara otomatis, mengurangi kesalahan manual.'],
                        ['icon' => 'users',   'title' => 'Portal Penghuni (PWA)',    'description' => 'Penghuni akses tagihan, unggah bukti bayar, dan ajukan komplain secara mandiri.'],
                        ['icon' => 'bar-chart','title' => 'Laporan & Analitik',      'description' => 'Pantau arus kas, tingkat hunian, dan pendapatan dalam satu dashboard interaktif.'],
                        ['icon' => 'tool',    'title' => 'Manajemen Pemeliharaan',   'description' => 'Lacak status perbaikan kamar dari laporan hingga penyelesaian dengan timeline.'],
                        ['icon' => 'file',    'title' => 'Kontrak Digital',          'description' => 'Buat, kelola, dan arsipkan kontrak sewa secara digital. Tidak perlu cetak fisik.'],
                    ],
                ],
                'display_order' => 3,
            ],
            [
                'type'          => 'cta',
                'name'          => 'Homepage CTA',
                'content'       => [
                    'heading'      => 'Siap Mengotomatisasi Operasional Bisnis Kos Anda?',
                    'subtitle'     => 'Buat ruang kerja gratis, daftarkan properti kos Anda, dan undang staf operasional hanya dalam waktu 5 menit.',
                    'button_label' => 'Mulai Ruang Kerja Gratis',
                    'button_url'   => '/register',
                    'note'         => 'Gratis 14 hari. Tidak perlu kartu kredit.',
                ],
                'display_order' => 4,
            ],
        ];

        foreach ($homeSections as $sec) {
            CmsSection::updateOrCreate(
                ['cms_page_id' => $createdPages['home']->id, 'type' => $sec['type']],
                ['name' => $sec['name'], 'content' => $sec['content'], 'display_order' => $sec['display_order'], 'is_visible' => true]
            );
        }

        // ====================================================================
        // 3. CMS Global Key-Value Settings
        // ====================================================================
        $globals = [
            'company_profile'  => 'Kosan adalah platform SaaS manajemen properti dan kos-kosan berbasis multi-tenant yang dirancang untuk mengotomatisasi penagihan sewa, verifikasi pembayaran, dan layanan penghuni.',
            'address'          => 'Gedung Cyber, Lantai 5, Jl. Kuningan Barat No. 8, Jakarta Selatan, DKI Jakarta 12710',
            'email'            => 'support@kosan.test',
            'phone'            => '021-50998877',
            'whatsapp'         => '081299998888',
            'business_hours'   => 'Senin - Jumat, 09:00 - 18:00 WIB',
            'facebook'         => 'https://facebook.com/kosanid',
            'instagram'        => 'https://instagram.com/kosan.id',
            'linkedin'         => 'https://linkedin.com/company/kosan-id',
            'youtube'          => 'https://youtube.com/@kosan-id',
            'twitter'          => 'https://twitter.com/kosan_id',
            'footer_info'      => 'Kosan - Solusi otomatisasi pengelolaan kos dan hunian modern di Indonesia.',
            'copyright'        => '© 2026 Kosan. Hak Cipta Dilindungi Undang-Undang.',
            'app_version'      => '2.5.0',
            'tagline'          => 'Platform Manajemen Kos Terdepan di Indonesia',
        ];

        foreach ($globals as $k => $v) {
            CmsGlobal::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        // ====================================================================
        // 4. FAQs (10+ pertanyaan realistis)
        // ====================================================================
        $faqs = [
            ['Umum',        1,  'Apa itu platform Kosan?',                              'Kosan adalah aplikasi manajemen kos modern berbasis SaaS multi-tenant yang membantu pemilik dan pengelola kos mengotomatisasi penagihan sewa, verifikasi pembayaran, pengelolaan kontrak, dan penanganan keluhan penghuni.'],
            ['Umum',        2,  'Apakah Kosan cocok untuk kos kecil dengan 5 kamar?',   'Ya. Kosan memiliki paket Starter yang dirancang khusus untuk kos kecil dengan hingga 5 kamar. Mulai gratis dan upgrade seiring pertumbuhan bisnis Anda.'],
            ['Umum',        3,  'Apakah saya perlu keahlian IT untuk menggunakan Kosan?','Tidak perlu. Kosan dirancang dengan antarmuka yang intuitif dan mudah digunakan. Tim dukungan kami siap membantu onboarding Anda.'],
            ['Penagihan',   4,  'Bagaimana sistem penagihan otomatis bekerja?',          'Sistem Kosan secara otomatis memeriksa kontrak aktif dan menerbitkan faktur tagihan bulanan. Penghuni menerima notifikasi dan dapat mengunggah bukti transfer langsung dari portal PWA mereka.'],
            ['Penagihan',   5,  'Dapatkah saya mengatur denda keterlambatan bayar?',    'Ya. Anda dapat mengatur denda keterlambatan secara fleksibel: denda flat (misal Rp50.000) atau persentase dari nilai sewa (misal 2%). Denda dihitung otomatis jika pembayaran melewati tanggal jatuh tempo.'],
            ['Penagihan',   6,  'Apakah Kosan mendukung pembayaran QRIS dan e-wallet?', 'Kosan saat ini mendukung pencatatan pembayaran melalui transfer bank, QRIS, virtual account, e-wallet, dan tunai. Integrasi payment gateway real-time sedang dalam pengembangan.'],
            ['Penghuni',    7,  'Bagaimana cara penghuni mengakses portal mereka?',      'Penghuni mendapat undangan email untuk mengakses portal PWA Kosan. Portal tersedia di browser HP maupun desktop untuk melihat tagihan, riwayat pembayaran, dan mengajukan komplain.'],
            ['Penghuni',    8,  'Berapa banyak penghuni yang bisa saya kelola?',         'Bergantung paket yang dipilih: Starter (5 penghuni), Professional (20), Business (100), Enterprise (tidak terbatas).'],
            ['Teknis',      9,  'Di mana data saya disimpan?',                           'Data Anda disimpan di server cloud Indonesia dengan enkripsi AES-256. Kami melakukan backup harian otomatis dan menjamin uptime 99.9%.'],
            ['Teknis',      10, 'Apakah Kosan memiliki aplikasi mobile?',                'Kosan tersedia sebagai Progressive Web App (PWA) yang dapat diinstal di smartphone Android dan iOS tanpa perlu unduh dari app store. Aplikasi native sedang dikembangkan.'],
            ['Harga',       11, 'Apakah ada biaya tersembunyi?',                         'Tidak ada biaya tersembunyi. Harga yang tertera di halaman Harga adalah harga final. Upgrade dan downgrade paket dapat dilakukan kapan saja.'],
            ['Harga',       12, 'Bagaimana cara membatalkan langganan?',                 'Anda dapat membatalkan langganan kapan saja dari menu Pengaturan > Langganan. Data Anda tetap tersimpan selama 30 hari setelah pembatalan sebelum dihapus permanen.'],
            ['Keamanan',    13, 'Seberapa aman data penghuni saya di Kosan?',            'Kami menerapkan enkripsi end-to-end, SSL/TLS, dan isolasi data multi-tenant yang ketat. Data setiap workspace sepenuhnya terisolasi dari workspace lain.'],
        ];

        foreach ($faqs as [$cat, $order, $q, $a]) {
            CmsFaq::updateOrCreate(
                ['question' => $q],
                ['category' => $cat, 'answer' => $a, 'display_order' => $order, 'is_visible' => true]
            );
        }

        // ====================================================================
        // 5. Testimonials (5+)
        // ====================================================================
        $testimonials = [
            [
                'customer_name' => 'Rivan Alamsyah',
                'avatar'        => null,
                'company'       => 'Griya Cihampelas Indah',
                'position'      => 'Pemilik Kos - Bandung',
                'rating'        => 5,
                'review'        => 'Kosan sangat membantu mengotomatisasi penagihan sewa bulanan. Rekonsiliasi yang biasanya memakan waktu berhari-hari kini selesai dalam hitungan menit. Produktivitas saya meningkat drastis.',
                'display_order' => 1,
            ],
            [
                'customer_name' => 'Dewi Kusuma',
                'avatar'        => null,
                'company'       => 'Kost Permata Indah',
                'position'      => 'Pemilik Kos - Jakarta',
                'rating'        => 5,
                'review'        => 'Portal PWA untuk penghuni adalah fitur terbaik. Penghuni sekarang bisa cek tagihan dan upload bukti bayar sendiri tanpa harus WhatsApp ke saya setiap bulan. Sangat menghemat waktu!',
                'display_order' => 2,
            ],
            [
                'customer_name' => 'Gunawan Wibisono',
                'avatar'        => null,
                'company'       => 'Kost Asri Dago',
                'position'      => 'Pemilik Kos - Bandung',
                'rating'        => 4,
                'review'        => 'Laporan keuangan real-time Kosan membantu saya memantau arus kas dari mana saja. Dashboard yang bersih dan informatif. Saya bisa ambil keputusan bisnis lebih cepat.',
                'display_order' => 3,
            ],
            [
                'customer_name' => 'Bambang Suharso',
                'avatar'        => null,
                'company'       => 'Rusunawa Sejahtera',
                'position'      => 'Manajer Properti - Surabaya',
                'rating'        => 5,
                'review'        => 'Kami mengelola 120 unit kamar dengan tim kecil berkat Kosan. Modul pemeliharaan membantu teknisi kami menyelesaikan pekerjaan lebih terstruktur dan tepat waktu.',
                'display_order' => 4,
            ],
            [
                'customer_name' => 'Kartini Rahayu',
                'avatar'        => null,
                'company'       => 'Kost Kartini Kemayoran',
                'position'      => 'Pemilik Kos - Jakarta Pusat',
                'rating'        => 5,
                'review'        => 'Sebagai pemilik kos wanita khusus, fitur manajemen kontrak digital Kosan sangat membantu. Semua dokumen tersimpan rapi dan bisa diakses kapan saja.',
                'display_order' => 5,
            ],
            [
                'customer_name' => 'Hendra Prabowo',
                'avatar'        => null,
                'company'       => 'Graha Kost Yogyakarta',
                'position'      => 'Pengelola Properti - Yogyakarta',
                'rating'        => 4,
                'review'        => 'Sistem notifikasi otomatis H-3 sebelum jatuh tempo tagihan berhasil menurunkan tingkat keterlambatan bayar dari 25% menjadi hanya 3% dalam 2 bulan pertama.',
                'display_order' => 6,
            ],
        ];

        foreach ($testimonials as $t) {
            CmsTestimonial::updateOrCreate(
                ['customer_name' => $t['customer_name']],
                array_merge($t, ['is_visible' => true])
            );
        }

        // ====================================================================
        // 6. Partners / Logos
        // ====================================================================
        $partners = [
            ['name' => 'Bank Mandiri',    'logo_url' => '/assets/images/partners/mandiri.svg',    'link_url' => 'https://bankmandiri.co.id',   'display_order' => 1, 'is_visible' => true],
            ['name' => 'Bank BCA',        'logo_url' => '/assets/images/partners/bca.svg',         'link_url' => 'https://bca.co.id',           'display_order' => 2, 'is_visible' => true],
            ['name' => 'Bank BNI',        'logo_url' => '/assets/images/partners/bni.svg',         'link_url' => 'https://bni.co.id',           'display_order' => 3, 'is_visible' => true],
            ['name' => 'GoPay',           'logo_url' => '/assets/images/partners/gopay.svg',       'link_url' => 'https://gopay.co.id',         'display_order' => 4, 'is_visible' => true],
            ['name' => 'OVO',             'logo_url' => '/assets/images/partners/ovo.svg',         'link_url' => 'https://ovo.id',              'display_order' => 5, 'is_visible' => true],
            ['name' => 'DANA',            'logo_url' => '/assets/images/partners/dana.svg',        'link_url' => 'https://dana.id',             'display_order' => 6, 'is_visible' => true],
        ];

        foreach ($partners as $p) {
            CmsPartner::updateOrCreate(
                ['name' => $p['name']],
                $p
            );
        }

        // ====================================================================
        // 7. Banners
        // ====================================================================
        $banners = [
            [
                'name'         => 'Banner Promo Early Bird Q3 2026',
                'type'         => 'promotion_banner',
                'content'      => '🎉 Promo Spesial: Diskon 30% untuk langganan tahunan Business Plan. Berlaku hingga 31 Agustus 2026!',
                'action_label' => 'Klaim Promo Sekarang',
                'action_url'   => '/pricing?promo=q3_2026',
                'status'       => 'published',
                'starts_at'    => now()->subDays(5),
                'ends_at'      => now()->addDays(25),
            ],
            [
                'name'         => 'Banner Pengumuman Fitur Baru',
                'type'         => 'announcement_banner',
                'content'      => '✨ Fitur Baru: Ekspor laporan keuangan ke Excel & PDF sekarang tersedia di semua paket!',
                'action_label' => 'Coba Sekarang',
                'action_url'   => '/features#reports',
                'status'       => 'published',
                'starts_at'    => now()->subDays(3),
                'ends_at'      => null,
            ],
            [
                'name'         => 'Banner CTA Homepage',
                'type'         => 'cta_banner',
                'content'      => 'Bergabunglah dengan 850+ pemilik kos yang sudah menggunakan Kosan untuk bisnis properti mereka.',
                'action_label' => 'Daftar Gratis',
                'action_url'   => '/register',
                'status'       => 'published',
                'starts_at'    => now()->subDays(30),
                'ends_at'      => null,
            ],
            [
                'name'         => 'Banner Draft - Harbolnas 12.12',
                'type'         => 'promotion_banner',
                'content'      => '🔥 Spesial Harbolnas 12.12: Hemat hingga 50% untuk upgrade ke Enterprise Plan!',
                'action_label' => 'Lihat Penawaran',
                'action_url'   => '/pricing',
                'status'       => 'draft',
                'starts_at'    => now()->addMonths(4),
                'ends_at'      => now()->addMonths(5),
            ],
        ];

        foreach ($banners as $b) {
            CmsBanner::updateOrCreate(
                ['name' => $b['name']],
                $b
            );
        }

        // ====================================================================
        // 8. URL Redirects
        // ====================================================================
        $redirects = [
            ['source_path' => '/home',        'target_path' => '/',            'status_code' => 301, 'is_active' => true],
            ['source_path' => '/blog',        'target_path' => '/resources',   'status_code' => 301, 'is_active' => true],
            ['source_path' => '/harga',       'target_path' => '/pricing',     'status_code' => 301, 'is_active' => true],
            ['source_path' => '/fitur',       'target_path' => '/features',    'status_code' => 301, 'is_active' => true],
            ['source_path' => '/tentang',     'target_path' => '/about',       'status_code' => 301, 'is_active' => true],
            ['source_path' => '/kontak',      'target_path' => '/contact',     'status_code' => 301, 'is_active' => true],
            ['source_path' => '/app',         'target_path' => '/login',       'status_code' => 302, 'is_active' => true],
            ['source_path' => '/lp-kost-2026','target_path' => '/pricing',     'status_code' => 301, 'is_active' => false],
        ];

        foreach ($redirects as $r) {
            CmsRedirect::updateOrCreate(
                ['source_path' => $r['source_path']],
                $r
            );
        }

        // ====================================================================
        // 9. Navigation Menus
        // ====================================================================
        CmsMenu::updateOrCreate(
            ['slug' => 'header_menu'],
            [
                'name'  => 'Header Menu',
                'items' => [
                    ['label' => 'Fitur',        'url' => '/features',  'target' => '_self', 'children' => []],
                    ['label' => 'Harga',        'url' => '/pricing',   'target' => '_self', 'children' => []],
                    ['label' => 'Panduan & Blog','url' => '/resources', 'target' => '_self', 'children' => []],
                    ['label' => 'Tentang Kami', 'url' => '/about',     'target' => '_self', 'children' => []],
                    ['label' => 'Kontak',       'url' => '/contact',   'target' => '_self', 'children' => []],
                ],
            ]
        );

        CmsMenu::updateOrCreate(
            ['slug' => 'footer_menu'],
            [
                'name'  => 'Footer Menu',
                'items' => [
                    ['label' => 'Produk',          'url' => '#', 'target' => '_self', 'children' => [
                        ['label' => 'Fitur',           'url' => '/features', 'target' => '_self'],
                        ['label' => 'Paket & Harga',   'url' => '/pricing',  'target' => '_self'],
                        ['label' => 'Demo Gratis',     'url' => '/demo',     'target' => '_self'],
                    ]],
                    ['label' => 'Sumber Daya',     'url' => '#', 'target' => '_self', 'children' => [
                        ['label' => 'Blog & Panduan',  'url' => '/resources', 'target' => '_self'],
                        ['label' => 'Studi Kasus',     'url' => '/resources?cat=studi-kasus', 'target' => '_self'],
                        ['label' => 'FAQ',             'url' => '/#faq',     'target' => '_self'],
                    ]],
                    ['label' => 'Perusahaan',      'url' => '#', 'target' => '_self', 'children' => [
                        ['label' => 'Tentang Kami',    'url' => '/about',   'target' => '_self'],
                        ['label' => 'Kontak',          'url' => '/contact', 'target' => '_self'],
                        ['label' => 'Karir',           'url' => '/careers', 'target' => '_self'],
                    ]],
                    ['label' => 'Legal',           'url' => '#', 'target' => '_self', 'children' => [
                        ['label' => 'Kebijakan Privasi', 'url' => '/privacy', 'target' => '_self'],
                        ['label' => 'Syarat & Ketentuan','url' => '/terms',   'target' => '_self'],
                    ]],
                ],
            ]
        );

        CmsMenu::updateOrCreate(
            ['slug' => 'social_links'],
            [
                'name'  => 'Social Media Links',
                'items' => [
                    ['label' => 'Instagram', 'url' => 'https://instagram.com/kosan.id', 'target' => '_blank'],
                    ['label' => 'LinkedIn',  'url' => 'https://linkedin.com/company/kosan-id', 'target' => '_blank'],
                    ['label' => 'Twitter',   'url' => 'https://twitter.com/kosan_id', 'target' => '_blank'],
                    ['label' => 'YouTube',   'url' => 'https://youtube.com/@kosan-id', 'target' => '_blank'],
                ],
            ]
        );

        // ====================================================================
        // 10. Blog Categories
        // ====================================================================
        $categories = [
            ['name' => 'Operasional Properti', 'slug' => 'operasional-properti'],
            ['name' => 'Keuangan & Penagihan',  'slug' => 'keuangan-penagihan'],
            ['name' => 'Hubungan Penghuni',     'slug' => 'hubungan-penghuni'],
            ['name' => 'Studi Kasus',           'slug' => 'studi-kasus'],
            ['name' => 'Tips & Trik',           'slug' => 'tips-trik'],
            ['name' => 'Regulasi & Hukum',      'slug' => 'regulasi-hukum'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = CmsBlogCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }

        // ====================================================================
        // 11. Blog Tags
        // ====================================================================
        $tags = ['guide', 'tips', 'finance', 'rules', 'automation', 'case-study', 'legal', 'tenant-management', 'maintenance', 'software'];
        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[$tagName] = CmsBlogTag::updateOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => ucwords(str_replace('-', ' ', $tagName))]
            );
        }

        // ====================================================================
        // 12. Blog Articles
        // ====================================================================
        $articles = [
            [
                'title'           => 'Cara Memaksimalkan Okupansi & Pendapatan Kos-Kosan di Tahun 2026',
                'slug'            => 'cara-memaksimalkan-okupansi-pendapatan-kos-kosan-2026',
                'excerpt'         => 'Panduan komprehensif tentang cara menata alokasi kamar, menyusun fasilitas unggulan, dan menarik calon penghuni baru untuk menekan durasi kamar kosong.',
                'content'         => "# Cara Memaksimalkan Okupansi & Pendapatan Kos-Kosan di Tahun 2026\n\nMengelola bisnis kos-kosan di era modern memerlukan strategi yang lebih dinamis.\n\n## 1. Tata Alokasi Kamar & Fasilitas Unggulan\nPahami segmentasi pasar Anda. Mahasiswa membutuhkan meja belajar dan Wi-Fi stabil, sedangkan profesional mencari privasi dan AC.\n\n## 2. Optimalkan Visibilitas Digital\nDaftarkan properti kos di platform pencarian digital. Foto berkualitas meningkatkan minat calon penghuni hingga 75%.\n\n## 3. Otomatisasi Sistem Operasional\nGunakan sistem seperti Kosan untuk mengotomatisasi penagihan bulanan. Invoice diterbitkan otomatis dan pembayaran divalidasi langsung.\n\n## 4. Pemeliharaan Preventif\nJangan tunggu kerusakan dilaporkan. Buat jadwal pemeriksaan berkala setiap 3 bulan.",
                'featured_image'  => '/assets/images/blog/featured_2026.png',
                'author_name'     => 'Rivan Alamsyah',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now()->subDays(5),
                'seo_title'       => 'Cara Memaksimalkan Okupansi Kos di 2026 | Kosan',
                'seo_description' => 'Strategi taktis meningkatkan tingkat keterisian kamar kos dan optimalisasi bisnis sewa hunian.',
                'categories'      => ['operasional-properti'],
                'tags'            => ['guide', 'tips'],
            ],
            [
                'title'           => 'Panduan Rekonsiliasi Otomatis Transfer Bank BCA/Mandiri untuk Pemilik Kos',
                'slug'            => 'panduan-rekonsiliasi-otomatis-transfer-bank-bca-mandiri',
                'excerpt'         => 'Cara mencocokkan mutasi rekening bank dengan daftar tagihan bulanan tanpa kesalahan verifikasi manual.',
                'content'         => "# Panduan Rekonsiliasi Otomatis Transfer Bank\n\nVerifikasi pembayaran manual adalah salah satu tantangan terbesar pemilik kos dengan banyak kamar.\n\n## Tantangan Verifikasi Manual\n- Bukti transfer palsu mudah dibuat\n- Nama pengirim sering berbeda\n- Memakan waktu berjam-jam\n\n## Solusi Rekonsiliasi Otomatis Kosan\nSistem Kosan membaca data mutasi secara aman dan melakukan pencocokan instan berdasarkan nominal unik atau kode referensi.\n\n### Langkah Kerja Sistem:\n- Penerbitan faktur dengan nominal unik\n- Pembayaran penghuni sesuai angka tersebut\n- Deteksi mutasi bank secara instan\n- Notifikasi kuitansi otomatis ke penghuni",
                'featured_image'  => '/assets/images/blog/bank_reconciliation.png',
                'author_name'     => 'Budi Hartono',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now()->subDays(3),
                'seo_title'       => 'Rekonsiliasi Pembayaran Bank BCA Mandiri Otomatis | Kosan',
                'seo_description' => 'Cara mengintegrasikan mutasi rekening bank BCA/Mandiri dengan sistem penagihan otomatis untuk kos.',
                'categories'      => ['keuangan-penagihan'],
                'tags'            => ['finance', 'automation'],
            ],
            [
                'title'           => 'Menyusun Aturan & Tata Tertib Kos yang Efektif dan Legal',
                'slug'            => 'menyusun-aturan-tata-tertib-kos-efektif',
                'excerpt'         => 'Cara merumuskan tata tertib kos mengenai jam berkunjung, batas jam malam, dan ketenangan untuk mencegah konflik antar penghuni.',
                'content'         => "# Menyusun Aturan & Tata Tertib Kos yang Efektif\n\nTata tertib kos bukan untuk mengekang, melainkan untuk menciptakan harmoni dan keamanan bersama.\n\n## Poin Penting dalam Penyusunan Tata Tertib\n\n### 1. Ketentuan Jam Berkunjung & Tamu Menginap\nBatasi jam bertamu umum hingga pukul 22.00 WIB.\n\n### 2. Penggunaan Area Bersama\nTegaskan aturan menjaga kebersihan dapur dan area jemuran.\n\n### 3. Batas Kebisingan\nTentukan quiet hours (22.00 - 06.00 WIB).\n\n## Sosialisasi Aturan Secara Digital\nDengan Kosan, tata tertib terintegrasi dalam kontrak sewa digital dan diakses penghuni melalui portal PWA.",
                'featured_image'  => '/assets/images/blog/rules_guide.png',
                'author_name'     => 'Andi Wijaya',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now()->subDays(2),
                'seo_title'       => 'Panduan Tata Tertib Kos Efektif & Legal | Kosan',
                'seo_description' => 'Panduan menyusun aturan kost untuk tamu, jam malam, serta ketenangan lingkungan kos-kosan.',
                'categories'      => ['hubungan-penghuni', 'regulasi-hukum'],
                'tags'            => ['rules', 'guide', 'legal'],
            ],
            [
                'title'           => 'Bagaimana Kos Cihampelas Mencapai Pelunasan Sewa 99.2% dalam 3 Bulan',
                'slug'            => 'bagaimana-kos-cihampelas-utama-mencapai-pelunasan-sewa-99-2-persen',
                'excerpt'         => 'Strategi pengelolaan 48 unit kamar kos di Bandung yang sukses memangkas penagihan sewa manual hingga 80% dengan otomatisasi faktur Kosan.',
                'content'         => "# Studi Kasus: Kos Cihampelas Mencapai Pelunasan 99.2%\n\nKos Cihampelas Utama adalah properti 48 unit di Bandung yang sebelumnya kewalahan melacak pembayaran sewa.\n\n## Masalah Sebelum Otomatisasi:\n- 15-20% penghuni terlambat bayar tiap bulan\n- Staff mengirim pengingat WhatsApp satu per satu\n- Laporan keuangan tidak akurat\n\n## Strategi Solusi:\n1. Pengingat H-3 otomatis via notifikasi dan WhatsApp\n2. Denda keterlambatan dihitung otomatis\n3. Portal PWA mandiri untuk penghuni\n\n## Hasil Setelah 3 Bulan:\n- Pelunasan tepat waktu meningkat ke 99.2%\n- Hemat 12 jam kerja administratif per bulan",
                'featured_image'  => '/assets/images/blog/case_study_cihampelas.png',
                'author_name'     => 'Rivan Alamsyah',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now()->subDays(1),
                'seo_title'       => 'Studi Kasus: Pelunasan Sewa 99% Kos Cihampelas | Kosan',
                'seo_description' => 'Bagaimana 48 unit kamar kos di Bandung sukses mendisiplinkan pembayaran sewa menggunakan Kosan.',
                'categories'      => ['studi-kasus'],
                'tags'            => ['case-study', 'automation'],
            ],
            [
                'title'           => '5 Kesalahan Fatal dalam Mengelola Kontrak Sewa Kos yang Harus Dihindari',
                'slug'            => '5-kesalahan-fatal-mengelola-kontrak-sewa-kos',
                'excerpt'         => 'Dari kontrak verbal yang tidak mengikat hingga tidak ada klausul denda, berikut 5 kesalahan umum pemilik kos dalam menyusun kontrak sewa.',
                'content'         => "# 5 Kesalahan Fatal Mengelola Kontrak Sewa Kos\n\nKontrak sewa adalah tulang punggung hubungan hukum antara pemilik kos dan penghuni.\n\n## 1. Kontrak Verbal Tanpa Dokumen Tertulis\nKontrak verbal sangat lemah secara hukum. Selalu gunakan kontrak tertulis bertandatangan.\n\n## 2. Tidak Ada Klausul Denda Keterlambatan\nTanpa klausul denda, Anda tidak bisa menagih denda secara hukum.\n\n## 3. Tidak Mendokumentasikan Kondisi Kamar\nBuat berita acara serah terima kamar dengan foto sebagai bukti.\n\n## 4. Tanggal Berakhir Kontrak Tidak Jelas\nPastikan tanggal mulai dan berakhir kontrak tertera eksplisit.\n\n## 5. Tidak Menyimpan Salinan Kontrak\nSimpan salinan digital dan fisik kontrak. Kosan mengarsipkan kontrak digital secara otomatis.",
                'featured_image'  => '/assets/images/blog/contract_mistakes.png',
                'author_name'     => 'Budi Hartono',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now(),
                'seo_title'       => '5 Kesalahan Fatal Kontrak Sewa Kos yang Harus Dihindari | Kosan',
                'seo_description' => 'Hindari 5 kesalahan umum dalam mengelola kontrak sewa kos yang bisa merugikan Anda secara hukum.',
                'categories'      => ['regulasi-hukum', 'operasional-properti'],
                'tags'            => ['legal', 'guide', 'rules'],
            ],
            [
                'title'           => 'Cara Efektif Menangani Keluhan Penghuni Kos Tanpa Konflik',
                'slug'            => 'cara-efektif-menangani-keluhan-penghuni-kos',
                'excerpt'         => 'Panduan praktis untuk mengelola keluhan penghuni secara profesional menggunakan sistem tiket digital.',
                'content'         => "# Cara Efektif Menangani Keluhan Penghuni Kos\n\nKeluhan penghuni adalah hal wajar dalam bisnis kos. Cara Anda menanganinya menentukan retensi penghuni.\n\n## Langkah 1: Respons Cepat (< 24 Jam)\nPenghuni ingin tahu keluhan mereka didengar. Segera konfirmasi penerimaan laporan.\n\n## Langkah 2: Klasifikasikan Prioritas\n- Emergency (listrik mati, kebocoran parah): Respons dalam 2 jam\n- High (AC rusak, air tidak ada): Respons dalam 24 jam\n- Normal (lampu mati, wifi lemot): Respons dalam 3 hari\n\n## Langkah 3: Komunikasikan Progress\nUpdate penghuni tentang status perbaikan melalui portal PWA.\n\n## Langkah 4: Verifikasi Penyelesaian\nMinta konfirmasi penghuni setelah perbaikan selesai sebelum menutup tiket.",
                'featured_image'  => '/assets/images/blog/complaint_management.png',
                'author_name'     => 'Sari Dewi',
                'status'          => CmsPublishStatus::PUBLISHED,
                'published_at'    => now()->subHours(12),
                'seo_title'       => 'Cara Menangani Keluhan Penghuni Kos Profesional | Kosan',
                'seo_description' => 'Panduan mengelola keluhan penghuni kos secara efektif menggunakan sistem tiket digital.',
                'categories'      => ['hubungan-penghuni', 'tips-trik'],
                'tags'            => ['tips', 'tenant-management', 'guide'],
            ],
        ];

        foreach ($articles as $art) {
            $createdArt = CmsBlogArticle::updateOrCreate(
                ['slug' => $art['slug']],
                [
                    'title'           => $art['title'],
                    'excerpt'         => $art['excerpt'],
                    'content'         => $art['content'],
                    'featured_image'  => $art['featured_image'],
                    'author_name'     => $art['author_name'],
                    'status'          => $art['status'],
                    'published_at'    => $art['published_at'],
                    'seo_title'       => $art['seo_title'],
                    'seo_description' => $art['seo_description'],
                ]
            );

            // Sync categories
            $catIds = [];
            foreach ($art['categories'] as $catSlug) {
                if (isset($categoryModels[$catSlug])) {
                    $catIds[] = $categoryModels[$catSlug]->id;
                }
            }
            $createdArt->categories()->sync($catIds);

            // Sync tags
            $tagIds = [];
            foreach ($art['tags'] as $tagName) {
                if (isset($tagModels[$tagName])) {
                    $tagIds[] = $tagModels[$tagName]->id;
                }
            }
            $createdArt->tags()->sync($tagIds);
        }

        // ====================================================================
        // 13. CMS Media Library (Placeholder entries)
        // ====================================================================
        $mediaFiles = [
            ['filename' => 'hero_banner.png',          'filepath' => 'cms/hero_banner.png',          'file_url' => '/assets/images/cms/hero_banner.png',          'mime_type' => 'image/png',  'file_size' => 245800, 'folder' => '/images', 'alt_text' => 'Kosan hero banner'],
            ['filename' => 'featured_2026.png',        'filepath' => 'cms/featured_2026.png',        'file_url' => '/assets/images/blog/featured_2026.png',        'mime_type' => 'image/png',  'file_size' => 189200, 'folder' => '/blog',   'alt_text' => 'Blog post featured image 2026'],
            ['filename' => 'bank_reconciliation.png',  'filepath' => 'cms/bank_reconciliation.png',  'file_url' => '/assets/images/blog/bank_reconciliation.png',  'mime_type' => 'image/png',  'file_size' => 210000, 'folder' => '/blog',   'alt_text' => 'Bank reconciliation illustration'],
            ['filename' => 'rules_guide.png',          'filepath' => 'cms/rules_guide.png',          'file_url' => '/assets/images/blog/rules_guide.png',          'mime_type' => 'image/png',  'file_size' => 175000, 'folder' => '/blog',   'alt_text' => 'Rules guide illustration'],
            ['filename' => 'logo_kosan.svg',           'filepath' => 'cms/logo_kosan.svg',           'file_url' => '/assets/images/logo.svg',                      'mime_type' => 'image/svg+xml', 'file_size' => 5400, 'folder' => '/brand',  'alt_text' => 'Kosan logo'],
        ];

        foreach ($mediaFiles as $mf) {
            CmsMedia::updateOrCreate(
                ['filename' => $mf['filename']],
                $mf
            );
        }
    }
}
