<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Models\BoardingHouse;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\SavedReport;
use App\Models\Tenant;
use App\Models\User;
use App\Services\AnalyticsService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private AnalyticsService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::create([
            'name' => 'Workspace F',
            'slug' => 'workspace-f',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Owner BI',
            'email' => 'bi@example.com',
            'role' => 'owner',
            'password' => bcrypt('password'),
        ]);

        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Signature Kos Dago',
            'slug' => 'signature-kos-dago',
            'address' => 'Jl. Dago No. 44, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'whatsapp_number' => '0812345681',
        ]);

        $roomService = new \App\Services\RoomService();
        $this->room = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '801',
            'room_type' => 'Premium',
            'floor' => 8,
            'monthly_rent' => 3500000.00,
            'status' => 'occupied',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Bruce Wayne',
            'nik' => '3201234567890014',
            'gender' => 'male',
            'date_of_birth' => '1990-10-10',
            'place_of_birth' => 'Gotham',
            'nationality' => 'WNI',
            'occupation' => 'Business Owner',
            'marital_status' => 'single',
            'phone' => '0812345685',
            'whatsapp' => '0812345685',
            'email' => 'bruce@example.com',
            'emergency_name' => 'Alfred Pennyworth',
            'emergency_relationship' => 'Butler',
            'emergency_phone' => '081223369',
            'emergency_address' => 'Gotham',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Dago Giri',
        ]);

        // Add active contract
        $contract = \App\Models\Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_number' => 'CTR-2026-888888',
            'contract_type' => 'monthly',
            'status' => \App\Enums\ContractStatus::ACTIVE,
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-01',
            'move_in_date' => '2026-07-01',
            'monthly_rent' => 3500000.00,
            'security_deposit' => 1000000.00,
        ]);

        $billingService = new \App\Services\BillingService();
        $invoice = $billingService->createInvoiceFromContract($contract, '2026-07-01', '2026-08-01');

        // Seed a completed payment to compute revenue
        Payment::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'resident_id' => $this->resident->id,
            'invoice_id' => $invoice->id,
            'payment_number' => 'PAY-2026-000001',
            'amount_paid' => 3500000.00,
            'payment_date' => '2026-07-16 10:00:00',
            'payment_method' => 'bank_transfer',
            'status' => PaymentStatus::COMPLETED,
        ]);

        $this->service = new AnalyticsService();

        app(TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_kpi_aggregates_are_correct(): void
    {
        $kpis = $this->service->getKPIs([]);

        $this->assertEquals(1, $kpis['totalHouses']);
        $this->assertEquals(1, $kpis['totalRooms']);
        $this->assertEquals(100.0, $kpis['occupancyRate']);
        $this->assertEquals(3500000.00, $kpis['monthlyRevenue']);
    }

    public function test_svg_coordinates_generator_produces_valid_coordinates(): void
    {
        $points = [100, 200, 300, 150];
        $coords = $this->service->generateSVGCoordinates($points, 500, 200);

        $this->assertNotEmpty($coords['points']);
        $this->assertNotEmpty($coords['areaPoints']);
        $this->assertEquals(300, $coords['maxVal']);
    }

    public function test_landlord_can_save_reporting_filters(): void
    {
        $report = SavedReport::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Monthly financials Dago',
            'report_type' => 'financials',
            'filters' => [
                'boarding_house_id' => $this->boardingHouse->id,
                'year' => '2026',
            ],
            'user_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('saved_reports', [
            'id' => $report->id,
            'name' => 'Monthly financials Dago',
        ]);
    }
}
