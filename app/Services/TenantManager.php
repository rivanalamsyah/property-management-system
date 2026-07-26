<?php

namespace App\Services;

use App\Models\Tenant;

class TenantManager
{
    protected ?Tenant $currentTenant = null;

    public function setTenant(?Tenant $tenant): void
    {
        $this->currentTenant = $tenant;
    }

    public function getTenant(): ?Tenant
    {
        return $this->currentTenant;
    }

    public function hasTenant(): bool
    {
        return !is_null($this->currentTenant);
    }
}
