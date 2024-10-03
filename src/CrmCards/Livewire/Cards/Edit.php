<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Livewire\Cards\Forms\CrmCardForm;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class Edit extends Component
{
    public CrmCard $crmCard;

    public CrmCardForm $form;

    public function mount()
    {
        $this->form->setCrmCard($this->crmCard);
    }

    public function save()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('crm-cards::livewire.cards.edit');
    }
}
