<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $ownerRole      = Role::where('name', 'owner')->first();
        $staffRole      = Role::where('name', 'staff')->first();
        $tenantRole     = Role::where('name', 'tenant')->first();

        // 1. Super Admin (exactly 1 account)
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.test'],
            [
                'name'              => 'Super Admin Kosan',
                'password'          => Hash::make('Sup3rAdm!n#2026'),
                'email_verified_at' => now(),
                'timezone'          => 'Asia/Jakarta',
                'locale'            => 'id',
            ]
        );

        $tenant = Tenant::where('slug', 'cihampelas')->first();

        // 2. Owner (exactly 1 account)
        $owner = User::firstOrCreate(
            ['email' => 'owner@example.test'],
            [
                'name'              => 'Rivan Alamsyah (Owner)',
                'password'          => Hash::make('Own3r#Kosan2026!'),
                'email_verified_at' => now(),
                'timezone'          => 'Asia/Jakarta',
                'locale'            => 'id',
            ]
        );
        if (!$owner->tenants()->where('tenant_id', $tenant->id)->exists()) {
            $owner->tenants()->attach($tenant->id, ['role_id' => $ownerRole->id, 'is_active' => true]);
        }

        // 3. Staff 1 (exactly 2 staff under owner)
        $staff1 = User::firstOrCreate(
            ['email' => 'staff@example.test'],
            [
                'name'              => 'Andi Wijaya (Staff 1)',
                'password'          => Hash::make('St4ff!Kosan#2026'),
                'email_verified_at' => now(),
                'timezone'          => 'Asia/Jakarta',
                'locale'            => 'id',
            ]
        );
        if (!$staff1->tenants()->where('tenant_id', $tenant->id)->exists()) {
            $staff1->tenants()->attach($tenant->id, ['role_id' => $staffRole->id, 'is_active' => true]);
        }

        // 4. Staff 2
        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@example.test'],
            [
                'name'              => 'Sari Dewi (Staff 2)',
                'password'          => Hash::make('St4ff2!Kosan#2026'),
                'email_verified_at' => now(),
                'timezone'          => 'Asia/Jakarta',
                'locale'            => 'id',
            ]
        );
        if (!$staff2->tenants()->where('tenant_id', $tenant->id)->exists()) {
            $staff2->tenants()->attach($tenant->id, ['role_id' => $staffRole->id, 'is_active' => true]);
        }

        // 5. Penyewa User (linked to the main resident)
        $penyewa = User::firstOrCreate(
            ['email' => 'penyewa@example.test'],
            [
                'name'              => 'Budi Santoso (Penyewa)',
                'password'          => Hash::make('P3ny3wa!2026#'),
                'email_verified_at' => now(),
                'timezone'          => 'Asia/Jakarta',
                'locale'            => 'id',
            ]
        );
        if (!$penyewa->tenants()->where('tenant_id', $tenant->id)->exists()) {
            $penyewa->tenants()->attach($tenant->id, ['role_id' => $tenantRole->id, 'is_active' => true]);
        }
    }
}
