<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TenantUser extends Pivot
{
    protected $table = 'tenant_user';

    protected static function booted(): void
    {
        static::saved(function ($pivot) {
            $user = User::find($pivot->user_id);
            $role = Role::find($pivot->role_id);

            if ($user && $role) {
                // Set Spatie permission team context
                setPermissionsTeamId($pivot->tenant_id);
                // Synchronize role using Spatie HasRoles trait method
                $user->syncRoles([$role->name]);
            }
        });

        static::deleted(function ($pivot) {
            $user = User::find($pivot->user_id);
            $role = Role::find($pivot->role_id);

            if ($user && $role) {
                // Set Spatie permission team context
                setPermissionsTeamId($pivot->tenant_id);
                // Remove role from Spatie
                $user->removeRole($role->name);
            }
        });
    }
}
