<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirectIntended(route('dashboard'));
        }
    }

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function login(): void
    {
        $this->validate();

        $throttleKey = \Illuminate\Support\Str::transliterate(
            \Illuminate\Support\Str::lower($this->email).'|'.request()->ip()
        );

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => [trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ])],
            ]);
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 60);

            activity_log(
                event: 'auth.login_failed',
                description: "Failed login attempt for email: {$this->email}",
                properties: ['email' => $this->email]
            );

            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);

        $user = Auth::user();
        session()->regenerate();

        // Log the successful login
        activity_log(
            event: 'auth.login',
            description: "User logged in successfully: {$user->email}",
            userId: $user->id
        );

        $this->redirectIntended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth');
    }
}
