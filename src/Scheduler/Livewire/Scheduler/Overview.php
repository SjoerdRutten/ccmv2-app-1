<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler;

use Livewire\Component;
use Sellvation\CCMV2\Scheduler\Models\Schedule;

class Overview extends Component
{
    public function render()
    {
        return view('scheduler::livewire.scheduler.overview')
            ->with([
                'schedules' => Schedule::all(),
            ]);
    }
}
