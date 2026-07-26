<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTenantsAndPermissions
{
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'tenant_user')
            ->withPivot('role_id', 'is_active', 'joined_at')
            ->withTimestamps();
    }

    protected array $memoizedTenantRoles = [];

    public function tenantRole(Tenant $tenant = null): ?Role
    {
        $tenant = $tenant ?: (function_exists('tenant') ? tenant() : null);

        if (!$tenant) {
            return null;
        }

        if (array_key_exists($tenant->id, $this->memoizedTenantRoles)) {
            return $this->memoizedTenantRoles[$tenant->id];
        }

        // Cache or load the relation
        $pivot = $this->tenants()
            ->where('tenant_id', $tenant->id)
            ->where('is_active', true)
            ->first();

        if (!$pivot) {
            return $this->memoizedTenantRoles[$tenant->id] = null;
        }

        return $this->memoizedTenantRoles[$tenant->id] = Role::find($pivot->pivot->role_id);
    }

    public function hasRole(string $roleName, Tenant $tenant = null): bool
    {
        $role = $this->tenantRole($tenant);
        return $role ? $role->name === $roleName : false;
    }

    public function hasPermission(string $permissionName, Tenant $tenant = null): bool
    {
        $role = $this->tenantRole($tenant);
        if (!$role) {
            return false;
        }

        return $role->permissions()->where('name', $permissionName)->exists();
    }
}
