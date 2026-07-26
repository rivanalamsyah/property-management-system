<?php

namespace App\Services\SaaS;

use App\Models\Tenant;
use App\Models\Room;
use App\Models\Resident;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Complaint;
use App\Models\Announcement;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UsageTracker
{
    /**
     * Get usage metrics for a workspace.
     */
    public function getUsage(Tenant $tenant): array
    {
        $tenantId = $tenant->id;

        // Fetch staff role IDs
        $staffRoleIds = Role::whereIn('name', ['manager', 'staff'])->pluck('id')->toArray();
        $staffCount = User::whereHas('tenants', function ($query) use ($tenantId, $staffRoleIds) {
            $query->where('tenant_id', $tenantId)
                  ->whereIn('role_id', $staffRoleIds);
        })->count();

        // Calculate storage size of uploads folder
        $storageUsedMb = $this->getStorageUsedMb($tenantId);

        return [
            'rooms' => Room::whereHas('boardingHouse', function ($q) use ($tenantId) {
                $q->where('tenant_id', $tenantId);
            })->count(),
            'residents' => Resident::where('tenant_id', $tenantId)->count(),
            'staff' => $staffCount,
            'branches' => $tenant->users()->count(), // simplified branch check (number of linked workspaces)
            'storage' => $storageUsedMb,
            'contracts' => Contract::where('tenant_id', $tenantId)->count(),
            'invoices' => Invoice::where('tenant_id', $tenantId)->count(),
            'payments' => Payment::where('tenant_id', $tenantId)->count(),
            'announcements' => Announcement::where('tenant_id', $tenantId)->count(),
            'complaints' => Complaint::where('tenant_id', $tenantId)->count(),
        ];
    }

    /**
     * Get storage size used by a workspace in Megabytes.
     */
    public function getStorageUsedMb(string $tenantId): float
    {
        $path = storage_path('app/public/' . $tenantId);

        if (!File::exists($path)) {
            return 0.0;
        }

        $sizeBytes = 0;
        foreach (File::allFiles($path) as $file) {
            $sizeBytes += $file->getSize();
        }

        return round($sizeBytes / 1024 / 1024, 2);
    }
}
