<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Monitoring\MonitoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MonitoringObservabilityTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        // Admin User (Mock Owner role checks)
        $this->admin = User::factory()->create([
            'email' => 'admin@kosan.test',
        ]);
        
        $ownerRole = \App\Models\Role::firstOrCreate(['name' => 'owner'], ['label' => 'Owner']);
        
        // Mock role pivot setup for tests
        $tenant = \App\Models\Tenant::factory()->create();
        $this->admin->tenants()->attach($tenant->id, [
            'role_id' => $ownerRole->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);

        // Regular Staff User
        $this->staff = User::factory()->create([
            'email' => 'staff@kosan.test',
        ]);
        
        $staffRole = \App\Models\Role::firstOrCreate(['name' => 'staff'], ['label' => 'Staff']);
        $this->staff->tenants()->attach($tenant->id, [
            'role_id' => $staffRole->id,
            'is_active' => true,
            'joined_at' => now(),
        ]);
    }

    public function test_monitoring_middleware_records_http_requests(): void
    {
        // 1. Act: hit marketing page
        $response = $this->get('/');
        $response->assertStatus(200);

        // 2. Assert: request gets logged in DB
        $this->assertDatabaseHas('monitoring_request_logs', [
            'url' => '/',
            'status_code' => 200,
        ]);

        $log = DB::table('monitoring_request_logs')->first();
        $this->assertNotNull($log);
        $this->assertGreaterThanOrEqual(0, $log->duration_ms);
    }

    public function test_monitoring_service_groups_duplicate_exceptions(): void
    {
        $service = new MonitoringService();

        // 1. Act: log the same exception twice
        $exception = new \Exception('Database syntax failure');
        $service->logException($exception, '/pricing');
        $service->logException($exception, '/pricing');

        // 2. Assert: only one grouped exception row created with occurrences count = 2
        $records = DB::table('monitoring_exceptions')->get();
        $this->assertCount(1, $records);
        
        $first = $records->first();
        $this->assertEquals(\Exception::class, $first->exception_class);
        $this->assertEquals('Database syntax failure', $first->message);
        $this->assertEquals(2, $first->occurrences_count);
    }

    public function test_sre_monitoring_console_permissions(): void
    {
        // Guests cannot access console
        $response = $this->get('/dashboard/monitoring');
        $response->assertRedirect('/login');

        // Regular staff gets 403 Forbidden
        $response = $this->actingAs($this->staff)->get('/dashboard/monitoring');
        $response->assertStatus(403);

        // Owner/Admin accesses successfully
        $response = $this->actingAs($this->admin)->get('/dashboard/monitoring');
        $response->assertStatus(200);
    }
}
