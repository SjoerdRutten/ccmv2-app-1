<?php

namespace Sellvation\CCMV2\Ccm\Livewire;

use Livewire\Component;

class EnvironmentSelector extends Component
{
    public string $environmentId;

    public function mount()
    {
        $this->environmentId = \Session::get('environment_id') ? \Session::get('environment_id') : \Auth::user()->customer->environments()->first()->id;
    }

    public function updated($property, $value)
    {
        $this->environmentId = $value;
        \Session::put('environment_id', $this->environmentId);

        $this->redirect(request()->header('referer'));
    }

    public function render()
    {
        return view('ccm::livewire.environment-selector')
            ->with([
                'environments' => \Auth::user()->customer->environments,
            ]);
    }
}
