<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupFieldset;

class CreateTargetGroupFieldset extends Component
{
    public int $count;

    #[Computed]
    public function targetGroupFieldsets()
    {
        return TargetGroupFieldset::orderBy('name')->get();
    }

    public function render()
    {
        return view('target-group::livewire.create-target-group-fieldset');
    }
}
