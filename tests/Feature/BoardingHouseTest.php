<?php

namespace Tests\Feature;

use App\Models\BoardingHouse;
use App\Models\Facility;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use App\Services\BoardingHouseService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class BoardingHouseTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tenant $tenant;
    protected Role $ownerRole;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Seed Roles/Permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->ownerRole = Role::where('name', 'owner')->first();

        // 2. Create Tenant & User
        $this->tenant = Tenant::create([
            'name' => 'Kosan Test A',
            'slug' => 'test-a',
            'status' => 'active',
        ]);

        $this->user = User::factory()->create([
            'name' => 'Test User A',
            'email' => 'user-a@kosan.test',
            'password' => bcrypt('password'),
        ]);

        // Link User to Tenant
        $this->user->tenants()->attach($this->tenant->id, [
            'role_id' => $this->ownerRole->id,
            'is_active' => true,
        ]);

        // Initialize Tenant Context
        app(TenantManager::class)->setTenant($this->tenant);
    }

    public function test_creating_boarding_house_belongs_to_active_tenant(): void
    {
        $service = new BoardingHouseService();

        $boardingHouse = $service->createBoardingHouse([
            'name' => 'Kosan Cihampelas Indah',
            'address' => 'Jl. Cihampelas No. 15',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'whatsapp_number' => '0812345678',
            'status' => 'active',
        ]);

        $this->assertEquals($this->tenant->id, $boardingHouse->tenant_id);
        $this->assertEquals('kosan-cihampelas-indah', $boardingHouse->slug);
    }

    public function test_tenant_isolation_is_enforced(): void
    {
        // 1. Create a boarding house under Tenant A
        $service = new BoardingHouseService();
        $houseA = $service->createBoardingHouse([
            'name' => 'House Tenant A',
            'address' => 'Address A',
            'province' => 'Prov A',
            'city' => 'City A',
            'district' => 'Dist A',
            'postal_code' => '123',
            'whatsapp_number' => '081',
            'status' => 'active',
        ]);

        // 2. Create Tenant B and switch context
        $tenantB = Tenant::create([
            'name' => 'Kosan Test B',
            'slug' => 'test-b',
            'status' => 'active',
        ]);
        app(TenantManager::class)->setTenant($tenantB);

        // 3. Query Boarding Houses (Tenant B should not see Tenant A's boarding house due to global scope)
        $houses = BoardingHouse::all();
        $this->assertCount(0, $houses);

        // 4. Policy check: Tenant B's user cannot view Tenant A's boarding house
        $userB = User::factory()->create(['email' => 'user-b@kosan.test']);
        $userB->tenants()->attach($tenantB->id, [
            'role_id' => $this->ownerRole->id,
            'is_active' => true,
        ]);

        $this->actingAs($userB);
        $this->assertFalse($userB->can('view', $houseA));
    }

    public function test_updating_boarding_house_settings(): void
    {
        $service = new BoardingHouseService();
        $boardingHouse = $service->createBoardingHouse([
            'name' => 'Kosan Cihampelas Indah',
            'address' => 'Jl. Cihampelas No. 15',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'whatsapp_number' => '0812345678',
            'status' => 'active',
        ]);

        $service->updateSettings($boardingHouse, [
            'check_in_time' => '15:00',
            'billing_due_day' => 10,
            'invoice_prefix' => 'KOS-EXC',
        ]);

        $this->assertEquals('15:00', $boardingHouse->refresh()->getSetting('check_in_time'));
        $this->assertEquals(10, $boardingHouse->getSetting('billing_due_day'));
        $this->assertEquals('KOS-EXC', $boardingHouse->getSetting('invoice_prefix'));
    }
}
