<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\ContractService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private ContractService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->tenant = Tenant::create([
            'name' => 'Workspace A',
            'slug' => 'workspace-a',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Landlord Owner',
            'email' => 'landlord@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'permissions' => ['manage-settings', 'manage-rooms'],
        ]);

        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Premium Kos Dago',
            'slug' => 'premium-kos-dago',
            'address' => 'Jl. Dago No. 100, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'whatsapp_number' => '0812345678',
        ]);

        $roomService = new \App\Services\RoomService();
        $this->room = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '202',
            'room_type' => 'Deluxe',
            'floor' => 2,
            'monthly_rent' => 2000000.00,
            'status' => 'available',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Jane Doe',
            'nik' => '3201234567890005',
            'gender' => 'female',
            'date_of_birth' => '1998-08-20',
            'place_of_birth' => 'Bandung',
            'nationality' => 'WNI',
            'occupation' => 'Employee',
            'marital_status' => 'single',
            'phone' => '0812345670',
            'whatsapp' => '0812345670',
            'email' => 'jane@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Mother',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Dago',
        ]);

        $this->service = new ContractService();

        app(\App\Services\TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_contract_draft_can_be_created(): void
    {
        $contract = $this->service->createContract([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_type' => 'monthly',
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 2000000.00,
            'security_deposit' => 500000.00,
        ]);

        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'status' => ContractStatus::DRAFT->value,
            'version' => 1,
        ]);

        $this->assertDatabaseHas('contract_timelines', [
            'contract_id' => $contract->id,
            'event' => 'created',
        ]);
    }

    public function test_contract_can_be_activated_which_generates_signed_pdf(): void
    {
        $contract = $this->service->createContract([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_type' => 'monthly',
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 2000000.00,
            'security_deposit' => 500000.00,
        ]);

        $this->assertNull($contract->signed_pdf_path);

        $this->service->activateContract($contract);

        $this->assertEquals(ContractStatus::ACTIVE, $contract->fresh()->status);
        $this->assertNotNull($contract->fresh()->signed_pdf_path);

        // Verify PDF file exists in fake storage
        Storage::disk('public')->assertExists($contract->fresh()->signed_pdf_path);
    }

    public function test_contract_can_be_renewed_preserving_history_versions(): void
    {
        $contract = $this->service->createContract([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_type' => 'monthly',
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 2000000.00,
            'security_deposit' => 500000.00,
        ]);

        // Activate v1
        $this->service->activateContract($contract);
        $this->assertEquals(1, $contract->fresh()->version);

        // Renew to v2
        $this->service->renewContract($contract, [
            'start_date' => '2026-08-16',
            'end_date' => '2026-09-16',
            'duration_months' => 1,
            'monthly_rent' => 2100000.00,
            'renewal_reason' => 'Standard inflation adjustment.',
        ], $this->user);

        $contract = $contract->fresh();
        $this->assertEquals(2, $contract->version);
        $this->assertEquals(2100000.00, $contract->monthly_rent);

        // Assert history matches previous values
        $this->assertDatabaseHas('contract_versions', [
            'contract_id' => $contract->id,
            'version_number' => 1,
            'created_by' => $this->user->id,
        ]);

        $version = $contract->versions()->first();
        $this->assertEquals(2000000.00, $version->previous_values['monthly_rent']);
    }
}
