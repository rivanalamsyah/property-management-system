<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Marketing\ContactForm;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Testing\RefreshDatabase;

class MarketingWebsiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketing_pages_load_successfully(): void
    {
        $pages = [
            '/',
            '/features',
            '/pricing',
            '/resources',
            '/about',
            '/contact'
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }

    public function test_sitemap_xml_loads(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $this->assertStringContainsString('<urlset', $response->getContent());
        $this->assertStringContainsString(route('home'), $response->getContent());
    }

    public function test_robots_txt_loads(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $this->assertStringContainsString('User-agent: *', $response->getContent());
        $this->assertStringContainsString('Disallow: /dashboard*', $response->getContent());
        $this->assertStringContainsString('Sitemap: ' . route('sitemap'), $response->getContent());
    }

    public function test_demo_form_validation_and_submission(): void
    {
        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message) {
                return str_contains($message, 'Demo request received from: Bruce Wayne');
            });

        Livewire::test(ContactForm::class)
            ->set('name', 'Bruce Wayne')
            ->set('email', 'bruce@wayne.com')
            ->set('phone', '0812345678')
            ->set('company_name', 'Wayne Enterprises')
            ->set('property_size', '51-200')
            ->set('message', 'Please give us a walkthrough of tenant policy locks.')
            ->call('submitDemoRequest')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Terima kasih! Permintaan demo Anda telah berhasil terdaftar. Tim spesialis kami akan menghubungi Anda dalam waktu 1x24 jam.');
    }
}
