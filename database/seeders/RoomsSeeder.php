<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\Facility;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        $fac = Facility::orderBy('display_order')->get()->all();

        tenant_manager()->setTenant($tenant1);
        $bh1 = BoardingHouse::where('tenant_id', $tenant1->id)->where('slug', 'griya-cihampelas-indah')->first();

        // 6 distinct rooms for development and verification
        $roomsBH1Data = [
            ['num' => 'A-101', 'type' => 'Standard', 'rent' => 1200000, 'dep' => 600000,  'floor' => 1, 'status' => 'occupied',    'size' => '3x4', 'max' => 1, 'gender' => 'any'],
            ['num' => 'A-102', 'type' => 'Standard', 'rent' => 1200000, 'dep' => 600000,  'floor' => 1, 'status' => 'available',   'size' => '3x4', 'max' => 1, 'gender' => 'any'],
            ['num' => 'A-103', 'type' => 'Deluxe',   'rent' => 1800000, 'dep' => 900000,  'floor' => 1, 'status' => 'occupied',    'size' => '3x5', 'max' => 1, 'gender' => 'female'],
            ['num' => 'B-201', 'type' => 'Suite',    'rent' => 2500000, 'dep' => 1250000, 'floor' => 2, 'status' => 'occupied',    'size' => '4x4', 'max' => 2, 'gender' => 'any'],
            ['num' => 'B-202', 'type' => 'Suite',    'rent' => 2500000, 'dep' => 1250000, 'floor' => 2, 'status' => 'available',   'size' => '4x4', 'max' => 2, 'gender' => 'any'],
            ['num' => 'B-203', 'type' => 'Deluxe',   'rent' => 1800000, 'dep' => 900000,  'floor' => 2, 'status' => 'available',   'size' => '3x5', 'max' => 1, 'gender' => 'any'],
        ];

        $this->seedRooms($bh1->id, $roomsBH1Data, 'GCI', $fac);

        tenant_manager()->setTenant(null);
    }

    private function seedRooms(string $bhId, array $data, string $prefix, array $fac): array
    {
        $rooms = [];
        foreach ($data as $r) {
            $room = Room::updateOrCreate(
                ['boarding_house_id' => $bhId, 'room_number' => $r['num']],
                [
                    'room_name'         => 'Kamar ' . $r['num'],
                    'floor'             => $r['floor'],
                    'building_block'    => substr($r['num'], 0, strpos($r['num'], '-') !== false ? strpos($r['num'], '-') : strlen($r['num'])),
                    'room_type'         => $r['type'],
                    'monthly_rent'      => $r['rent'],
                    'security_deposit'  => $r['dep'],
                    'room_size'         => $r['size'],
                    'max_occupants'     => $r['max'],
                    'gender_restriction'=> $r['gender'],
                    'status'            => $r['status'],
                    'description'       => "Kamar tipe {$r['type']} di lantai {$r['floor']}. Bersih, nyaman, dan siap huni.",
                    'internal_notes'    => 'Kondisi baik, telah melalui pengecekan berkala.',
                    'display_order'     => $r['floor'] * 100 + intval(preg_replace('/\D/', '', $r['num'])),
                    'room_code'         => 'RM-' . $prefix . '-' . str_replace('-', '', $r['num']),
                    'is_published'      => true,
                ]
            );

            // Assign standard facilities
            $facIds = [$fac[0]->id, $fac[2]->id]; // WiFi + Kamar Mandi Dalam
            if (in_array($r['type'], ['Deluxe', 'Suite'])) {
                $facIds[] = $fac[1]->id; // AC
                $facIds[] = $fac[3]->id; // TV
            }
            $room->facilities()->sync(array_unique($facIds));

            RoomImage::updateOrCreate(
                ['room_id' => $room->id, 'is_cover' => true],
                [
                    'file_path'     => 'rooms/placeholder_' . strtolower(str_replace(' ', '_', $r['type'])) . '.jpg',
                    'label'         => 'Kamar ' . $r['num'] . ' - View Utama',
                    'display_order' => 1,
                ]
            );

            $rooms[$r['num']] = $room;
        }
        return $rooms;
    }
}
