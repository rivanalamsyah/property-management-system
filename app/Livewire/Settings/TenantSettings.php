<?php

namespace App\Livewire\Settings;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class TenantSettings extends Component
{
    public string $tenant_name = '';
    public string $tenant_slug = '';
    public string $status = 'active';

    public function mount(): void
    {
        $tenant = tenant();

        if ($tenant) {
            $this->tenant_name = $tenant->name;
            $this->tenant_slug = $tenant->slug;
            $this->status = $tenant->status->value;
        }

        // Policy checks: only users with manage-settings permission can access
        if (!Auth::user()->can('manage-settings')) {
            abort(403, 'Unauthorized.');
        }
    }

    public function updateSettings(): void
    {
        if (!Auth::user()->can('manage-settings')) {
            abort(403, 'Unauthorized.');
        }

        $tenant = tenant();

        $this->validate([
            'tenant_name' => ['required', 'string', 'max:255'],
            'tenant_slug' => ['required', 'string', 'max:255', 'unique:tenants,slug,' . $tenant->id],
        ]);

        $slug = Str::slug($this->tenant_slug);

        $tenant->update([
            'name' => $this->tenant_name,
            'slug' => $slug,
        ]);

        activity_log(
            event: 'tenant.update',
            description: "Updated workspace settings: {$tenant->name}"
        );

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Workspace settings updated successfully!',
        ]);
    }

    public function render()
    {
        return view('livewire.settings.tenant-settings')
            ->layout('layouts.app');
    }
}
