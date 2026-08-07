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
            ->using(\App\Models\TenantUser::class)
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

        setPermissionsTeamId($tenant->id);
        $spatieRole = $this->roles()->first();
        
        if ($spatieRole) {
            return $this->memoizedTenantRoles[$tenant->id] = Role::find($spatieRole->id);
        }

        return $this->memoizedTenantRoles[$tenant->id] = null;
    }
}
