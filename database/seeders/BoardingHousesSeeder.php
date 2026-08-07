<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\BoardingHouseGallery;
use App\Models\BoardingHouseRule;
use App\Models\Facility;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BoardingHousesSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        $fac = Facility::orderBy('display_order')->get();

        tenant_manager()->setTenant($tenant1);

        $bh1 = BoardingHouse::firstOrCreate(
            ['tenant_id' => $tenant1->id, 'slug' => 'griya-cihampelas-indah'],
            [
                'name'            => 'Griya Cihampelas Indah',
                'description'     => 'Kost eksklusif dekat kampus ITB, Unpad, dan pusat perbelanjaan Cihampelas Walk. Dilengkapi keamanan 24 jam dan sistem CCTV terpadu.',
                'address'         => 'Jl. Cihampelas No. 120, Coblong',
                'province'        => 'Jawa Barat',
                'city'            => 'Bandung',
                'district'        => 'Coblong',
                'postal_code'     => '40131',
                'latitude'        => -6.8925,
                'longitude'       => 107.6038,
                'whatsapp_number' => '081234567890',
                'email'           => 'griya@cihampelas.test',
                'operating_hours' => '24 Jam',
                'status'          => 'active',
                'is_public'       => true,
                'settings'        => BoardingHouse::defaultSettings(),
            ]
        );

        // Sync first few facilities
        $bh1->facilities()->sync($fac->pluck('id')->take(6)->toArray());

        // Create standard public gallery items
        BoardingHouseGallery::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'file_path' => 'galleries/bh1_facade.jpg'],
            ['label' => 'Tampak Depan Griya Cihampelas', 'display_order' => 1, 'is_cover' => true]
        );
        BoardingHouseGallery::firstOrCreate(
            ['boarding_house_id' => $bh1->id, 'file_path' => 'galleries/bh1_lobby.jpg'],
            ['label' => 'Lobby dan Ruang Tunggu', 'display_order' => 2, 'is_cover' => false]
        );

        // Seed house rules
        $this->seedBHRules($bh1->id, [
            ['General',  'Menjaga Kebersihan',       'Wajib menjaga kebersihan kamar dan area bersama. Dilarang membuang sampah sembarangan.'],
            ['Visitor',  'Batas Jam Kunjungan Tamu', 'Tamu berkunjung maksimal hingga pukul 22.00 WIB. Tamu lawan jenis dilarang masuk kamar.'],
            ['Security', 'Kunci Gerbang Malam',      'Gerbang ditutup pukul 23.00 WIB. Jika pulang terlambat harap konfirmasi ke staf penjaga.'],
        ]);

        tenant_manager()->setTenant(null);
    }

    private function seedBHRules(string $bhId, array $rules): void
    {
        foreach ($rules as $idx => [$category, $title, $description]) {
            BoardingHouseRule::updateOrCreate(
                ['boarding_house_id' => $bhId, 'title' => $title],
                [
                    'category'          => $category,
                    'description'       => $description,
                    'display_order'     => $idx + 1,
                    'is_active'         => true,
                    'is_visible_public' => true,
                ]
            );
        }
    }
}
