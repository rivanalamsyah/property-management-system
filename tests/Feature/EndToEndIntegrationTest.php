<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentStatus;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\BillingService;
use App\Services\ComplaintService;
use App\Services\PaymentService;
use App\Services\RoomService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EndToEndIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_saas_boarding_house_business_workflow(): void
    {
        Storage::fake('public');

        // 1. Tenant Creation & Initialization
        $tenant = Tenant::create([
            'name' => 'Adhiguna Executive Living',
            'slug' => 'adhiguna-living',
        ]);

        $ownerUser = User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Wibowo Adhiguna',
            'email' => 'wibowo@adhigunaliving.com',
            'password' => bcrypt('SecurePassword123!'),
            'role' => 'owner',
        ]);

        app(TenantManager::class)->setTenant($tenant);
        session(['active_tenant' => $tenant]);
        $this->actingAs($ownerUser);

        // 2. Create Boarding House
        $boardingHouse = BoardingHouse::create([
            'tenant_id' => $tenant->id,
            'name' => 'Adhiguna Heights Cilandak',
            'slug' => 'adhiguna-heights-cilandak',
            'address' => 'Jl. Cilandak Barat No. 99, Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Cilandak',
            'postal_code' => '12430',
            'whatsapp_number' => '081299998888',
        ]);

        // 3. Create dynamic facilities catalog
        $facility = $boardingHouse->facilities()->create([
            'name' => 'Wi-Fi 1Gbps',
            'icon' => 'wifi',
            'description' => 'Ultra high speed fiber internet connection.',
        ]);

        // 4. Create Room
        $roomService = new RoomService();
        $room = $roomService->createRoom([
            'boarding_house_id' => $boardingHouse->id,
            'room_number' => 'A-101',
            'room_type' => 'Suite Deluxe',
            'floor' => 1,
            'monthly_rent' => 5000000.00,
            'status' => 'available',
        ]);

        $this->assertEquals('available', $room->status);

        // 5. Create Resident
        $resident = Resident::create([
            'tenant_id' => $tenant->id,
            'name' => 'Ahmad Fauzi',
            'nik' => '3273010101990001',
            'gender' => 'male',
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Software Engineer',
            'marital_status' => 'single',
            'phone' => '081122223333',
            'whatsapp' => '081122223333',
            'email' => 'fauzi@gmail.com',
            'emergency_name' => 'Hasan Fauzi',
            'emergency_relationship' => 'Brother',
            'emergency_phone' => '081122224444',
            'emergency_address' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Cilandak',
            'postal_code' => '12430',
            'address' => 'Jl. Cilandak Barat No. 10',
        ]);

        // 6. Generate Lease Contract
        $contract = Contract::create([
            'tenant_id' => $tenant->id,
            'boarding_house_id' => $boardingHouse->id,
            'room_id' => $room->id,
            'resident_id' => $resident->id,
            'contract_number' => 'CTR-ADH-001',
            'contract_type' => 'monthly',
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-01',
            'move_in_date' => '2026-07-01',
            'monthly_rent' => 5000000.00,
            'security_deposit' => 1500000.00,
            'discount' => 200000.00,
        ]);

        // 7. Generate Billing Invoice automatically
        $billingService = new BillingService();
        $invoice = $billingService->createInvoiceFromContract(
            contract: $contract,
            periodStart: '2026-07-01',
            periodEnd: '2026-08-01'
        );

        $this->assertEquals(InvoiceStatus::PENDING, $invoice->status);
        // grand total is Rent (5,000,000) - Discount (200,000) = 4,800,000
        $this->assertEquals(4800000.00, $invoice->grand_total);

        // 8. Record/Initiate Resident Payment Transfer
        $paymentService = new PaymentService();
        $payment = $paymentService->initiatePayment([
            'invoice_id' => $invoice->id,
            'payment_date' => '2026-07-05',
            'payment_method' => 'bank_transfer',
            'amount_paid' => 4800000.00,
            'reference_number' => 'BANK-REF-999',
        ]);

        $this->assertEquals(PaymentStatus::PENDING, $payment->status);

        // Upload transfer proof of payment
        $paymentService->uploadProof($payment, 'proofs/transfer-statement.jpg');
        $this->assertEquals(PaymentStatus::WAITING_VERIFICATION, $payment->fresh()->status);

        // Approve manual verification: auto-reconciles Invoice to Paid!
        $paymentService->verifyPayment($payment, $ownerUser, true, 'Payment matches bank account records.');
        $this->assertEquals(PaymentStatus::COMPLETED, $payment->fresh()->status);
        $this->assertEquals(InvoiceStatus::PAID, $invoice->fresh()->status);

        // 9. File a Complaint Case
        $complaintService = new ComplaintService();
        $complaint = $complaintService->createComplaint([
            'tenant_id' => $tenant->id,
            'boarding_house_id' => $boardingHouse->id,
            'room_id' => $room->id,
            'resident_id' => $resident->id,
            'category' => 'ac',
            'priority' => ComplaintPriority::HIGH->value,
            'subject' => 'AC in A-101 leaking water',
            'description' => 'Air conditioner units are leaking water droplets from the main vents.',
        ]);

        $this->assertEquals(ComplaintStatus::OPEN, $complaint->status);

        // Promote complaint into a maintenance task
        $task = $complaintService->createMaintenanceTask($complaint, [
            'assigned_staff_id' => $ownerUser->id,
            'estimated_completion_date' => '2026-07-10',
            'cost' => 200000.00,
            'checklists' => [
                'Inspect drainage pipes',
                'Clean air filters',
                'Refill refrigerant freon gas',
            ],
        ]);

        $this->assertEquals(ComplaintStatus::ASSIGNED, $complaint->fresh()->status);
        $this->assertCount(3, $task->checklists);

        // Track and check off list items
        foreach ($task->checklists as $chk) {
            $chk->update(['is_completed' => true]);
        }

        // Add internal comments
        $complaintService->addComment($complaint, [
            'user_id' => $ownerUser->id,
            'comment' => 'Refrigerant refill scheduled for tomorrow morning.',
            'is_tenant_visible' => false,
        ]);

        // Complete repairs work
        $complaintService->updateMaintenanceTaskProgress($task, [
            'repair_notes' => 'Cleaned water channels, refilled Freon R32, verified no more leakages.',
            'replacement_parts' => 'Freon R32 gas refill',
            'cost' => 180000.00,
            'actual_completion_date' => '2026-07-09',
        ]);

        // Mark complaint status resolved/completed
        $complaintService->updateComplaintStatus($complaint, ComplaintStatus::COMPLETED, 'AC repairs finished.');
        $this->assertEquals(ComplaintStatus::COMPLETED, $complaint->fresh()->status);

        // Verify and close complaint
        $complaintService->updateComplaintStatus($complaint, ComplaintStatus::VERIFIED, 'Verified resolved and functioning perfectly.');
        $complaintService->updateComplaintStatus($complaint, ComplaintStatus::CLOSED, 'Archiving case.');
        $this->assertEquals(ComplaintStatus::CLOSED, $complaint->fresh()->status);
    }
}
