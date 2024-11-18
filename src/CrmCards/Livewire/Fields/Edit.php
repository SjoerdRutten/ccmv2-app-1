<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms\CrmFieldForm;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class Edit extends Component
{
    use HasModals;

    public CrmField $crmField;

    public CrmFieldForm $form;

    public string $testValue = '';

    public string|bool $preCorrectedValue = '';

    public array $validation;

    public string|bool $postCorrectedValue = '';

    public function mount()
    {
        $this->form->setCrmField($this->crmField);
        $this->getCorrectedValue();
    }

    public function updated($property, $value)
    {
        switch ($property) {
            case 'testValue':
                $this->getCorrectedValue();
                break;
        }
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

    #[On('remove-rule')]
    public function removeRule($ruleType, $key)
    {
        Arr::pull($this->form->{$ruleType}, $key);
        $this->getCorrectedValue();
    }

    #[On('remove-validator')]
    public function removeValidator($key)
    {
        Arr::pull($this->form->validationRules, $key);
        $this->getCorrectedValue();
    }

    #[On('updated-rule')]
    public function getCorrectedValue()
    {
        $this->crmField->pre_processing_rules = $this->form->preProcessingRules;
        $this->crmField->post_processing_rules = $this->form->postProcessingRules;
        $this->crmField->validation_rules = $this->form->validationRules;

        $this->preCorrectedValue = $this->crmField->preCorrectValue($this->testValue);
        $this->validation = $this->crmField->validate($this->preCorrectedValue);
        $this->postCorrectedValue = $this->crmField->postCorrectValue($this->preCorrectedValue);
    }

    public function testCorrection()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.edit');
    }
}
