<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Resident;
use App\Models\User;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\Tenant;
use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementStatus;
use Illuminate\Database\Seeder;

class AnnouncementsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        $owner = User::where('email', 'owner@example.test')->first();

        tenant_manager()->setTenant($tenant1);

        $bh1 = BoardingHouse::where('tenant_id', $tenant1->id)->where('slug', 'griya-cihampelas-indah')->first();

        $resBudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'penyewa@example.test')->first();
        $resSiti = Resident::where('tenant_id', $tenant1->id)->where('email', 'siti.aminah@example.test')->first();
        $resRudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'rudi.setiawan@example.test')->first();

        // 1. ANN-GCI-2026-001
        $ann1 = Announcement::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'announcement_number' => 'ANN-GCI-2026-001'],
            [
                'boarding_house_id'  => $bh1->id,
                'title'              => 'Pemeliharaan PLN & Pemadaman Listrik Sementara',
                'summary'            => 'Pemadaman aliran listrik sementara oleh PLN pada hari Rabu pukul 09:00-12:00 WIB.',
                'content'            => 'Diberitahukan kepada seluruh penghuni Griya Cihampelas Indah, bahwa PLN Rayon Coblong akan melakukan pemeliharaan gardu distribusi listrik pada hari Rabu. Aliran listrik di kosan akan padam sementara mulai pukul 09:00 WIB hingga 12:00 WIB. Mohon persiapkan kebutuhan elektronik Anda masing-masing.',
                'category'           => 'maintenance',
                'priority'           => AnnouncementPriority::HIGH,
                'status'             => AnnouncementStatus::PUBLISHED,
                'target_type'        => 'boarding_house',
                'publish_at'         => now()->subDays(1),
                'author_id'          => $owner?->id,
                'pinned_at'          => now()->subDays(1),
            ]
        );

        if ($resBudi) {
            AnnouncementReadReceipt::firstOrCreate(['announcement_id' => $ann1->id, 'resident_id' => $resBudi->id], ['read_at' => now()->subHours(3)]);
        }
        if ($resSiti) {
            AnnouncementReadReceipt::firstOrCreate(['announcement_id' => $ann1->id, 'resident_id' => $resSiti->id], ['read_at' => now()->subHours(2)]);
        }
        if ($resRudi) {
            AnnouncementReadReceipt::firstOrCreate(['announcement_id' => $ann1->id, 'resident_id' => $resRudi->id], ['read_at' => now()->subHours(1)]);
        }

        tenant_manager()->setTenant(null);
    }
}
