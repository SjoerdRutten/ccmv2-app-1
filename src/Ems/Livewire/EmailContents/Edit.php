<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailContents;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Ems\Livewire\EmailContents\Forms\EmailContentForm;
use Sellvation\CCMV2\Ems\Models\EmailContent;

class Edit extends Component
{
    use HasModals;

    public EmailContent $emailContent;

    public EmailContentForm $form;

    public function mount(EmailContent $emailContent)
    {
        $this->emailContent = $emailContent;
        $this->form->setEmailContent($this->emailContent);
    }

    public function save()
    {
        $this->emailContent = $this->form->save();

        $this->showSuccessModal(title: 'Content is opgeslagen', href: route('ems::emailcontents::edit', $this->emailContent->id));

    }

    public function render()
    {
        return view('ems::livewire.email-contents.edit');
    }
}
