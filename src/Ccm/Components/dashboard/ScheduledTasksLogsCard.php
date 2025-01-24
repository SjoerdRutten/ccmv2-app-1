<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Sellvation\CCMV2\Scheduler\Models\ScheduledTaskLog;

class ScheduledTasksLogsCard extends Component
{
    public function render(): View
    {
        return view('ccm::components.dashboard.scheduled-tasks-log-card')
            ->with([
                'logs' => ScheduledTaskLog::latest()->limit(5)->get(),
            ]);
    }
}
