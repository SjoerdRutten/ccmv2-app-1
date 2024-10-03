<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms\CrmFieldForm;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class Edit extends Component
{
    public CrmField $crmField;

    public CrmFieldForm $form;

    public function mount()
    {
        $this->form->setCrmField($this->crmField);
    }

    public function save()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.edit');
    }
}
