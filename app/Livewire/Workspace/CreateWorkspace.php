<?php

namespace App\Livewire\Workspace;

use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateWorkspace extends Component
{
    public string $workspace_name = '';

    protected function rules(): array
    {
        return [
            'workspace_name' => ['required', 'string', 'max:255', 'min:3'],
        ];
    }

    public function createWorkspace(): void
    {
        $this->validate();

        $user = Auth::user();

        // Generate slug and create Tenant
        $slug = Str::slug($this->workspace_name);
        $originalSlug = $slug;
        $count = 1;
        while (Tenant::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $tenant = Tenant::create([
            'name' => $this->workspace_name,
            'slug' => $slug,
            'status' => \App\Enums\WorkspaceStatus::PENDING,
        ]);

        // Link User as Owner
        $ownerRole = Role::where('name', 'owner')->first();
        $user->tenants()->attach($tenant->id, [
            'role_id' => $ownerRole->id,
            'is_active' => true,
        ]);

        activity_log(
            event: 'tenant.create',
            description: "New workspace created: {$tenant->name} ({$tenant->slug})",
            userId: $user->id,
            tenantId: $tenant->id
        );

        session()->put('tenant_id', $tenant->id);

        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.workspace.create-workspace')
            ->layout('layouts.auth');
    }
}
