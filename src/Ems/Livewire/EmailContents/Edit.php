<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailContents;

use Livewire\Component;
use Sellvation\CCMV2\Ems\Livewire\EmailContents\Forms\EmailContentForm;
use Sellvation\CCMV2\Ems\Models\EmailContent;

class Edit extends Component
{
    public EmailContent $emailContent;

    public EmailContentForm $form;

    public function mount()
    {
        $this->form->setEmailContent($this->emailContent);
    }

    public function save()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('ems::livewire.email-contents.edit');
    }
}
