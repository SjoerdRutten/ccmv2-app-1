<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Environments;

use Livewire\Component;
use Sellvation\CCMV2\Environments\Models\Environment;

class Overview extends Component
{
    public function render()
    {
        return view('ccm::livewire.admin.environments.overview')
            ->with([
                'environments' => Environment::orderBy('name')->get(),
            ]);
    }
}
