<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
use App\Services\SaaS\ImportService;
use App\Enums\WorkspaceStatus;
use App\Enums\SubscriptionStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SaaSOnboardingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\SaasPlansSeeder::class);
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_pending_workspace_redirects_to_onboarding_route(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@onboard.test',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $tenant = Tenant::create([
            'name' => 'Johns Kos',
            'slug' => 'johns-kos',
            'status' => WorkspaceStatus::PENDING,
        ]);

        $ownerRole = Role::where('name', 'owner')->first();
        $user->tenants()->attach($tenant->id, ['role_id' => $ownerRole->id, 'is_active' => true]);

        $response = $this->actingAs($user)
            ->withSession(['tenant_id' => $tenant->id])
            ->get('/dashboard');

        $response->assertRedirect(route('onboarding'));
    }

    public function test_import_service_validates_required_headers(): void
    {
        $importService = new ImportService();
        
        // Write temporary CSV with invalid headers
        $path = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($path, "invalid_header_1,invalid_header_2\n123,456");

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Missing required header: room_number");

        $importService->parseCsv($path, ['room_number', 'monthly_rent']);

        unlink($path);
    }

    public function test_import_service_detects_duplicates_and_returns_errors(): void
    {
        $importService = new ImportService();

        // 1. Setup duplicate testing rows
        $rows = [
            ['room_number' => '101', 'floor' => '1', 'room_type' => 'Standard', 'monthly_rent' => '1200000', 'status' => 'vacant'],
            ['room_number' => '101', 'floor' => '1', 'room_type' => 'Standard', 'monthly_rent' => '1200000', 'status' => 'vacant'],
        ];

        $preview = $importService->previewRooms($rows, 'placeholder-id');

        $this->assertTrue($preview[0]['is_valid']);
        $this->assertFalse($preview[1]['is_valid']);
        $this->assertStringContainsString("Nomor kamar ganda dalam CSV", $preview[1]['errors'][0]);
    }
}
