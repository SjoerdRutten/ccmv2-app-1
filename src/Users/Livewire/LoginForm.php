<?php

namespace Sellvation\CCMV2\Users\Livewire;

use Livewire\Component;

class LoginForm extends Component
{
    public function render()
    {
        return view('user::livewire.login-form')
            ->layout('ccm::layouts.guest');
    }
}
