<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms\CrmFieldForm;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class Edit extends Component
{
    use HasModals;

    public CrmField $crmField;

    public CrmFieldForm $form;

    public function mount()
    {
        $this->form->setCrmField($this->crmField);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal('Veld is opgeslagen');
    }

    public function addPreProcessingRule()
    {
        $this->form->addPreProcessingRule();
    }

    public function addPostProcessingRule()
    {
        $this->form->addPostProcessingRule();
    }

    public function addValidationRule()
    {
        $this->form->addValidationRule();
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.edit');
    }
}
