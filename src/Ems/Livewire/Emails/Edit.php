<?php

namespace Sellvation\CCMV2\Ems\Livewire\Emails;

use Livewire\Component;
use Sellvation\CCMV2\Ems\Livewire\Emails\Forms\EmailForm;
use Sellvation\CCMV2\Ems\Models\Email;

class Edit extends Component
{
    public Email $email;

    public EmailForm $form;

    public function mount()
    {
        $this->form->setEmail($this->email);
    }

    public function save()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('ems::livewire.emails.edit');
    }
}
