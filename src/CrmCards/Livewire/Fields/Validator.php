<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;

class Validator extends Component
{
    use HasModals;

    #[Modelable]
    public $validator;

    public string $validatorType;

    public string $validatorKey;

    public function updated($property, $value)
    {
        $this->dispatch('updated-validator')->to(Edit::class);
    }

    public function removeValidator($validatorType, $key)
    {
        $this->dispatch('remove-validator', ruleType: $validatorType, key: $key)->to(Edit::class);
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.validator')
            ->with([
                'validators' => \CrmFieldValidator::getValidators(),
            ]);
    }
}
