<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Invoice $invoice): bool
    {
        if (!tenant() || $invoice->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $invoice->resident_id === $res->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        if (!tenant()) {
            return false;
        }

        return $user->hasPermission('manage-payments');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        if (!tenant() || $invoice->tenant_id !== tenant()->id) {
            return false;
        }

        // Bypassed if invoice is paid or cancelled
        if (in_array($invoice->status->value, ['paid', 'cancelled', 'voided'])) {
            return false;
        }

        return $user->hasPermission('manage-payments');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        if (!tenant() || $invoice->tenant_id !== tenant()->id) {
            return false;
        }

        // Only draft or cancelled/voided invoices can be deleted
        return in_array($invoice->status->value, ['draft', 'cancelled', 'voided']) && $user->hasRole('owner');
    }
}
