<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Contract $contract): bool
    {
        if (!tenant() || $contract->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $contract->resident_id === $res->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        if (!tenant()) {
            return false;
        }

        return $user->hasPermission('manage-rooms');
    }

    public function update(User $user, Contract $contract): bool
    {
        if (!tenant() || $contract->tenant_id !== tenant()->id) {
            return false;
        }

        // Bypassed if expired/completed
        if (in_array($contract->status->value, ['completed', 'cancelled', 'terminated'])) {
            return false;
        }

        return $user->hasPermission('manage-rooms');
    }

    public function delete(User $user, Contract $contract): bool
    {
        if (!tenant() || $contract->tenant_id !== tenant()->id) {
            return false;
        }

        // Only draft or cancelled contracts can be deleted
        return in_array($contract->status->value, ['draft', 'cancelled']) && $user->hasRole('owner');
    }
}
