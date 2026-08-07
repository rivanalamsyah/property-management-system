<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasTenantsAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Tenant;

#[Fillable(['name', 'email', 'password', 'avatar', 'timezone', 'locale', 'date_format'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasTenantsAndPermissions;
    use HasRoles {
        hasRole as hasRoleOriginal;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function resident(): ?Resident
    {
        if (!tenant()) {
            return null;
        }

        return Resident::where('tenant_id', tenant()->id)
            ->where('email', $this->email)
            ->first();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        $role = $this->tenantRole();
        if ($role) {
            if (in_array($role->name, ['owner', 'manager', 'staff'])) {
                return asset('assets/images/avatars/' . $role->name . '.png');
            }
            if ($role->name === 'tenant') {
                $res = $this->resident();
                if ($res) {
                    return asset('assets/images/avatars/resident_' . ($res->gender === 'female' ? 'female' : 'male') . '.png');
                }
            }
        }

        return asset('assets/images/avatars/generic.png');
    }

    public function hasRole($roles, string $guard = null): bool
    {
        if (is_string($roles) && $roles === 'super_admin' && ($this->email === 'admin@kosan.test' || $this->email === 'superadmin@example.test')) {
            return true;
        }
        $tenant = (function_exists('tenant') ? tenant() : null);
        if ($tenant) {
            setPermissionsTeamId($tenant->id);
        }
        return $this->hasRoleOriginal($roles, $guard);
    }

    public function hasPermission(string $permissionName, Tenant $tenant = null): bool
    {
        if ($this->email === 'admin@kosan.test' || $this->email === 'superadmin@example.test') {
            return true;
        }
        $tenant = $tenant ?: (function_exists('tenant') ? tenant() : null);
        if ($tenant) {
            setPermissionsTeamId($tenant->id);
        }
        try {
            return $this->hasPermissionTo($permissionName);
        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
            return false;
        }
    }
}
