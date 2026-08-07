<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Create permissions
        $permissions = [
            'manage-settings' => ['label' => 'Manage Settings', 'desc' => 'Allows editing tenant preferences and settings'],
            'manage-users' => ['label' => 'Manage Users', 'desc' => 'Allows inviting and managing users/staff'],
            'manage-rooms' => ['label' => 'Manage Rooms', 'desc' => 'Allows managing boarding house rooms and occupancy'],
            'manage-payments' => ['label' => 'Manage Payments', 'desc' => 'Allows managing rental payments and bills'],
            'manage-complaints' => ['label' => 'Manage Complaints', 'desc' => 'Allows managing complains and tenant feedback'],
            'view-dashboard' => ['label' => 'View Dashboard', 'desc' => 'Access to the workspace analytics and summary'],
        ];

        $permissionModels = [];
        foreach ($permissions as $name => $data) {
            $permissionModels[$name] = Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web'
            ], [
                'label' => $data['label'],
                'description' => $data['desc'],
            ]);
        }

        // 2. Create roles and assign permissions
        
        // Super Admin role
        $superAdmin = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ], [
            'label' => 'Super Admin',
            'description' => 'Platform Super Admin. Has full control over the SaaS platform, monitoring, and configurations.',
        ]);
        $superAdmin->permissions()->sync(array_values(array_map(fn($p) => $p->id, $permissionModels)));

        // Owner role (all permissions)
        $owner = Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'web'
        ], [
            'label' => 'Boarding House Owner',
            'description' => 'Owner of this boarding house. Has full control over the business data.',
        ]);
        $owner->permissions()->sync(array_values(array_map(fn($p) => $p->id, $permissionModels)));

        // Staff role
        $staff = Role::firstOrCreate([
            'name' => 'staff',
            'guard_name' => 'web'
        ], [
            'label' => 'Operational Staff',
            'description' => 'Handles day-to-day check-ins and payments.',
        ]);
        $staff->permissions()->sync([
            $permissionModels['view-dashboard']->id,
            $permissionModels['manage-rooms']->id,
            $permissionModels['manage-payments']->id,
            $permissionModels['manage-complaints']->id,
        ]);

        // Tenant (resident) role
        $tenant = Role::firstOrCreate([
            'name' => 'tenant',
            'guard_name' => 'web'
        ], [
            'label' => 'Resident (Tenant)',
            'description' => 'Resident of a room. Can view their own bills and raise complaints.',
        ]);
        $tenant->permissions()->sync([
            $permissionModels['view-dashboard']->id,
            $permissionModels['manage-complaints']->id,
        ]);
    }
}
