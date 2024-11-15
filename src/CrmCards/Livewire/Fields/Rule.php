<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Livewire\Attributes\Modelable;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;

class Rule extends Component
{
    use HasModals;

    #[Modelable]
    public $rule;

    public string $ruleType;

    public string $ruleKey;

    public function updated($property, $value)
    {
        $this->dispatch('updated-rule')->to(Edit::class);
    }

    public function removeRule($ruleType, $key)
    {
        $this->dispatch('remove-rule', ruleType: $ruleType, key: $key)->to(Edit::class);
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.rule')
            ->with([
                'correctors' => \CrmFieldCorrector::getCorrectors(),
            ]);
    }
}
