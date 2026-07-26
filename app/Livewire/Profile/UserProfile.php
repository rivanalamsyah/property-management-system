<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;

    // Profile fields
    public string $name = '';
    public string $email = '';
    public $avatar = null;

    // Password change fields
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    // Preferences
    public string $timezone = 'UTC';
    public string $locale = 'en';
    public string $date_format = 'Y-m-d';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->timezone = $user->timezone;
        $this->locale = $user->locale;
        $this->date_format = $user->date_format;
    }

    public function updateProfile(): void
    {
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        activity_log(
            event: 'profile.update',
            description: "Updated profile details: {$user->email}"
        );

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Profile updated successfully!',
        ]);
        
        $this->reset('avatar');
    }

    public function updatePassword(): void
    {
        $user = Auth::user();

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        activity_log(
            event: 'profile.password_change',
            description: "Changed password: {$user->email}"
        );

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Password changed successfully!',
        ]);
    }

    public function updatePreferences(): void
    {
        $user = Auth::user();

        $this->validate([
            'timezone' => ['required', 'string'],
            'locale' => ['required', 'string'],
            'date_format' => ['required', 'string'],
        ]);

        $user->update([
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'date_format' => $this->date_format,
        ]);

        activity_log(
            event: 'profile.preferences_change',
            description: "Updated account preferences: {$user->email}"
        );

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Preferences updated successfully!',
        ]);
    }

    public function logoutOtherSessions(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        $currentSessionId = session()->getId();

        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', $currentSessionId)
            ->delete();

        activity_log(
            event: 'profile.logout_devices',
            description: "Logged out other devices: " . Auth::user()->email
        );

        $this->reset('current_password');

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Successfully logged out of all other devices.',
        ]);
    }

    public function getSessionsProperty()
    {
        return DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.profile.user-profile', [
            'sessions' => $this->sessions,
        ])->layout('layouts.app');
    }
}
