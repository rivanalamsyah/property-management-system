<?php

namespace App\Livewire\Auth;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $workspace_name = '';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirect(route('dashboard'));
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'workspace_name' => ['required', 'string', 'max:255', 'min:3'],
        ];
    }

    public function register(): void
    {
        $this->validate();

        $throttleKey = 'register|' . request()->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $this->addError('email', trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]));
            return;
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 900); // 15 minute decay

        // 1. Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'timezone' => 'UTC',
            'locale' => 'en',
            'date_format' => 'Y-m-d',
        ]);

        // 2. Generate slug and create Tenant
        $slug = Str::slug($this->workspace_name);
        // Ensure slug is unique
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

        // 3. Link User as Owner of Tenant
        $ownerRole = Role::where('name', 'owner')->first();
        $user->tenants()->attach($tenant->id, [
            'role_id' => $ownerRole->id,
            'is_active' => true,
        ]);

        // Trigger Laravel's Registered event to send verification email
        event(new Registered($user));

        // 4. Log in
        Auth::login($user);

        // 5. Log activity
        activity_log(
            event: 'auth.register',
            description: "New user registered: {$user->email}",
            userId: $user->id,
            tenantId: $tenant->id
        );

        activity_log(
            event: 'tenant.create',
            description: "New workspace created: {$tenant->name} ({$tenant->slug})",
            userId: $user->id,
            tenantId: $tenant->id
        );

        session()->put('tenant_id', $tenant->id);

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.auth');
    }
}
