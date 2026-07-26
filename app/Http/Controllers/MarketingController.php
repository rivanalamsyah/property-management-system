<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\CmsGlobal;
use App\Models\CmsFaq;
use App\Models\CmsTestimonial;
use App\Models\CmsPartner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MarketingController extends Controller
{
    protected function getGlobals(): array
    {
        try {
            return CmsGlobal::pluck('value', 'key')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    public function home()
    {
        $page = null;
        $globals = [];
        $faqs = collect();
        $testimonials = collect();
        $partners = collect();

        try {
            $page = CmsPage::with('sections')->where('slug', 'home')->first();
            $globals = $this->getGlobals();
            $faqs = CmsFaq::where('is_visible', true)->orderBy('display_order')->get();
            $testimonials = CmsTestimonial::where('is_visible', true)->orderBy('display_order')->get();
            $partners = CmsPartner::where('is_visible', true)->orderBy('display_order')->get();
        } catch (\Exception $e) {
            // Safe fallback for unit tests running without migrations
        }
        
        $hero = $page?->sections->where('type', 'hero')->first();
        $stats = $page?->sections->where('type', 'stats')->first();
        $cta = $page?->sections->where('type', 'cta')->first();

        return view('marketing.home', [
            'meta_title' => $page?->seo_title ?? 'Kosan - Otomatisasi Penagihan & Pengelolaan Kos Smart',
            'meta_description' => $page?->seo_description ?? 'Kelola bisnis kos lebih mudah dan efisien. Otomatisasi tagihan sewa, verifikasi pembayaran otomatis, kelola penghuni, dan sediakan portal digital penghuni (PWA).',
            'canonical' => route('home'),
            'heroContent' => $hero?->content ?? [],
            'statsContent' => $stats?->content ?? [],
            'ctaContent' => $cta?->content ?? [],
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'partners' => $partners,
            'globals' => $globals,
        ]);
    }

    public function features()
    {
        $page = null;
        $globals = [];
        try {
            $page = CmsPage::with('sections')->where('slug', 'features')->first();
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.features', [
            'meta_title' => $page?->seo_title ?? 'Fitur Lengkap Aplikasi Pengelolaan Kos - Kosan',
            'meta_description' => $page?->seo_description ?? 'Jelajahi 10 modul unggulan Kosan: otomatisasi tagihan sewa, pencatatan meteran listrik, pengelolaan kontrak hunian, hingga laporan keuangan real-time.',
            'canonical' => route('features'),
            'globals' => $globals,
        ]);
    }

    public function pricing()
    {
        $page = null;
        $globals = [];
        try {
            $page = CmsPage::with('sections')->where('slug', 'pricing')->first();
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.pricing', [
            'meta_title' => $page?->seo_title ?? 'Paket & Harga Aplikasi Kos - Transparan & Terjangkau | Kosan',
            'meta_description' => $page?->seo_description ?? 'Mulai gratis hingga 5 kamar. Pilih paket pertumbuhan sesuai skala properti Anda. Tanpa biaya tersembunyi, batalkan kapan saja.',
            'canonical' => route('pricing'),
            'globals' => $globals,
        ]);
    }

    public function resources()
    {
        $page = null;
        $globals = [];
        try {
            $page = CmsPage::with('sections')->where('slug', 'resources')->first();
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.resources', [
            'meta_title' => $page?->seo_title ?? 'Pusat Panduan, Artikel & Insight Pengelolaan Kos - Kosan',
            'meta_description' => $page?->seo_description ?? 'Temukan panduan praktis, studi kasus, dan tips meningkatkan tingkat okupansi serta efisiensi penagihan kos dari pakar manajemen hunian.',
            'canonical' => route('resources'),
            'globals' => $globals,
        ]);
    }

    public function about()
    {
        $page = null;
        $globals = [];
        try {
            $page = CmsPage::with('sections')->where('slug', 'about')->first();
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.about', [
            'meta_title' => $page?->seo_title ?? 'Tentang Kami - Sistem Operasi Bisnis Kos Modern | Kosan',
            'meta_description' => $page?->seo_description ?? 'Pelajari misi, arsitektur teknologi, dan standar keamanan data Kosan dalam mentransformasi operasional bisnis hunian di Indonesia.',
            'canonical' => route('about'),
            'globals' => $globals,
        ]);
    }

    public function contact()
    {
        $page = null;
        $globals = [];
        try {
            $page = CmsPage::with('sections')->where('slug', 'contact')->first();
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.contact', [
            'meta_title' => $page?->seo_title ?? 'Hubungi Kami & Jadwalkan Demo Platform - Kosan',
            'meta_description' => $page?->seo_description ?? 'Konsultasikan kebutuhan operasional kos Anda dengan tim spesialis kami atau jadwalkan demo langsung untuk melihat cara kerja sistem.',
            'canonical' => route('contact'),
            'globals' => $globals,
        ]);
    }

    public function privacy()
    {
        $globals = [];
        try {
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.privacy', [
            'meta_title' => 'Kebijakan Privasi & Perlindungan Data - Kosan',
            'meta_description' => 'Kebijakan privasi platform Kosan mengenai pengumpulan, penyimpanan, enkripsi, dan hak perlindungan data pengguna serta penghuni kos.',
            'canonical' => route('privacy'),
            'globals' => $globals,
        ]);
    }

    public function terms()
    {
        $globals = [];
        try {
            $globals = $this->getGlobals();
        } catch (\Exception $e) {}

        return view('marketing.terms', [
            'meta_title' => 'Syarat & Ketentuan Layanan - Kosan',
            'meta_description' => 'Syarat dan ketentuan penggunaan platform Kosan, ketentuan berlangganan, kewajiban akun, dan batasan tanggung jawab.',
            'canonical' => route('terms'),
            'globals' => $globals,
        ]);
    }

    public function sitemap(): Response
    {
        $urls = [
            route('home'),
            route('features'),
            route('pricing'),
            route('resources'),
            route('about'),
            route('contact'),
            route('privacy'),
            route('terms'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>' . ($url === route('home') ? '1.0' : '0.8') . '</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots(): Response
    {
        $txt = "User-agent: *\n";
        $txt .= "Allow: /\n";
        $txt .= "Disallow: /dashboard*\n";
        $txt .= "Disallow: /email*\n";
        $txt .= "\n";
        $txt .= "Sitemap: " . route('sitemap') . "\n";

        return response($txt, 200, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
