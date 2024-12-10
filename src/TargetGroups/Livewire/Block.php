<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Block extends Component
{
    #[Modelable]
    public array $element = [];

    public $index = 0;

    public bool $readonly = false;

    public function getRuleKey($key)
    {
        return 'element.subelements.'.$key;
    }

    public function addRule()
    {
        $key = uniqid();

        Arr::set($this->element, 'subelements.'.$key,
            [
                'type' => 'rule',
                'active' => true,
                'id' => $key,
                'name' => $key,
                'column' => '',
                'operator' => '',
                'value' => null,
                'from' => null,
                'to' => null,
                'columnType' => null,
            ]);
    }

    public function removeRule($key)
    {
        Arr::set($this->element, 'subelements.'.$key, null);
        $this->dispatch('update-count')->to(Form::class);
    }

    public function toggleOperator()
    {
        $operation = Arr::get($this->element, 'operation') === 'AND' ? 'OR' : 'AND';
        Arr::set($this->element, 'operation', $operation);
        $this->dispatch('update-count')->to(Form::class);
    }

    public function render()
    {
        return view('target-group::livewire.block');
    }
}
