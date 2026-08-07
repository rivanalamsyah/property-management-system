<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Tenant;
use App\Models\MaintenanceTask;
use App\Models\MaintenanceChecklist;
use Illuminate\Database\Seeder;

class MaintenanceTasksSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        tenant_manager()->setTenant($tenant1);

        $staff1  = User::where('email', 'staff@example.test')->first();
        $staff2  = User::where('email', 'staff2@example.test')->first();

        $comp1 = Complaint::where('tenant_id', $tenant1->id)->where('complaint_number', 'COM-GCI-202607-001')->first();
        $comp2 = Complaint::where('tenant_id', $tenant1->id)->where('complaint_number', 'COM-GCI-202607-002')->first();

        // Task 1: Perbaikan AC
        $maint1 = MaintenanceTask::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'complaint_id' => $comp1->id],
            [
                'task_number'              => 'MNT-GCI-2026-001',
                'assigned_staff_id'        => $staff1->id,
                'assigned_at'              => now()->subDays(1),
                'estimated_completion_date'=> now()->addDays(1)->format('Y-m-d'),
                'cost'                     => 250000.00,
                'repair_notes'             => 'Cuci AC filter dan isi ulang freon R32.',
            ]
        );
        MaintenanceChecklist::firstOrCreate(['maintenance_task_id' => $maint1->id, 'item' => 'Bersihkan filter indoor & kondensor outdoor'], ['is_completed' => true]);
        MaintenanceChecklist::firstOrCreate(['maintenance_task_id' => $maint1->id, 'item' => 'Cek kebocoran freon'], ['is_completed' => true]);
        MaintenanceChecklist::firstOrCreate(['maintenance_task_id' => $maint1->id, 'item' => 'Tambah freon R32 AC'], ['is_completed' => false]);

        // Task 2: Ganti Lampu Bohlam
        $maint2 = MaintenanceTask::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'complaint_id' => $comp2->id],
            [
                'task_number'              => 'MNT-GCI-2026-002',
                'assigned_staff_id'        => $staff2->id,
                'assigned_at'              => now()->subDays(2),
                'estimated_completion_date'=> now()->subDays(1)->format('Y-m-d'),
                'actual_completion_date'   => now()->subDays(1)->format('Y-m-d'),
                'cost'                     => 35000.00,
                'repair_notes'             => 'Ganti bohlam LED Philips 12W. Lampu baru menyala terang.',
            ]
        );
        MaintenanceChecklist::firstOrCreate(['maintenance_task_id' => $maint2->id, 'item' => 'Beli bohlam LED baru'], ['is_completed' => true]);
        MaintenanceChecklist::firstOrCreate(['maintenance_task_id' => $maint2->id, 'item' => 'Pasang bohlam di fitting plafon'], ['is_completed' => true]);

        tenant_manager()->setTenant(null);
    }
}
