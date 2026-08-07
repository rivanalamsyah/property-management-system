<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Resident;
use App\Models\User;
use App\Models\Contract;
use App\Models\ContractVersion;
use App\Models\ContractTimeline;
use App\Models\Tenant;
use App\Enums\ContractType;
use App\Enums\ContractStatus;
use Illuminate\Database\Seeder;

class ContractsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        $owner = User::where('email', 'owner@example.test')->first();

        tenant_manager()->setTenant($tenant1);

        $resBudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'penyewa@example.test')->first();
        $resSiti = Resident::where('tenant_id', $tenant1->id)->where('email', 'siti.aminah@example.test')->first();
        $resRudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'rudi.setiawan@example.test')->first();

        // 1. Contract Budi
        $this->createContract(
            tenant: $tenant1,
            owner: $owner,
            resident: $resBudi,
            room: Room::find($resBudi->room_id),
            code: 'CTR-GCI-001',
            start: now()->subMonths(3)->startOfDay(),
            end: now()->addMonths(3)->endOfDay(),
            rent: 1200000,
            deposit: 600000
        );

        // 2. Contract Siti
        $this->createContract(
            tenant: $tenant1,
            owner: $owner,
            resident: $resSiti,
            room: Room::find($resSiti->room_id),
            code: 'CTR-GCI-002',
            start: now()->subMonths(1)->startOfDay(),
            end: now()->addMonths(5)->endOfDay(),
            rent: 1800000,
            deposit: 900000
        );

        // 3. Contract Rudi
        $this->createContract(
            tenant: $tenant1,
            owner: $owner,
            resident: $resRudi,
            room: Room::find($resRudi->room_id),
            code: 'CTR-GCI-003',
            start: now()->subMonths(6)->startOfDay(),
            end: now()->addMonths(6)->endOfDay(),
            rent: 2500000,
            deposit: 1250000
        );

        tenant_manager()->setTenant(null);
    }

    private function createContract($tenant, $owner, $resident, $room, $code, $start, $end, $rent, $deposit): void
    {
        $contract = Contract::firstOrCreate(
            ['tenant_id' => $tenant->id, 'contract_number' => $code],
            [
                'boarding_house_id' => $room->boarding_house_id,
                'room_id'           => $room->id,
                'resident_id'       => $resident->id,
                'contract_type'     => ContractType::MONTHLY,
                'status'            => ContractStatus::ACTIVE,
                'start_date'        => $start,
                'end_date'          => $end,
                'move_in_date'      => $start,
                'duration_months'   => 6,
                'monthly_rent'      => $rent,
                'security_deposit'  => $deposit,
                'auto_renewal'      => true,
            ]
        );

        ContractVersion::create([
            'contract_id'    => $contract->id,
            'version_number' => 1,
            'created_by'     => $owner->id,
        ]);

        ContractTimeline::create([
            'contract_id' => $contract->id,
            'event'       => 'created',
            'title'       => 'Kontrak Dibuat',
            'description' => "Kontrak sewa {$code} dibuat untuk kamar {$room->room_number}.",
            'created_at'  => $start,
        ]);

        ContractTimeline::create([
            'contract_id' => $contract->id,
            'event'       => 'approved',
            'title'       => 'Kontrak Ditandatangani',
            'description' => "Kontrak sewa {$code} ditandatangani oleh {$resident->name}.",
            'created_at'  => $start,
        ]);
    }
}
