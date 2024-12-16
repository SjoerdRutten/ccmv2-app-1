<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Livewire\Cards\Forms\CrmCardForm;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class Edit extends Component
{
    use HasModals;

    public CrmCard $crmCard;

    public CrmCardForm $form;

    public function mount(CrmCard $crmCard)
    {
        $this->crmCard = $crmCard;
        $this->form->setCrmCard($this->crmCard);
    }

    public function save()
    {
        $this->crmCard = $this->form->save();

        $this->showSuccessModal('CRM Kaart is opgeslagen', href: route('crm-cards::cards::edit', $this->crmCard->id));
    }

    public function render()
    {
        return view('crm-cards::livewire.cards.edit');
    }
}
