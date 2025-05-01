<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Queues;

use Livewire\Component;

class Overview extends Component
{
    private function getQueues()
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

    public function render()
    {
        return view('ccm::livewire.admin.queues.overview')
            ->with([
                'queues' => $this->getQueues(),
            ]);
    }
}
