<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsMenu;
use App\Models\CmsGlobal;
use App\Models\CmsFaq;
use App\Models\CmsTestimonial;
use App\Models\CmsPartner;
use App\Enums\CmsPublishStatus;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Predefined Pages
        $pages = [
            [
                'name' => 'Beranda',
                'slug' => 'home',
                'seo_title' => 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart',
                'seo_description' => 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).',
            ],
            [
                'name' => 'Fitur',
                'slug' => 'features',
                'seo_title' => 'Fitur Lengkap Aplikasi Pengelolaan Kos - Kosan',
                'seo_description' => 'Jelajahi 10 modul unggulan Kosan: otomatisasi tagihan sewa, pencatatan meteran listrik, pengelolaan kontrak hunian, hingga laporan keuangan real-time.',
            ],
            [
                'name' => 'Harga',
                'slug' => 'pricing',
                'seo_title' => 'Paket & Harga Aplikasi Kos - Transparan & Terjangkau | Kosan',
                'seo_description' => 'Mulai gratis hingga 5 kamar. Pilih paket pertumbuhan sesuai skala properti Anda. Tanpa biaya tersembunyi, batalkan kapan saja.',
            ],
            [
                'name' => 'Panduan & Blog',
                'slug' => 'resources',
                'seo_title' => 'Pusat Panduan, Artikel & Insight Pengelolaan Kos - Kosan',
                'seo_description' => 'Temukan panduan praktis, studi kasus, dan tips meningkatkan tingkat okupansi serta efisiensi penagihan kos dari pakar manajemen hunian.',
            ],
            [
                'name' => 'Tentang Kami',
                'slug' => 'about',
                'seo_title' => 'Tentang Kami - Sistem Operasi Bisnis Kos Modern | Kosan',
                'seo_description' => 'Pelajari misi, arsitektur teknologi, dan standar keamanan data Kosan dalam mentransformasi operasional bisnis hunian di Indonesia.',
            ],
            [
                'name' => 'Kontak',
                'slug' => 'contact',
                'seo_title' => 'Hubungi Kami & Jadwalkan Demo Platform - Kosan',
                'seo_description' => 'Konsultasikan kebutuhan operasional kos Anda dengan tim spesialis kami atau jadwalkan demo langsung untuk melihat cara kerja sistem.',
            ],
        ];

        $createdPages = [];
        foreach ($pages as $p) {
            $createdPages[$p['slug']] = CmsPage::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'name' => $p['name'],
                    'status' => CmsPublishStatus::PUBLISHED,
                    'seo_title' => $p['seo_title'],
                    'seo_description' => $p['seo_description'],
                    'published_at' => now(),
                ]
            );
        }

        // 2. Seed Default Sections for Home Page
        $homeSections = [
            [
                'type' => 'hero',
                'name' => 'Hero Banner',
                'content' => [
                    'heading' => 'Otomatisasi Penagihan & Pengelolaan Bisnis Kos dalam Satu Aplikasi',
                    'subtitle' => 'Kelola alokasi kamar, otomatisasi penagihan sewa bulanan, verifikasi bukti transfer otomatis, dan sediakan portal digital berbasis PWA untuk penghuni Anda.',
                    'body' => 'Tinggalkan cara manual dan rekapan spreadsheet yang rumit. Kosan memberikan transparansi penuh dan efisiensi operasional bagi pemilik kos modern.',
                    'button_label' => 'Coba Gratis 14 Hari',
                    'button_url' => '/register',
                ],
                'display_order' => 1,
            ],
            [
                'type' => 'stats',
                'name' => 'Platform Statistics',
                'content' => [
                    'heading' => 'Efisiensi Operasional Terbukti untuk Bisnis Kos',
                    'subtitle' => 'Angka yang membuktikan efisiensi dan tingkat kepuasan pemilik kos di Indonesia.',
                    'features' => [
                        ['title' => '99.2%', 'description' => 'Tingkat pelunasan tagihan sewa tepat waktu'],
                        ['title' => '3.4 Jam', 'description' => 'Rata-rata waktu penyelesaian laporan perbaikan'],
                        ['title' => '10.000+', 'description' => 'Kamar dan unit hunian aktif terkelola nasional'],
                    ],
                ],
                'display_order' => 2,
            ],
            [
                'type' => 'cta',
                'name' => 'Homepage CTA',
                'content' => [
                    'heading' => 'Siap Mengotomatisasi Operasional Bisnis Kos Anda?',
                    'subtitle' => 'Buat ruang kerja gratis, daftarkan properti kos Anda, dan undang staf operasional hanya dalam waktu 5 menit.',
                    'button_label' => 'Mulai Ruang Kerja Gratis',
                    'button_url' => '/register',
                ],
                'display_order' => 3,
            ]
        ];

        foreach ($homeSections as $sec) {
            CmsSection::updateOrCreate(
                [
                    'cms_page_id' => $createdPages['home']->id,
                    'type' => $sec['type'],
                ],
                [
                    'name' => $sec['name'],
                    'content' => $sec['content'],
                    'display_order' => $sec['display_order'],
                    'is_visible' => true,
                ]
            );
        }

        // 3. Seed Default Global Info
        $globals = [
            'company_profile' => 'Kosan adalah platform SaaS manajemen properti dan kos-kosan berbasis multi-tenant yang dirancang untuk mengotomatisasi penagihan sewa, verifikasi pembayaran, dan layanan penghuni.',
            'address' => 'Gedung Cyber, Lantai 5, Jl. Kuningan Barat No. 8, Jakarta Selatan, DKI Jakarta 12710',
            'email' => 'support@kosan.test',
            'phone' => '021-50998877',
            'whatsapp' => '081299998888',
            'business_hours' => 'Senin - Jumat, 09:00 - 18:00 WIB',
            'facebook' => 'https://facebook.com/kosan',
            'instagram' => 'https://instagram.com/kosan',
            'linkedin' => 'https://linkedin.com/company/kosan',
            'footer_info' => 'Kosan - Solusi otomatisasi pengelolaan kos dan hunian modern di Indonesia.',
            'copyright' => '© 2026 Kosan. Hak Cipta Dilindungi Undang-Undang.',
        ];

        foreach ($globals as $k => $v) {
            CmsGlobal::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        // 4. Seed Dynamic FAQs
        $faqs = [
            [
                'category' => 'Umum',
                'question' => 'Apa itu platform Kosan?',
                'answer' => 'Kosan adalah aplikasi manajemen kos modern berbasis SaaS multi-tenant yang membantu pemilik dan pengelola kos mengotomatisasi penagihan sewa, verifikasi pembayaran, pengelolaan kontrak, dan penanganan keluhan penghuni.',
                'display_order' => 1,
            ],
            [
                'category' => 'Penagihan',
                'question' => 'Bagaimana sistem penagihan otomatis bekerja?',
                'answer' => 'Sistem Kosan secara otomatis memeriksa tanggal aktif kontrak dan menerbitkan faktur tagihan bulanan. Penghuni menerima notifikasi dan dapat mengunggah bukti transfer langsung dari portal PWA mereka.',
                'display_order' => 2,
            ],
        ];

        foreach ($faqs as $fq) {
            CmsFaq::updateOrCreate(
                ['question' => $fq['question']],
                [
                    'category' => $fq['category'],
                    'answer' => $fq['answer'],
                    'display_order' => $fq['display_order'],
                    'is_visible' => true,
                ]
            );
        }

        // 5. Seed Testimonials
        $testimonials = [
            [
                'customer_name' => 'Budi Santoso',
                'avatar' => null,
                'company' => 'Cihampelas Residence',
                'position' => 'Pemilik Kos',
                'rating' => 5,
                'review' => 'Kosan sangat membantu mengotomatisasi penagihan sewa bulanan. Rekonsiliasi pembayaran yang biasanya memakan waktu berhari-hari kini selesai secara otomatis dan akurat.',
                'display_order' => 1,
            ],
        ];

        foreach ($testimonials as $t) {
            CmsTestimonial::updateOrCreate(
                ['customer_name' => $t['customer_name']],
                [
                    'company' => $t['company'],
                    'position' => $t['position'],
                    'rating' => $t['rating'],
                    'review' => $t['review'],
                    'is_visible' => true,
                ]
            );
        }

        // 6. Seed Menus
        $headerItems = [
            ['label' => 'Fitur', 'url' => '/features', 'target' => '_self', 'children' => []],
            ['label' => 'Harga', 'url' => '/pricing', 'target' => '_self', 'children' => []],
            ['label' => 'Panduan & Blog', 'url' => '/resources', 'target' => '_self', 'children' => []],
            ['label' => 'Tentang Kami', 'url' => '/about', 'target' => '_self', 'children' => []],
            ['label' => 'Kontak', 'url' => '/contact', 'target' => '_self', 'children' => []],
        ];

        CmsMenu::updateOrCreate(
            ['slug' => 'header_menu'],
            [
                'name' => 'Header Menu',
                'items' => $headerItems,
            ]
        );
    }
}
