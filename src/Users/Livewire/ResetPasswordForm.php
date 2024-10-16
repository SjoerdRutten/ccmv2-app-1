<?php

namespace Sellvation\CCMV2\Users\Livewire;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\Users\Models\User;

class ResetPasswordForm extends Component
{
    public string $token;

    #[Url]
    public string $name;

    public string $password = '';

    public string $password_confirmation = '';

    public function store()
    {
        $this->validate([
            'token' => 'required',
            'name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::whereName($this->name)->firstOrFail();

        $broker = Password::broker('users');
        $status = $broker->reset([
            'email' => $user->email,
            'token' => $this->token,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ], function ($user) {
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();
        });

        switch ($status) {
            case Password::PASSWORD_RESET:
                $this->dispatch('show-modal-success', title: 'Wachtwoord is opgeslagen', content: 'Je wachtwoord is opgeslagen, je kan nu inloggen met je nieuwe gegevens', href: route('login'));
                break;
            case Password::INVALID_TOKEN:
                $this->dispatch('show-modal-error', title: 'Link ongeldig', content: 'Deze link is niet (meer) geldig');
                break;

        }
    }

    public function render()
    {
        return view('user::livewire.reset-password-form')
            ->layout('ccm::layouts.guest');
    }
}
