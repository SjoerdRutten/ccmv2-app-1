<?php

namespace Sellvation\CCMV2\Ems\Livewire\Emails;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Livewire\Emails\Forms\EmailForm;
use Sellvation\CCMV2\Ems\Models\Email;

class Edit extends Component
{
    use HasModals;

    public Email $email;

    public EmailForm $form;

    public CrmCard $crmCard;

    public string $crmId = '';

    public string $stripoToken;

    public string $crc;

    public function mount(Email $email)
    {
        $this->email = $email;

        $this->form->setEmail($this->email);

        $this->stripoToken = \Stripo::getToken();
        $this->crmCard = CrmCard::first();
        $this->crmId = $this->crmCard->crm_id;
    }

    public function updated($property, $value)
    {
        switch ($property) {
            case 'form.recipient_type':
                $this->form->recipient = null;
                $this->form->recipient_crm_field_id = null;
                break;
            case 'form.html':
                $this->email = $this->form->save();
                $this->crc = crc32($this->email->html);
                break;
            case 'crmId':
                $this->crmCard = CrmCard::whereCrmId($this->crmId)->first();
                break;
        }
    }

    public function save()
    {
        $this->email = $this->form->save();

        $this->showSuccessModal(title: 'E-mail is opgeslagen', href: route('ems::emails::edit', $this->email));
    }

    public function render()
    {
        return view('ems::livewire.emails.edit');
    }
}
