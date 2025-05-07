<?php

namespace Sellvation\CCMV2\Scheduler\Livewire\Scheduler;

use Livewire\Component;
use Sellvation\CCMV2\Scheduler\Models\ScheduledTask;

class Overview extends Component
{
    public function run(ScheduledTask $task)
    {
        \CcmScheduler::run($task);

        $this->showSuccessModal(title: 'Taak wordt uitgevoerd');
    }

    public function remove(ScheduledTask $task)
    {
        $task->delete();
    }

    public function render()
    {
        return view('scheduler::livewire.scheduler.overview')
            ->with([
                'schedules' => ScheduledTask::all(),
            ]);
    }
}
