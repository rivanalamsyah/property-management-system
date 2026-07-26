<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SaasPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'id' => '019f8390-1111-7398-84fa-13e83cfc1e46',
                'name' => 'Starter Plan',
                'slug' => 'starter',
                'description' => 'Ideal for single boarding house owners getting started.',
                'price_monthly' => 149000.00,
                'price_yearly' => 1490000.00,
                'max_rooms' => 5,
                'max_tenants' => 5,
                'max_staff' => 1,
                'max_branches' => 1,
                'storage_limit_mb' => 100,
                'max_upload_size_mb' => 2,
                'has_reports' => false,
                'has_analytics' => false,
                'has_resident_portal' => false,
                'has_maintenance' => false,
                'has_announcements' => true,
                'feature_flags' => json_encode([]),
                'is_active' => true,
            ],
            [
                'id' => '019f8390-2222-7398-84fa-13e83cfc1e46',
                'name' => 'Professional Plan',
                'slug' => 'professional',
                'description' => 'Great for standard properties with growing tenant counts.',
                'price_monthly' => 399000.00,
                'price_yearly' => 3990000.00,
                'max_rooms' => 20,
                'max_tenants' => 20,
                'max_staff' => 3,
                'max_branches' => 1,
                'storage_limit_mb' => 1000,
                'max_upload_size_mb' => 5,
                'has_reports' => true,
                'has_analytics' => false,
                'has_resident_portal' => true,
                'has_maintenance' => true,
                'has_announcements' => true,
                'feature_flags' => json_encode([]),
                'is_active' => true,
            ],
            [
                'id' => '019f8390-3333-7398-84fa-13e83cfc1e46',
                'name' => 'Business Plan',
                'slug' => 'business',
                'description' => 'Perfect for multi-location properties and scale operations.',
                'price_monthly' => 899000.00,
                'price_yearly' => 8990000.00,
                'max_rooms' => 100,
                'max_tenants' => 100,
                'max_staff' => 10,
                'max_branches' => 3,
                'storage_limit_mb' => 10000,
                'max_upload_size_mb' => 10,
                'has_reports' => true,
                'has_analytics' => true,
                'has_resident_portal' => true,
                'has_maintenance' => true,
                'has_announcements' => true,
                'feature_flags' => json_encode([]),
                'is_active' => true,
            ],
            [
                'id' => '019f8390-4444-7398-84fa-13e83cfc1e46',
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise',
                'description' => 'Premium tier with unlimited scaling capacity and white-labeling.',
                'price_monthly' => 1999000.00,
                'price_yearly' => 19990000.00,
                'max_rooms' => -1,
                'max_tenants' => -1,
                'max_staff' => -1,
                'max_branches' => -1,
                'storage_limit_mb' => 100000,
                'max_upload_size_mb' => 50,
                'has_reports' => true,
                'has_analytics' => true,
                'has_resident_portal' => true,
                'has_maintenance' => true,
                'has_announcements' => true,
                'feature_flags' => json_encode([
                    'white_label' => true,
                    'custom_domain' => true,
                    'beta_features' => true,
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(['id' => $plan['id']], $plan);
        }
    }
}
