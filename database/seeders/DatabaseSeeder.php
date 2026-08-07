<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            SaasPlansSeeder::class,
            RolesAndPermissionsSeeder::class,
            CmsSeeder::class,
            FacilitiesSeeder::class,
            TenantsSeeder::class,
            UsersSeeder::class,
            BoardingHousesSeeder::class,
            RoomsSeeder::class,
            ResidentsSeeder::class,
            ContractsSeeder::class,
            InvoicesSeeder::class,
            PaymentsSeeder::class,
            ComplaintsSeeder::class,
            MaintenanceTasksSeeder::class,
            AnnouncementsSeeder::class,
            SystemSettingsAndLogsSeeder::class,
        ]);
    }
}
