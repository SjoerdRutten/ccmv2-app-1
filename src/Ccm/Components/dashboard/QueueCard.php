<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class QueueCard extends Component
{
    private function getQueues(): Collection
    {
        $queues = DB::table('jobs')
            ->select('queue')
            ->selectRaw('count(*) as total')
            ->selectRaw('min(created_at) as oldest')
            ->selectRaw('max(created_at) as latest')
            ->groupBy('queue')
            ->orderBy('queue')
            ->get();

        return $queues;
    }

    public function render(): View
    {
        return view('ccm::components.dashboard.queue-card')
            ->with([
                'queues' => $this->getQueues(),
            ]);
    }
}
