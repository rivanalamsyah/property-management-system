<?php

use App\Models\Setting;
use App\Models\ActivityLog;
use App\Services\TenantManager;

if (!function_exists('tenant_manager')) {
    function tenant_manager(): TenantManager
    {
        return app(TenantManager::class);
    }
}

if (!function_exists('tenant')) {
    function tenant(): ?\App\Models\Tenant
    {
        return tenant_manager()->getTenant();
    }
}

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null, mixed $tenantId = null): mixed
    {
        // If tenantId is not provided, try to resolve from active tenant
        if ($tenantId === null && tenant()) {
            $tenantId = tenant()->id;
        }

        // Try to fetch tenant specific setting first
        if ($tenantId) {
            $tenantSetting = Setting::where('tenant_id', $tenantId)
                ->where('key', $key)
                ->first();
            
            if ($tenantSetting !== null) {
                return $tenantSetting->value;
            }
        }

        // Fallback to global setting (tenant_id is null)
        $globalSetting = Setting::whereNull('tenant_id')
            ->where('key', $key)
            ->first();

        return $globalSetting !== null ? $globalSetting->value : $default;
    }
}

if (!function_exists('activity_log')) {
    function activity_log(string $event, string $description, array $properties = [], ?string $tenantId = null, ?int $userId = null): ActivityLog
    {
        if ($tenantId === null && tenant()) {
            $tenantId = tenant()->id;
        }

        if ($userId === null && auth()->check()) {
            $userId = auth()->id();
        }

        return ActivityLog::create([
            'tenant_id' => $tenantId,
            'user_id' => $userId,
            'event' => $event,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

if (!function_exists('setPermissionsTeamId')) {
    function setPermissionsTeamId(mixed $tenantId): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($tenantId);
    }
}
