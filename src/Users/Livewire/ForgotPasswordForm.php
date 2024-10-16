<?php

namespace Sellvation\CCMV2\Users\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPasswordForm extends Component
{
    public string $name = 'sellvation.sjoerdrutten';

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $broker = Password::broker('users');

        $status = $broker->sendResetLink(['name' => $this->name]);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                $this->dispatch('show-modal-success', title: 'Mail verzonden', content: 'Er is een mail verzonden met een link waarmee je je wachtwoord kan resetten', href: route('login'));
                break;
            case Password::INVALID_USER:
                $this->dispatch('show-modal-error', title: 'Geen account gevonden', content: 'Er is geen account gevonden voor de gebruikersnaam '.$this->name);
                break;
            case Password::RESET_THROTTLED:
                $this->dispatch('show-modal-error', title: 'Reeds een poging gedaan', content: 'Er is al een reset mail verzonden');
        }
    }

    public function render()
    {
        return view('user::livewire.forgot-password-form')
            ->layout('ccm::layouts.guest');
    }
}
