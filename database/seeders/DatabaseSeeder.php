<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Facility;
use App\Models\BoardingHouse;
use App\Models\BoardingHouseGallery;
use App\Models\BoardingHouseRule;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\Resident;
use App\Models\ResidentDocument;
use App\Models\ResidentTimeline;
use App\Models\Contract;
use App\Models\ContractVersion;
use App\Models\ContractAttachment;
use App\Models\ContractTimeline;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTimeline;
use App\Models\Payment;
use App\Models\PaymentTimeline;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintComment;
use App\Models\ComplaintTimeline;
use App\Models\MaintenanceTask;
use App\Models\MaintenanceChecklist;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\InAppNotification;
use App\Models\SavedReport;
use App\Models\Setting;

use App\Enums\ResidentStatus;
use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceItemType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use App\Enums\ComplaintStatus;
use App\Enums\ComplaintPriority;
use App\Enums\AnnouncementStatus;
use App\Enums\AnnouncementPriority;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run SaaS Plans Seeder
        $this->call(SaasPlansSeeder::class);

        // 2. Run Roles and Permissions Seeder
        $this->call(RolesAndPermissionsSeeder::class);

        $ownerRole = Role::where('name', 'owner')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $tenantRole = Role::where('name', 'tenant')->first();

        // 2. Create global facilities (tenant_id is null)
        $globalFacilities = [
            ['name' => 'High-Speed Wi-Fi', 'slug' => 'high-speed-wi-fi', 'icon' => 'wifi', 'category' => 'Room', 'display_order' => 1],
            ['name' => 'Air Conditioner (AC)', 'slug' => 'air-conditioner-ac', 'icon' => 'bolt', 'category' => 'Room', 'display_order' => 2],
            ['name' => 'Private Bathroom', 'slug' => 'private-bathroom', 'icon' => 'bath', 'category' => 'Room', 'display_order' => 3],
            ['name' => 'Television', 'slug' => 'television', 'icon' => 'tv', 'category' => 'Room', 'display_order' => 4],
            ['name' => 'Water Heater', 'slug' => 'water-heater', 'icon' => 'thermometer-half', 'category' => 'Room', 'display_order' => 5],
            ['name' => 'Parking Slot', 'slug' => 'parking-slot', 'icon' => 'parking', 'category' => 'Shared', 'display_order' => 6],
            ['name' => '24/7 Security CCTV', 'slug' => 'cctv-security', 'icon' => 'shield-alt', 'category' => 'Security', 'display_order' => 7],
        ];

        $facilityModels = [];
        foreach ($globalFacilities as $facData) {
            $facilityModels[] = Facility::create($facData);
        }

        // ==========================================
        // TENANT 1: Kosan Premium Cihampelas
        // ==========================================
        $tenant1 = Tenant::create([
            'name' => 'Kosan Premium Cihampelas',
            'slug' => 'cihampelas',
            'status' => \App\Enums\WorkspaceStatus::ACTIVE,
            'company_name' => 'Cihampelas Group LLC',
            'brand_name' => 'Kosan Cihampelas',
            'subscription_plan_id' => '019f8390-3333-7398-84fa-13e83cfc1e46', // Business Plan
            'subscription_status' => \App\Enums\SubscriptionStatus::ACTIVE,
            'subscription_ends_at' => now()->addDays(30),
            'next_billing_at' => now()->addDays(30),
            'settings' => [
                'timezone' => 'Asia/Jakarta',
                'currency' => 'IDR',
                'locale' => 'id',
            ],
        ]);

        // Define Testing Accounts for Tenant 1
        $owner1 = User::create([
            'name' => 'Rivan Alamsyah (Owner)',
            'email' => 'owner@kosan.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
        ]);
        $owner1->tenants()->attach($tenant1->id, ['role_id' => $ownerRole->id, 'is_active' => true]);

        $manager1 = User::create([
            'name' => 'Budi Hartono (Manager)',
            'email' => 'manager@kosan.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
        ]);
        $manager1->tenants()->attach($tenant1->id, ['role_id' => $managerRole->id, 'is_active' => true]);

        $staff1 = User::create([
            'name' => 'Andi Wijaya (Staff)',
            'email' => 'staff@kosan.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
        ]);
        $staff1->tenants()->attach($tenant1->id, ['role_id' => $staffRole->id, 'is_active' => true]);

        $tenantUser1 = User::create([
            'name' => 'Budi Santoso (Resident)',
            'email' => 'tenant@kosan.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
        ]);
        $tenantUser1->tenants()->attach($tenant1->id, ['role_id' => $tenantRole->id, 'is_active' => true]);

        // Set active Tenant context to seed child models properly via BelongsToTenant
        tenant_manager()->setTenant($tenant1);

        // Seed Boarding Houses for Tenant 1
        $bh1 = BoardingHouse::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Griya Cihampelas Indah',
            'slug' => 'griya-cihampelas-indah',
            'description' => 'Kost eksklusif dekat kampus ITB dan pusat perbelanjaan Cihampelas Walk.',
            'address' => 'Jl. Cihampelas No. 120, Coblong',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'latitude' => -6.8925,
            'longitude' => 107.6038,
            'whatsapp_number' => '081234567890',
            'email' => 'griya@cihampelas.test',
            'operating_hours' => '24 Hours',
            'status' => 'active',
            'is_public' => true,
            'settings' => BoardingHouse::defaultSettings(),
        ]);
        $bh1->facilities()->attach(array_column($facilityModels, 'id'), ['is_featured' => true]);

        $bh2 = BoardingHouse::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Cihampelas Residence',
            'slug' => 'cihampelas-residence',
            'description' => 'Kost nyaman dan tenang dengan parkir luas dan penjagaan 24 jam.',
            'address' => 'Jl. Cihampelas No. 240, Coblong',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40132',
            'latitude' => -6.8950,
            'longitude' => 107.6045,
            'whatsapp_number' => '081234567891',
            'email' => 'residence@cihampelas.test',
            'operating_hours' => '24 Hours',
            'status' => 'active',
            'is_public' => true,
            'settings' => BoardingHouse::defaultSettings(),
        ]);
        $bh2->facilities()->attach([$facilityModels[0]->id, $facilityModels[1]->id, $facilityModels[2]->id, $facilityModels[5]->id]);

        // Seed Boarding House Rules
        $rules = [
            ['category' => 'General', 'title' => 'Menjaga Kebersihan', 'description' => 'Wajib menjaga kebersihan kamar dan fasilitas bersama.'],
            ['category' => 'Visitor', 'title' => 'Batas Tamu Berkunjung', 'description' => 'Tamu berkunjung maksimal hingga pukul 22.00 WIB.'],
            ['category' => 'Curfew', 'title' => 'Jam Malam', 'description' => 'Gerbang utama dikunci pukul 23.00 WIB. Hubungi penjaga jika terlambat.'],
            ['category' => 'Pet', 'title' => 'Larangan Hewan Peliharaan', 'description' => 'Tidak diperbolehkan membawa hewan peliharaan apa pun.'],
        ];
        foreach ($rules as $idx => $rData) {
            BoardingHouseRule::create(array_merge($rData, [
                'boarding_house_id' => $bh1->id,
                'display_order' => $idx + 1,
                'is_active' => true,
                'is_visible_public' => true,
            ]));
            BoardingHouseRule::create(array_merge($rData, [
                'boarding_house_id' => $bh2->id,
                'display_order' => $idx + 1,
                'is_active' => true,
                'is_visible_public' => true,
            ]));
        }

        // Seed Rooms for Boarding House 1 (Griya Cihampelas Indah)
        $roomsData = [
            ['num' => '101', 'type' => 'Standard', 'rent' => 1200000.00, 'floor' => 1, 'status' => 'occupied'],
            ['num' => '102', 'type' => 'Standard', 'rent' => 1200000.00, 'floor' => 1, 'status' => 'available'],
            ['num' => '103', 'type' => 'Deluxe', 'rent' => 1800000.00, 'floor' => 1, 'status' => 'occupied'],
            ['num' => '201', 'type' => 'Suite', 'rent' => 2500000.00, 'floor' => 2, 'status' => 'occupied'],
            ['num' => '202', 'type' => 'VIP', 'rent' => 3500000.00, 'floor' => 2, 'status' => 'available'],
        ];

        $rooms = [];
        foreach ($roomsData as $r) {
            $room = Room::create([
                'boarding_house_id' => $bh1->id,
                'room_number' => $r['num'],
                'room_name' => 'Kamar ' . $r['num'],
                'floor' => $r['floor'],
                'building_block' => 'Utama',
                'room_type' => $r['type'],
                'monthly_rent' => $r['rent'],
                'security_deposit' => 500000.00,
                'room_size' => $r['type'] === 'VIP' ? '4x5' : ($r['type'] === 'Suite' ? '4x4' : '3x4'),
                'max_occupants' => $r['type'] === 'VIP' ? 2 : 1,
                'gender_restriction' => 'any',
                'status' => $r['status'],
                'description' => "Kamar tipe {$r['type']} di Lantai {$r['floor']}.",
                'internal_notes' => 'Kondisi bagus siap huni.',
                'display_order' => intval($r['num']),
                'room_code' => 'RM-GC-' . $r['num'],
                'is_published' => true,
            ]);
            
            // Attach room facilities (AC & Private Bathroom for Standard, TV + Water heater for Deluxe, VIP, Suite)
            $facIds = [$facilityModels[0]->id, $facilityModels[2]->id]; // Wi-Fi & Private Bathroom
            if (in_array($r['type'], ['Deluxe', 'Suite', 'VIP'])) {
                $facIds[] = $facilityModels[1]->id; // AC
                $facIds[] = $facilityModels[3]->id; // TV
            }
            if (in_array($r['type'], ['Suite', 'VIP'])) {
                $facIds[] = $facilityModels[4]->id; // Water heater
            }
            $room->facilities()->attach($facIds);

            // Create room cover image
            RoomImage::create([
                'room_id' => $room->id,
                'file_path' => 'rooms/placeholder_' . strtolower($r['type']) . '.jpg',
                'label' => 'Kamar ' . $r['num'] . ' View',
                'is_cover' => true,
                'display_order' => 1,
            ]);

            $rooms[$r['num']] = $room;
        }

        // Seed Residents for Tenant 1
        // 1. Active Resident Budi Santoso (Linked to tenant@kosan.test)
        $resBudi = Resident::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['101']->id,
            'name' => 'Budi Santoso',
            'nik' => '3273012345670001',
            'gender' => 'male',
            'date_of_birth' => '1998-05-12',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Karyawan Swasta',
            'marital_status' => 'Belum Menikah',
            'religion' => 'Islam',
            'phone' => '081299991111',
            'whatsapp' => '081299991111',
            'email' => 'tenant@kosan.test', // matches the user account
            'emergency_name' => 'Slamet Santoso',
            'emergency_relationship' => 'Orang Tua',
            'emergency_phone' => '081299992222',
            'emergency_address' => 'Jl. Kenanga No. 4, Jakarta Barat',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'address' => 'Kosan Premium Cihampelas Kamar 101',
            'status' => ResidentStatus::ACTIVE,
            'check_in_date' => '2026-04-01',
            'move_in_time' => '14:00:00',
            'initial_meter_reading' => 120.50,
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Kamar bersih, kunci diserahkan.',
        ]);
        ResidentDocument::create([
            'resident_id' => $resBudi->id,
            'document_type' => 'KTP',
            'file_path' => 'documents/ktp_budi.pdf',
            'label' => 'KTP Terverifikasi',
        ]);
        ResidentTimeline::create([
            'resident_id' => $resBudi->id,
            'event' => 'registered',
            'title' => 'Pendaftaran Resident',
            'description' => 'Registrasi Budi Santoso berhasil dibuat.',
        ]);
        ResidentTimeline::create([
            'resident_id' => $resBudi->id,
            'event' => 'checked_in',
            'title' => 'Check In Kamar 101',
            'description' => 'Proses check-in selesai, kunci diserahkan.',
        ]);

        // 2. Active Resident Siti Rahma
        $resSiti = Resident::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['103']->id,
            'name' => 'Siti Rahma',
            'nik' => '3273012345670002',
            'gender' => 'female',
            'date_of_birth' => '2000-08-20',
            'place_of_birth' => 'Surabaya',
            'nationality' => 'WNI',
            'occupation' => 'Mahasiswa',
            'marital_status' => 'Belum Menikah',
            'religion' => 'Islam',
            'phone' => '081299993333',
            'whatsapp' => '081299993333',
            'email' => 'siti@gmail.com',
            'emergency_name' => 'Ahmad',
            'emergency_relationship' => 'Orang Tua',
            'emergency_phone' => '081299994444',
            'emergency_address' => 'Jl. Mawar No. 8, Surabaya',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'address' => 'Kosan Premium Cihampelas Kamar 103',
            'status' => ResidentStatus::ACTIVE,
            'check_in_date' => '2026-05-01',
            'move_in_time' => '13:00:00',
            'initial_meter_reading' => 85.00,
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Checked in successfully.',
        ]);
        ResidentDocument::create([
            'resident_id' => $resSiti->id,
            'document_type' => 'KTM',
            'file_path' => 'documents/ktm_siti.pdf',
            'label' => 'Kartu Tanda Mahasiswa ITB',
        ]);

        // 3. Late Payment Resident Joko Widodo
        $resJoko = Resident::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['201']->id,
            'name' => 'Joko Widodo',
            'nik' => '3273012345670003',
            'gender' => 'male',
            'date_of_birth' => '1995-10-10',
            'place_of_birth' => 'Solo',
            'nationality' => 'WNI',
            'occupation' => 'Wirausaha',
            'marital_status' => 'Menikah',
            'religion' => 'Islam',
            'phone' => '081299995555',
            'whatsapp' => '081299995555',
            'email' => 'joko@gmail.com',
            'emergency_name' => 'Iriana',
            'emergency_relationship' => 'Istri',
            'emergency_phone' => '081299996666',
            'emergency_address' => 'Jl. Kenari No. 12, Solo',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40131',
            'address' => 'Kosan Premium Cihampelas Kamar 201',
            'status' => ResidentStatus::LATE_PAYMENT,
            'check_in_date' => '2026-05-01',
            'move_in_time' => '10:00:00',
            'initial_meter_reading' => 210.00,
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Checked in.',
        ]);

        // 4. Former Resident Dewi Lestari
        $resDewi = Resident::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => null, // Checked out
            'name' => 'Dewi Lestari',
            'nik' => '3273012345670004',
            'gender' => 'female',
            'date_of_birth' => '1997-02-14',
            'place_of_birth' => 'Bandung',
            'nationality' => 'WNI',
            'occupation' => 'Freelancer',
            'marital_status' => 'Belum Menikah',
            'religion' => 'Katolik',
            'phone' => '081299997777',
            'whatsapp' => '081299997777',
            'email' => 'dewi@gmail.com',
            'emergency_name' => 'Lestari',
            'emergency_relationship' => 'Orang Tua',
            'emergency_phone' => '081299998888',
            'emergency_address' => 'Jl. Pasteur No. 44, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Pasteur',
            'postal_code' => '40161',
            'address' => 'Bandung',
            'status' => ResidentStatus::FORMER,
            'check_in_date' => '2026-01-01',
            'move_in_time' => '12:00:00',
            'initial_meter_reading' => 50.00,
            'security_deposit' => 500000.00,
            'check_in_notes' => 'Check in.',
            'check_out_date' => '2026-03-31',
            'final_meter_reading' => 195.00,
            'check_out_notes' => 'Check out selesai secara aman.',
        ]);

        // Seed Contracts for Tenant 1
        // Budi's Contract
        $conBudi = Contract::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['101']->id,
            'resident_id' => $resBudi->id,
            'contract_number' => 'CON-GC-101-01',
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-04-01',
            'end_date' => '2026-10-01',
            'move_in_date' => '2026-04-01',
            'duration_months' => 6,
            'auto_renewal' => true,
            'monthly_rent' => 1200000.00,
            'security_deposit' => 500000.00,
            'electricity_fee' => 0.00,
            'water_fee' => 0.00,
            'internet_fee' => 0.00,
            'parking_fee' => 0.00,
            'additional_charges' => 0.00,
            'discount' => 0.00,
            'internal_notes' => 'Kontrak sewa kamar standar 6 bulan.',
            'public_notes' => 'Sewa kamar standar terhitung sejak 1 April 2026.',
            'version' => 1,
        ]);
        ContractVersion::create([
            'contract_id' => $conBudi->id,
            'version_number' => 1,
            'previous_values' => ['monthly_rent' => 1200000.00, 'security_deposit' => 500000.00],
            'reason' => 'Initial Agreement',
            'created_by' => $owner1->id,
        ]);
        ContractTimeline::create([
            'contract_id' => $conBudi->id,
            'event' => 'created',
            'title' => 'Kontrak Dibuat',
            'description' => 'Perjanjian sewa baru diinput ke sistem.',
        ]);
        ContractTimeline::create([
            'contract_id' => $conBudi->id,
            'event' => 'signed',
            'title' => 'Kontrak Ditandatangani',
            'description' => 'Kedua belah pihak menandatangani kontrak sewa.',
        ]);

        // Siti's Contract
        $conSiti = Contract::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['103']->id,
            'resident_id' => $resSiti->id,
            'contract_number' => 'CON-GC-103-01',
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-05-01',
            'end_date' => '2026-11-01',
            'move_in_date' => '2026-05-01',
            'duration_months' => 6,
            'auto_renewal' => false,
            'monthly_rent' => 1800000.00,
            'security_deposit' => 500000.00,
            'electricity_fee' => 0.00,
            'water_fee' => 0.00,
            'internet_fee' => 0.00,
            'parking_fee' => 0.00,
            'additional_charges' => 0.00,
            'discount' => 0.00,
            'version' => 1,
        ]);

        // Joko's Contract
        $conJoko = Contract::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['201']->id,
            'resident_id' => $resJoko->id,
            'contract_number' => 'CON-GC-201-01',
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-05-01',
            'end_date' => '2026-11-01',
            'move_in_date' => '2026-05-01',
            'duration_months' => 6,
            'auto_renewal' => false,
            'monthly_rent' => 2500000.00,
            'security_deposit' => 500000.00,
            'electricity_fee' => 0.00,
            'water_fee' => 0.00,
            'internet_fee' => 0.00,
            'parking_fee' => 0.00,
            'additional_charges' => 0.00,
            'discount' => 0.00,
            'version' => 1,
        ]);

        // Dewi's Expired Contract
        $conDewi = Contract::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['101']->id,
            'resident_id' => $resDewi->id,
            'contract_number' => 'CON-GC-101-00',
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::COMPLETED,
            'start_date' => '2026-01-01',
            'end_date' => '2026-03-31',
            'move_in_date' => '2026-01-01',
            'move_out_date' => '2026-03-31',
            'duration_months' => 3,
            'auto_renewal' => false,
            'monthly_rent' => 1200000.00,
            'security_deposit' => 500000.00,
            'version' => 1,
        ]);

        // Seed Invoices and Payments for Tenant 1
        // 1. Invoices for Budi (April, May, June, July)
        $months = [
            ['month' => '04', 'status' => InvoiceStatus::PAID, 'paid' => true],
            ['month' => '05', 'status' => InvoiceStatus::PAID, 'paid' => true],
            ['month' => '06', 'status' => InvoiceStatus::PAID, 'paid' => true],
            ['month' => '07', 'status' => InvoiceStatus::PENDING, 'paid' => false],
        ];

        foreach ($months as $m) {
            $inv = Invoice::create([
                'tenant_id' => $tenant1->id,
                'boarding_house_id' => $bh1->id,
                'room_id' => $rooms['101']->id,
                'resident_id' => $resBudi->id,
                'contract_id' => $conBudi->id,
                'invoice_number' => "INV-GC-101-26{$m['month']}",
                'invoice_date' => "2026-{$m['month']}-01",
                'due_date' => "2026-{$m['month']}-05",
                'billing_period_start' => "2026-{$m['month']}-01",
                'billing_period_end' => "2026-{$m['month']}-" . ($m['month'] == '07' ? '31' : '30'),
                'subtotal' => 1200000.00,
                'discount' => 0.00,
                'penalty' => 0.00,
                'grand_total' => 1200000.00,
                'status' => $m['status'],
                'notes' => 'Tagihan sewa bulanan.',
            ]);

            InvoiceItem::create([
                'invoice_id' => $inv->id,
                'item_type' => InvoiceItemType::MONTHLY_RENT,
                'name' => 'Sewa Kamar 101',
                'amount' => 1200000.00,
            ]);

            InvoiceTimeline::create([
                'invoice_id' => $inv->id,
                'event' => 'created',
                'title' => 'Tagihan Diterbitkan',
                'description' => "Tagihan bulan {$m['month']} sukses diinput.",
            ]);

            if ($m['paid']) {
                $pay = Payment::create([
                    'tenant_id' => $tenant1->id,
                    'invoice_id' => $inv->id,
                    'contract_id' => $conBudi->id,
                    'resident_id' => $resBudi->id,
                    'boarding_house_id' => $bh1->id,
                    'transaction_number' => "TX-GC-101-26{$m['month']}",
                    'reference_number' => 'REF-BUDI-26' . $m['month'],
                    'payment_date' => "2026-{$m['month']}-03",
                    'payment_method' => PaymentMethod::BANK_TRANSFER,
                    'amount_paid' => 1200000.00,
                    'admin_fee' => 0.00,
                    'penalty_paid' => 0.00,
                    'notes' => 'Transfer ATM BNI.',
                    'proof_of_payment_path' => 'payments/proofs/budi_pay.jpg',
                    'status' => PaymentStatus::VERIFIED,
                    'verified_by' => $manager1->id,
                    'verified_at' => "2026-{$m['month']}-04 10:00:00",
                    'reconciliation_notes' => 'Rekonsiliasi bank kliring cocok.',
                ]);

                PaymentTimeline::create([
                    'payment_id' => $pay->id,
                    'event' => 'verified',
                    'title' => 'Pembayaran Diverifikasi',
                    'description' => 'Konfirmasi pembayaran sewa berhasil oleh Manager.',
                ]);
            } else {
                // July invoice: create a payment waiting verification
                $pay = Payment::create([
                    'tenant_id' => $tenant1->id,
                    'invoice_id' => $inv->id,
                    'contract_id' => $conBudi->id,
                    'resident_id' => $resBudi->id,
                    'boarding_house_id' => $bh1->id,
                    'transaction_number' => "TX-GC-101-26{$m['month']}",
                    'reference_number' => 'REF-BUDI-26' . $m['month'],
                    'payment_date' => "2026-{$m['month']}-03",
                    'payment_method' => PaymentMethod::QRIS,
                    'amount_paid' => 1200000.00,
                    'notes' => 'Bayar pakai QRIS ShopeePay.',
                    'proof_of_payment_path' => 'payments/proofs/budi_july.jpg',
                    'status' => PaymentStatus::WAITING_VERIFICATION,
                ]);

                PaymentTimeline::create([
                    'payment_id' => $pay->id,
                    'event' => 'waiting_verification',
                    'title' => 'Menunggu Verifikasi',
                    'description' => 'Bukti bayar diunggah resident, menunggu verifikasi staff.',
                ]);
            }
        }

        // Siti (Paid)
        $invSiti = Invoice::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['103']->id,
            'resident_id' => $resSiti->id,
            'contract_id' => $conSiti->id,
            'invoice_number' => 'INV-GC-103-2605',
            'invoice_date' => '2026-05-01',
            'due_date' => '2026-05-05',
            'billing_period_start' => '2026-05-01',
            'billing_period_end' => '2026-05-31',
            'subtotal' => 1800000.00,
            'grand_total' => 1800000.00,
            'status' => InvoiceStatus::PAID,
        ]);
        InvoiceItem::create([
            'invoice_id' => $invSiti->id,
            'item_type' => InvoiceItemType::MONTHLY_RENT,
            'name' => 'Sewa Kamar 103 (Deluxe)',
            'amount' => 1800000.00,
        ]);
        $paySiti = Payment::create([
            'tenant_id' => $tenant1->id,
            'invoice_id' => $invSiti->id,
            'contract_id' => $conSiti->id,
            'resident_id' => $resSiti->id,
            'boarding_house_id' => $bh1->id,
            'transaction_number' => 'TX-GC-103-2605',
            'payment_date' => '2026-05-02',
            'payment_method' => PaymentMethod::BANK_TRANSFER,
            'amount_paid' => 1800000.00,
            'status' => PaymentStatus::VERIFIED,
            'verified_by' => $staff1->id,
            'verified_at' => '2026-05-02 15:00:00',
        ]);

        // Joko (Overdue/Unpaid)
        $invJoko = Invoice::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['201']->id,
            'resident_id' => $resJoko->id,
            'contract_id' => $conJoko->id,
            'invoice_number' => 'INV-GC-201-2606',
            'invoice_date' => '2026-06-01',
            'due_date' => '2026-06-05',
            'billing_period_start' => '2026-06-01',
            'billing_period_end' => '2026-06-30',
            'subtotal' => 2500000.00,
            'grand_total' => 2500000.00,
            'status' => InvoiceStatus::OVERDUE,
            'notes' => 'Menunggu pelunasan.',
        ]);
        InvoiceItem::create([
            'invoice_id' => $invJoko->id,
            'item_type' => InvoiceItemType::MONTHLY_RENT,
            'name' => 'Sewa Kamar 201 (Suite)',
            'amount' => 2500000.00,
        ]);

        // Seed Complaints and Maintenance Tasks for Tenant 1
        // Budi AC Complaint (In Progress)
        $compBudi = Complaint::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['101']->id,
            'resident_id' => $resBudi->id,
            'complaint_number' => 'COM-GC-202607-01',
            'category' => 'ac',
            'priority' => ComplaintPriority::NORMAL,
            'status' => ComplaintStatus::IN_PROGRESS,
            'subject' => 'AC Kamar 101 Tidak Dingin',
            'description' => 'Sejak kemarin AC mengeluarkan udara panas. Mohon dibantu pengecekan freon.',
            'internal_notes' => 'Jadwalkan teknisi AC.',
            'is_tenant_visible' => true,
        ]);
        ComplaintComment::create([
            'complaint_id' => $compBudi->id,
            'comment' => 'Terima kasih, laporan Anda telah kami teruskan ke teknisi luar.',
            'is_tenant_visible' => true,
            'user_id' => $staff1->id,
        ]);
        ComplaintTimeline::create([
            'complaint_id' => $compBudi->id,
            'event' => 'created',
            'title' => 'Komplain Diajukan',
            'description' => 'Laporan kerusakan AC berhasil diinput.',
        ]);
        ComplaintTimeline::create([
            'complaint_id' => $compBudi->id,
            'event' => 'assigned',
            'title' => 'Mulai Penanganan',
            'description' => 'Teknisi AC dijadwalkan datang.',
        ]);

        // Maintenance Task for Budi's AC
        $mtask = MaintenanceTask::create([
            'tenant_id' => $tenant1->id,
            'complaint_id' => $compBudi->id,
            'task_number' => 'MTASK-GC-001',
            'assigned_staff_id' => $staff1->id,
            'assigned_at' => now(),
            'estimated_completion_date' => now()->addDays(2)->format('Y-m-d'),
            'cost' => 150000.00,
            'repair_notes' => 'Pembersihan AC dan tambah freon.',
        ]);
        MaintenanceChecklist::create([
            'maintenance_task_id' => $mtask->id,
            'item' => 'Cuci filter AC',
            'is_completed' => true,
        ]);
        MaintenanceChecklist::create([
            'maintenance_task_id' => $mtask->id,
            'item' => 'Isi ulang Freon R32',
            'is_completed' => false,
        ]);

        // Siti Bathroom Water Leak (Open)
        $compSiti = Complaint::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'room_id' => $rooms['103']->id,
            'resident_id' => $resSiti->id,
            'complaint_number' => 'COM-GC-202607-02',
            'category' => 'bathroom',
            'priority' => ComplaintPriority::HIGH,
            'status' => ComplaintStatus::OPEN,
            'subject' => 'Keran Air Shower Bocor',
            'description' => 'Keran shower air kamar mandi terus menetes walaupun sudah diputar kencang.',
            'is_tenant_visible' => true,
        ]);

        // Seed Announcements for Tenant 1
        $ann1 = Announcement::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'announcement_number' => 'ANN-GC-2026-01',
            'title' => 'Pemadaman Listrik Sementara',
            'summary' => 'Pemadaman listrik untuk perbaikan berkala oleh PLN pada hari Rabu ini.',
            'content' => 'Kepada seluruh resident, diinformasikan bahwa PLN akan melakukan pemeliharaan trafo gardu Cihampelas pada hari Rabu, 22 Juli 2026, mulai pukul 09.00 - 12.00 WIB. Aliran listrik kosan akan padam sementara selama durasi tersebut.',
            'category' => 'maintenance',
            'priority' => AnnouncementPriority::HIGH,
            'status' => AnnouncementStatus::PUBLISHED,
            'target_type' => 'all',
            'publish_at' => now(),
            'author_id' => $owner1->id,
        ]);
        // Seed Read Receipt
        AnnouncementReadReceipt::create([
            'announcement_id' => $ann1->id,
            'resident_id' => $resBudi->id,
            'read_at' => now(),
        ]);

        $ann2 = Announcement::create([
            'tenant_id' => $tenant1->id,
            'boarding_house_id' => $bh1->id,
            'announcement_number' => 'ANN-GC-2026-02',
            'title' => 'Penyemprotan Disinfektan Kamar',
            'summary' => 'Jadwal fogging nyamuk DBD dan disinfeksi mingguan.',
            'content' => 'Penyemprotan fogging nyamuk demam berdarah dan disinfektan kamar dilakukan Sabtu ini pukul 10:00 WIB. Harap rapikan barang berharga Anda.',
            'category' => 'cleaning',
            'priority' => AnnouncementPriority::NORMAL,
            'status' => AnnouncementStatus::PUBLISHED,
            'target_type' => 'all',
            'publish_at' => now(),
            'author_id' => $manager1->id,
        ]);

        // Seed Settings, InAppNotification, and SavedReport for Tenant 1
        Setting::create(['tenant_id' => $tenant1->id, 'key' => 'app_theme', 'value' => 'dark']);
        Setting::create(['tenant_id' => $tenant1->id, 'key' => 'allow_late_complaints', 'value' => 'true']);

        InAppNotification::create([
            'tenant_id' => $tenant1->id,
            'user_id' => $manager1->id,
            'type' => 'info',
            'data' => [
                'title' => 'Pembayaran Baru',
                'message' => 'Budi Santoso mengunggah bukti bayar untuk invoice Juli.',
            ],
        ]);

        SavedReport::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Pendapatan Q2 2026',
            'report_type' => 'financial',
            'filters' => ['period' => 'q2_2026'],
            'user_id' => $owner1->id,
        ]);


        // ==========================================
        // TENANT 2: Kost Asri Dago (Multi-tenancy isolation demo)
        // ==========================================
        $tenant2 = Tenant::create([
            'name' => 'Kost Asri Dago',
            'slug' => 'dago',
            'status' => \App\Enums\WorkspaceStatus::ACTIVE,
            'company_name' => 'Dago Property Ltd',
            'brand_name' => 'Kost Asri Dago',
            'subscription_plan_id' => '019f8390-2222-7398-84fa-13e83cfc1e46', // Professional Plan
            'subscription_status' => \App\Enums\SubscriptionStatus::ACTIVE,
            'subscription_ends_at' => now()->addDays(30),
            'next_billing_at' => now()->addDays(30),
            'settings' => [
                'timezone' => 'Asia/Jakarta',
                'currency' => 'IDR',
                'locale' => 'id',
            ],
        ]);

        // Testing Account for Tenant 2 (Owner)
        $owner2 = User::create([
            'name' => 'Gunawan (Owner Dago)',
            'email' => 'owner2@kosan.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
        ]);
        $owner2->tenants()->attach($tenant2->id, ['role_id' => $ownerRole->id, 'is_active' => true]);

        // Set context to Tenant 2
        tenant_manager()->setTenant($tenant2);

        // Seed Boarding House for Tenant 2
        $bhDago = BoardingHouse::create([
            'tenant_id' => $tenant2->id,
            'name' => 'Kost Asri Dago Hijau',
            'slug' => 'dago-hijau',
            'description' => 'Kost asri bernuansa alam di daerah Dago Atas Bandung.',
            'address' => 'Jl. Ir. H. Juanda No. 350',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'whatsapp_number' => '089988887777',
            'email' => 'dago@asri.test',
            'status' => 'active',
            'is_public' => true,
            'settings' => BoardingHouse::defaultSettings(),
        ]);
        $bhDago->facilities()->attach([$facilityModels[0]->id, $facilityModels[2]->id, $facilityModels[5]->id]);

        // Seed Rooms for Dago
        $roomDago1 = Room::create([
            'boarding_house_id' => $bhDago->id,
            'room_number' => '101',
            'room_name' => 'Kamar 101',
            'floor' => 1,
            'room_type' => 'Standard',
            'monthly_rent' => 1300000.00,
            'security_deposit' => 300000.00,
            'room_size' => '3x4',
            'status' => 'occupied',
            'room_code' => 'RM-DG-101',
            'is_published' => true,
        ]);

        // Seed Resident for Tenant 2
        $resDago = Resident::create([
            'tenant_id' => $tenant2->id,
            'boarding_house_id' => $bhDago->id,
            'room_id' => $roomDago1->id,
            'name' => 'Eko Prasetyo',
            'nik' => '3273012345670099',
            'gender' => 'male',
            'date_of_birth' => '1999-12-05',
            'place_of_birth' => 'Semarang',
            'nationality' => 'WNI',
            'occupation' => 'Mahasiswa ITB',
            'marital_status' => 'Belum Menikah',
            'religion' => 'Islam',
            'phone' => '087711112222',
            'whatsapp' => '087711112222',
            'email' => 'eko@gmail.com',
            'emergency_name' => 'Prasetyo',
            'emergency_relationship' => 'Orang Tua',
            'emergency_phone' => '087711113333',
            'emergency_address' => 'Semarang',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Dago',
            'status' => ResidentStatus::ACTIVE,
        ]);

        // Seed Contract for Tenant 2
        $conDago = Contract::create([
            'tenant_id' => $tenant2->id,
            'boarding_house_id' => $bhDago->id,
            'room_id' => $roomDago1->id,
            'resident_id' => $resDago->id,
            'contract_number' => 'CON-DG-101-01',
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-05-01',
            'end_date' => '2026-11-01',
            'move_in_date' => '2026-05-01',
            'duration_months' => 6,
            'monthly_rent' => 1300000.00,
            'security_deposit' => 300000.00,
            'version' => 1,
        ]);

        // Clear active Tenant context at the end of seeder run
        tenant_manager()->setTenant(null);
    }
}
