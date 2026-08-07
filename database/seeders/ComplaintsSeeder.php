<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Resident;
use App\Models\User;
use App\Models\Complaint;
use App\Models\ComplaintComment;
use App\Models\ComplaintTimeline;
use App\Models\Tenant;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use Illuminate\Database\Seeder;

class ComplaintsSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        tenant_manager()->setTenant($tenant1);

        $bh1 = BoardingHouse::where('tenant_id', $tenant1->id)->where('slug', 'griya-cihampelas-indah')->first();

        $resBudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'penyewa@example.test')->first();
        $resSiti = Resident::where('tenant_id', $tenant1->id)->where('email', 'siti.aminah@example.test')->first();
        $resRudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'rudi.setiawan@example.test')->first();

        $staff1 = User::where('email', 'staff@example.test')->first();
        $staff2 = User::where('email', 'staff2@example.test')->first();

        // 1. Complaint 1: AC Rusak (In Progress)
        $comp1 = Complaint::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'complaint_number' => 'COM-GCI-202607-001'],
            [
                'boarding_house_id'=> $bh1->id,
                'room_id'          => $resBudi->room_id,
                'resident_id'      => $resBudi->id,
                'category'         => 'ac',
                'subject'          => 'AC Bocor & Kurang Dingin',
                'description'      => 'AC di kamar A-101 mengeluarkan bunyi bising dan air menetes dari indoor unit. AC juga terasa kurang dingin.',
                'priority'         => ComplaintPriority::NORMAL,
                'status'           => ComplaintStatus::IN_PROGRESS,
                'created_at'       => now()->subDays(5),
            ]
        );

        ComplaintTimeline::create([
            'complaint_id' => $comp1->id,
            'event'        => 'submitted',
            'title'        => 'Komplain Diajukan',
            'description'  => 'Komplain mengenai AC bocor telah diajukan oleh penghuni Budi Santoso.',
            'created_at'   => now()->subDays(5),
        ]);

        ComplaintTimeline::create([
            'complaint_id' => $comp1->id,
            'event'        => 'in_progress',
            'title'        => 'Status: Sedang Diproses',
            'description'  => 'Komplain sedang diproses dan teknisi eksternal sedang dijadwalkan.',
            'created_at'   => now()->subDays(4),
        ]);

        ComplaintComment::create([
            'complaint_id'      => $comp1->id,
            'user_id'           => $staff1?->id,
            'comment'           => 'Halo Mas Budi, laporan sudah kami terima. Staf teknisi kami akan berkunjung besok siang jam 13.00 WIB untuk melakukan service.',
            'is_tenant_visible' => true,
        ]);

        // 2. Complaint 2: Lampu Mati (Completed)
        $comp2 = Complaint::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'complaint_number' => 'COM-GCI-202607-002'],
            [
                'boarding_house_id'=> $bh1->id,
                'room_id'          => $resSiti->room_id,
                'resident_id'      => $resSiti->id,
                'category'         => 'electricity',
                'subject'          => 'Lampu Kamar Mandi Mati',
                'description'      => 'Lampu bohlam di kamar mandi mati tiba-tiba pagi ini.',
                'priority'         => ComplaintPriority::LOW,
                'status'           => ComplaintStatus::COMPLETED,
                'created_at'       => now()->subDays(2),
            ]
        );

        ComplaintTimeline::create([
            'complaint_id' => $comp2->id,
            'event'        => 'submitted',
            'title'        => 'Komplain Diajukan',
            'description'  => 'Laporan lampu mati diajukan oleh Siti Aminah.',
            'created_at'   => now()->subDays(2),
        ]);

        ComplaintTimeline::create([
            'complaint_id' => $comp2->id,
            'event'        => 'completed',
            'title'        => 'Komplain Selesai',
            'description'  => 'Lampu bohlam telah diganti dengan yang baru oleh Staf Sari.',
            'created_at'   => now()->subDay(),
        ]);

        // 3. Complaint 3: Kran Bocor (Open)
        $comp3 = Complaint::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'complaint_number' => 'COM-GCI-202607-003'],
            [
                'boarding_house_id'=> $bh1->id,
                'room_id'          => $resRudi->room_id,
                'resident_id'      => $resRudi->id,
                'category'         => 'plumbing',
                'subject'          => 'Kran Air Patah & Bocor Deras',
                'description'      => 'Kran wastafel patah saat diputar, air keluar deras tidak bisa ditutup. Mohon dibantu tutup valve utama segera.',
                'priority'         => ComplaintPriority::HIGH,
                'status'           => ComplaintStatus::OPEN,
                'created_at'       => now()->subHours(4),
            ]
        );

        ComplaintTimeline::create([
            'complaint_id' => $comp3->id,
            'event'        => 'submitted',
            'title'        => 'Komplain Darurat Diajukan',
            'description'  => 'Laporan kebocoran kran air diajukan secara darurat.',
            'created_at'   => now()->subHours(4),
        ]);

        tenant_manager()->setTenant(null);
    }
}
