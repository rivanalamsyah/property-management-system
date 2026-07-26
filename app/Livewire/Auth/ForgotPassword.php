<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';
    public ?string $status = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function sendResetLink(): void
    {
        $this->validate();

        $throttleKey = 'forgot-password|' . \Illuminate\Support\Str::transliterate(
            \Illuminate\Support\Str::lower($this->email).'|'.request()->ip()
        );

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $this->addError('email', trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]));
            return;
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 300); // 5 minute decay

        $response = Password::broker()->sendResetLink(
            ['email' => $this->email]
        );

        if ($response === Password::RESET_LINK_SENT) {
            $this->status = trans($response);
            $this->reset('email');
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
        } else {
            $this->addError('email', trans($response));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.auth');
    }
}
