<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token, string $email = ''): void
    {
        $this->token = $token;
        $this->email = $email;
    }

    protected function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }

    public function resetPassword(): void
    {
        $this->validate();

        $throttleKey = 'reset-password|' . request()->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
            $this->addError('email', trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]));
            return;
        }

        \Illuminate\Support\Facades\RateLimiter::hit($throttleKey, 300); // 5 minute decay

        $response = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                activity_log(
                    event: 'auth.password_reset',
                    description: "Password reset completed for: {$user->email}",
                    userId: $user->id
                );
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            session()->flash('status', trans($response));
            \Illuminate\Support\Facades\RateLimiter::clear($throttleKey);
            $this->redirect(route('login'));
        } else {
            $this->addError('email', trans($response));
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.auth');
    }
}
