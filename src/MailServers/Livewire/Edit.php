<?php

namespace Sellvation\CCMV2\MailServers\Livewire;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\MailServers\Livewire\Forms\MailServerForm;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class Edit extends Component
{
    use HasModals;

    public MailServer $mailServer;

    public MailServerForm $form;

    public function mount(MailServer $mailServer)
    {
        $this->mailServer = $mailServer;
        $this->form->setMailServer($this->mailServer);
    }

    public function save()
    {
        $this->mailServer = $this->form->save();

        $this->showSuccessModal(title: 'Mailserver is opgeslagen', href: route('admin::mailservers::edit', $this->mailServer->id));
    }

    public function render()
    {
        return view('mailservers::livewire.edit')
            ->with([
            ]);
    }
}
