<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmail extends Component
{
    public ?string $status = null;

    public function mount(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(route('dashboard'));
        }
    }

    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(route('dashboard'));
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        $this->status = 'verification-link-sent';
    }

    public function logout(): void
    {
        $user = Auth::user();
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        activity_log(
            event: 'auth.logout',
            description: "User logged out from verification page: {$user->email}",
            userId: $user->id
        );

        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.auth');
    }
}
