<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Sellvation\CCMV2\CrmCards\Livewire\Cards\Forms\CrmCardForm;
use Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms\CrmFieldForm;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

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
