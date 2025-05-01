<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QueueCard extends Component
{
    private function getQueues(): array
    {
        $queues = [];
        foreach (config('ccm.queues') as $queue) {
            $queues[$queue] = [
                'count' => \Queue::size($queue),
            ];
        }

        ksort($queues);

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
