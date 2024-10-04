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

    public function updated($property, $value)
    {
        switch ($property) {
            case 'form.recipient_type':
                $this->form->recipient = null;
                $this->form->recipient_crm_field_id = null;
                break;
        }
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
