<?php

namespace Tests\Feature;

use App\Enums\ResidentStatus;
use App\Models\BoardingHouse;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\ResidentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private ResidentService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::create([
            'name' => 'Test Organization Workspace',
            'slug' => 'test-workspace',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Owner Admin',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'permissions' => ['manage-settings', 'manage-rooms'],
        ]);

        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Kos Cihampelas 10',
            'slug' => 'kos-cihampelas-10',
            'address' => 'Jl. Cihampelas No. 10, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'whatsapp_number' => '0812345678',
        ]);

        $roomService = new \App\Services\RoomService();
        $this->room = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '101',
            'room_type' => 'Standard',
            'floor' => 1,
            'monthly_rent' => 1500000.00,
            'status' => 'available',
        ]);

        $this->service = new ResidentService();

        app(\App\Services\TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_resident_can_be_created_under_workspace(): void
    {
        $resident = $this->service->createResident([
            'tenant_id' => $this->tenant->id,
            'name' => 'Budi Santoso',
            'nik' => '3201234567890001',
            'gender' => 'male',
            'date_of_birth' => '1995-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Software Dev',
            'marital_status' => 'single',
            'phone' => '0812345678',
            'whatsapp' => '0812345678',
            'email' => 'budi@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu Indah',
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $resident->id,
            'name' => 'Budi Santoso',
            'status' => ResidentStatus::PENDING->value,
        ]);

        $this->assertDatabaseHas('resident_timelines', [
            'resident_id' => $resident->id,
            'event' => 'created',
        ]);
    }

    public function test_check_in_transitions_room_and_resident_states(): void
    {
        $resident = $this->service->createResident([
            'tenant_id' => $this->tenant->id,
            'name' => 'Budi Santoso',
            'nik' => '3201234567890001',
            'gender' => 'male',
            'date_of_birth' => '1995-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Software Dev',
            'marital_status' => 'single',
            'phone' => '0812345678',
            'whatsapp' => '0812345678',
            'email' => 'budi@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu Indah',
        ]);

        $this->assertEquals('available', $this->room->fresh()->status);

        $this->prepareCheckInPrerequisites($resident);

        $this->service->checkIn($resident, [
            'room_id' => $this->room->id,
            'check_in_date' => '2026-07-16',
            'move_in_time' => '09:00',
            'initial_meter_reading' => 120.50,
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Handover keys complete.',
        ]);

        $this->assertEquals(ResidentStatus::ACTIVE, $resident->fresh()->status);
        $this->assertEquals('occupied', $this->room->fresh()->status);

        $this->assertDatabaseHas('resident_timelines', [
            'resident_id' => $resident->id,
            'event' => 'check_in',
        ]);
    }

    public function test_cannot_check_in_already_occupied_room(): void
    {
        $resident1 = $this->service->createResident([
            'tenant_id' => $this->tenant->id,
            'name' => 'Resident 1',
            'nik' => '3201234567890001',
            'gender' => 'male',
            'date_of_birth' => '1995-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Developer',
            'marital_status' => 'single',
            'phone' => '0812345678',
            'whatsapp' => '0812345678',
            'email' => 'res1@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu Indah',
        ]);

        $resident2 = $this->service->createResident([
            'tenant_id' => $this->tenant->id,
            'name' => 'Resident 2',
            'nik' => '3201234567890002',
            'gender' => 'male',
            'date_of_birth' => '1996-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Designer',
            'marital_status' => 'single',
            'phone' => '0812345679',
            'whatsapp' => '0812345679',
            'email' => 'res2@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu Indah',
        ]);

        // Check in Resident 1
        $this->prepareCheckInPrerequisites($resident1);
        $this->prepareCheckInPrerequisites($resident2);

        $this->service->checkIn($resident1, [
            'room_id' => $this->room->id,
            'check_in_date' => '2026-07-16',
            'security_deposit' => 500000.00,
        ]);

        // Attempting to check in Resident 2 to the same room should trigger exception
        $this->expectException(\Exception::class);
        $this->service->checkIn($resident2, [
            'room_id' => $this->room->id,
            'check_in_date' => '2026-07-16',
            'security_deposit' => 500000.00,
        ]);
    }

    public function test_check_out_releases_room_and_changes_status(): void
    {
        $resident = $this->service->createResident([
            'tenant_id' => $this->tenant->id,
            'name' => 'Budi Santoso',
            'nik' => '3201234567890001',
            'gender' => 'male',
            'date_of_birth' => '1995-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Developer',
            'marital_status' => 'single',
            'phone' => '0812345678',
            'whatsapp' => '0812345678',
            'email' => 'budi@example.com',
            'emergency_name' => 'Slamet',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu Indah',
        ]);

        $this->prepareCheckInPrerequisites($resident);

        $this->service->checkIn($resident, [
            'room_id' => $this->room->id,
            'check_in_date' => '2026-07-16',
            'security_deposit' => 500000.00,
        ]);

        $this->assertEquals('occupied', $this->room->fresh()->status);

        $this->service->checkOut($resident, [
            'check_out_date' => '2026-08-16',
            'final_meter_reading' => 245.80,
            'check_out_notes' => 'Room returned clean.',
            'damage_notes' => 'No damages.',
        ]);

        $this->assertEquals(ResidentStatus::FORMER, $resident->fresh()->status);
        $this->assertEquals('available', $this->room->fresh()->status);
        $this->assertNull($resident->fresh()->room_id);

        $this->assertDatabaseHas('resident_timelines', [
            'resident_id' => $resident->id,
            'event' => 'check_out',
        ]);
    }

    private function prepareCheckInPrerequisites($resident): void
    {
        $resident->documents()->create([
            'document_type' => 'KTP',
            'file_path' => 'documents/ktp.png',
            'label' => 'KTP Card',
        ]);

        \App\Models\Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $resident->id,
            'contract_number' => 'CTR-2026-' . rand(100000, 999999),
            'contract_type' => 'monthly',
            'status' => \App\Enums\ContractStatus::ACTIVE,
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 1500000.00,
        ]);
    }
}
