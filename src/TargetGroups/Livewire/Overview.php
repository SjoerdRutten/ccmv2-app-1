<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Overview extends Component
{
    #[Computed]
    public function targetGroups()
    {
        return TargetGroup::orderBy('name')->get();
    }

    public function render()
    {
        return view('target-group::overview');
    }
}
