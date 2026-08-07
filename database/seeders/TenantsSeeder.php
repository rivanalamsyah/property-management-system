<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Enums\WorkspaceStatus;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Seeder;

class TenantsSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed exactly 1 Tenant representing the main Owner's business
        Tenant::firstOrCreate(
            ['slug' => 'cihampelas'],
            [
                'name'                  => 'Kosan Premium Cihampelas',
                'status'                => WorkspaceStatus::ACTIVE,
                'company_name'          => 'PT Cihampelas Manajemen Properti',
                'brand_name'            => 'Kosan Cihampelas',
                'subscription_plan_id'  => '019f8390-3333-7398-84fa-13e83cfc1e46', // Professional Plan
                'subscription_status'   => SubscriptionStatus::ACTIVE,
                'subscription_ends_at'  => now()->addDays(25),
                'next_billing_at'       => now()->addDays(25),
                'settings'              => ['timezone' => 'Asia/Jakarta', 'currency' => 'IDR', 'locale' => 'id'],
            ]
        );
    }
}
