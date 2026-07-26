<?php

namespace Tests\Feature;

use App\Models\BoardingHouse;
use App\Models\Facility;
use App\Models\Role;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\RoomService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tenant $tenant;
    protected Role $ownerRole;
    protected BoardingHouse $boardingHouse;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Seed Roles/Permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->ownerRole = Role::where('name', 'owner')->first();

        // Create Tenant & User
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

        // Create a default Boarding House
        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Kosan A1',
            'slug' => 'kosan-a1',
            'address' => 'Jl. A1',
            'province' => 'Jabar',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'whatsapp_number' => '081',
            'status' => 'active',
        ]);
    }

    public function test_creating_room_generates_code_and_local_qr(): void
    {
        $service = new RoomService();

        $room = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '101',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'available',
        ]);

        $this->assertNotEmpty($room->room_code);
        $this->assertNotEmpty($room->qr_code_path);
        
        // Assert file exists in local storage
        Storage::disk('public')->assertExists($room->qr_code_path);
    }

    public function test_unique_room_numbers_within_same_boarding_house(): void
    {
        $service = new RoomService();

        $room1 = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '102',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'available',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // Try creating second room with the same room number '102'
        Room::create([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '102',
            'room_type' => 'Deluxe',
            'monthly_rent' => 1500000.00,
            'room_code' => 'RM-DUP',
            'status' => 'available',
        ]);
    }

    public function test_occupied_room_deletes_blocked(): void
    {
        $service = new RoomService();

        $room = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '103',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'occupied', // Marked occupied
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot delete occupied rooms containing active tenant bookings.");

        $service->deleteRoom($room);
    }

    public function test_occupied_room_critical_edits_blocked_unless_override(): void
    {
        $service = new RoomService();

        $room = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '104',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'occupied',
        ]);

        // Attempting critical edit (change monthly_rent) without override flag should throw exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot modify rent or room number for occupied rooms without active tenant override authorization.");

        $service->updateRoom($room, ['monthly_rent' => 1400000.00], false);
    }

    public function test_occupied_room_critical_edits_allowed_with_override(): void
    {
        $service = new RoomService();

        $room = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '105',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'occupied',
        ]);

        // Updating with override flag = true should work successfully
        $service->updateRoom($room, ['monthly_rent' => 1400000.00], true);

        $this->assertEquals(1400000.00, $room->refresh()->monthly_rent);
    }

    public function test_tenant_isolation_is_enforced(): void
    {
        $service = new RoomService();
        $room = $service->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '106',
            'room_type' => 'Standard',
            'monthly_rent' => 1200000.00,
            'max_occupants' => 1,
            'status' => 'available',
        ]);

        // Create Tenant B
        $tenantB = Tenant::create([
            'name' => 'Kosan Test B',
            'slug' => 'test-b',
            'status' => 'active',
        ]);
        app(TenantManager::class)->setTenant($tenantB);

        // Under Tenant B query scope, Room under Tenant A should not be visible
        $rooms = Room::all();
        $this->assertCount(0, $rooms);

        // Policy check
        $userB = User::factory()->create();
        $userB->tenants()->attach($tenantB->id, [
            'role_id' => $this->ownerRole->id,
            'is_active' => true,
        ]);
        $this->actingAs($userB);

        $this->assertFalse($userB->can('view', $room));
    }
}
