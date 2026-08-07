<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Resident;
use App\Models\ResidentDocument;
use App\Models\ResidentTimeline;
use App\Models\Tenant;
use App\Enums\ResidentStatus;
use Illuminate\Database\Seeder;

class ResidentsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        tenant_manager()->setTenant($tenant1);

        $bh1 = BoardingHouse::where('tenant_id', $tenant1->id)->where('slug', 'griya-cihampelas-indah')->first();

        $roomA101 = Room::where('boarding_house_id', $bh1->id)->where('room_number', 'A-101')->first();
        $roomA103 = Room::where('boarding_house_id', $bh1->id)->where('room_number', 'A-103')->first();
        $roomB201 = Room::where('boarding_house_id', $bh1->id)->where('room_number', 'B-201')->first();

        // 1. Budi Santoso (Linked to user penyewa@example.test)
        $resBudi = Resident::firstOrCreate(
            ['tenant_id' => $tenant1->id, 'email' => 'penyewa@example.test'],
            [
                'boarding_house_id'      => $bh1->id,
                'room_id'                => $roomA101->id,
                'name'                   => 'Budi Santoso',
                'nik'                    => '3273011205980001',
                'gender'                 => 'male',
                'date_of_birth'          => '1998-05-12',
                'place_of_birth'         => 'Jakarta',
                'nationality'            => 'WNI',
                'occupation'             => 'Software Engineer',
                'marital_status'         => 'Belum Menikah',
                'religion'               => 'Islam',
                'phone'                  => '081299991111',
                'whatsapp'               => '081299991111',
                'emergency_name'         => 'Subagyo',
                'emergency_relationship' => 'Ayah',
                'emergency_phone'        => '081299992222',
                'emergency_address'      => 'Jl. Raya Jakarta No. 45',
                'province'               => 'Jawa Barat',
                'city'                   => 'Bandung',
                'district'               => 'Coblong',
                'postal_code'            => '40131',
                'address'                => 'Jl. Cihampelas No. 120, Bandung',
                'status'                 => ResidentStatus::ACTIVE,
                'check_in_date'          => now()->subMonths(3),
            ]
        );

        ResidentDocument::firstOrCreate(
            ['resident_id' => $resBudi->id, 'document_type' => 'KTP'],
            [
                'file_path'      => 'documents/ktp_budi.pdf',
                'label'          => 'Foto KTP Budi',
            ]
        );

        ResidentTimeline::create([
            'resident_id' => $resBudi->id,
            'event'       => 'check_in',
            'title'       => 'Check-in Kamar A-101',
            'description' => 'Penghuni Budi Santoso check-in ke Kamar A-101.',
            'created_at'  => now()->subMonths(3),
        ]);

        // 2. Siti Aminah
        $resSiti = Resident::firstOrCreate(
            ['tenant_id' => $tenant1->id, 'email' => 'siti.aminah@example.test'],
            [
                'boarding_house_id'      => $bh1->id,
                'room_id'                => $roomA103->id,
                'name'                   => 'Siti Aminah',
                'nik'                    => '3273012207990002',
                'gender'                 => 'female',
                'date_of_birth'          => '1999-07-22',
                'place_of_birth'         => 'Bandung',
                'nationality'            => 'WNI',
                'occupation'             => 'Mahasiswi ITB',
                'marital_status'         => 'Belum Menikah',
                'religion'               => 'Islam',
                'phone'                  => '081299993333',
                'whatsapp'               => '081299993333',
                'emergency_name'         => 'Siti Rahma',
                'emergency_relationship' => 'Ibu',
                'emergency_phone'        => '081299994444',
                'emergency_address'      => 'Jl. Setiabudi No. 12, Bandung',
                'province'               => 'Jawa Barat',
                'city'                   => 'Bandung',
                'district'               => 'Coblong',
                'postal_code'            => '40131',
                'address'                => 'Jl. Dago No. 15, Bandung',
                'status'                 => ResidentStatus::ACTIVE,
                'check_in_date'          => now()->subMonths(1),
            ]
        );

        ResidentDocument::firstOrCreate(
            ['resident_id' => $resSiti->id, 'document_type' => 'KTP'],
            [
                'file_path'      => 'documents/ktp_siti.pdf',
                'label'          => 'Foto KTP Siti',
            ]
        );

        ResidentTimeline::create([
            'resident_id' => $resSiti->id,
            'event'       => 'check_in',
            'title'       => 'Check-in Kamar A-103',
            'description' => 'Penghuni Siti Aminah check-in ke Kamar A-103.',
            'created_at'  => now()->subMonths(1),
        ]);

        // 3. Rudi Setiawan
        $resRudi = Resident::firstOrCreate(
            ['tenant_id' => $tenant1->id, 'email' => 'rudi.setiawan@example.test'],
            [
                'boarding_house_id'      => $bh1->id,
                'room_id'                => $roomB201->id,
                'name'                   => 'Rudi Setiawan',
                'nik'                    => '3273010509950003',
                'gender'                 => 'male',
                'date_of_birth'          => '1995-09-05',
                'place_of_birth'         => 'Surabaya',
                'nationality'            => 'WNI',
                'occupation'             => 'Banker',
                'marital_status'         => 'Belum Menikah',
                'religion'               => 'Kristen',
                'phone'                  => '081299995555',
                'whatsapp'               => '081299995555',
                'emergency_name'         => 'Gunawan',
                'emergency_relationship' => 'Paman',
                'emergency_phone'        => '081299996666',
                'emergency_address'      => 'Jl. Gubeng No. 10, Surabaya',
                'province'               => 'Jawa Barat',
                'city'                   => 'Bandung',
                'district'               => 'Coblong',
                'postal_code'            => '40131',
                'address'                => 'Jl. Cihampelas No. 120, Bandung',
                'status'                 => ResidentStatus::ACTIVE,
                'check_in_date'          => now()->subMonths(6),
            ]
        );

        ResidentDocument::firstOrCreate(
            ['resident_id' => $resRudi->id, 'document_type' => 'KTP'],
            [
                'file_path'      => 'documents/ktp_rudi.pdf',
                'label'          => 'Foto KTP Rudi',
            ]
        );

        ResidentTimeline::create([
            'resident_id' => $resRudi->id,
            'event'       => 'check_in',
            'title'       => 'Check-in Kamar B-201',
            'description' => 'Penghuni Rudi Setiawan check-in ke Kamar B-201.',
            'created_at'  => now()->subMonths(6),
        ]);

        tenant_manager()->setTenant(null);
    }
}
