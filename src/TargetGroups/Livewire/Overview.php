<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Overview extends Component
{
    #[Computed]
    public function targetGroups()
    {
        return TargetGroup::orderBy('name')->get();
    }

    public function render()
    {
        return view('target-group::livewire.overview');
    }
}
