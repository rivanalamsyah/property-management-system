<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Payment $payment): bool
    {
        if (!tenant() || $payment->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $payment->resident_id === $res->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return tenant() !== null;
    }

    public function update(User $user, Payment $payment): bool
    {
        if (!tenant() || $payment->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-payments');
    }

    public function verify(User $user, Payment $payment): bool
    {
        if (!tenant() || $payment->tenant_id !== tenant()->id) {
            return false;
        }

        // Only verified by owners or staff with management permissions
        return $user->hasPermission('manage-payments');
    }

    public function delete(User $user, Payment $payment): bool
    {
        return false; // Financial records can never be deleted!
    }
}
