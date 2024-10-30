<?php

namespace Sellvation\CCMV2\Users\Livewire\Roles;

use Livewire\Component;
use Sellvation\CCMV2\Users\Models\Role;

class Overview extends Component
{
    public function render()
    {
        return view('user::livewire.roles.overview')
            ->with([
                'roles' => Role::orderBy('name')->get(),
            ]);
    }
}
