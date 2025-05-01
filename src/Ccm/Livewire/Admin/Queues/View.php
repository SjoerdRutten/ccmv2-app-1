<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Queues;

use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class View extends Component
{
    public string $queue;

    private function getJobs(): array
    {
        $jobs = Redis::lrange('queues:'.$this->queue, 0, 200);

        $data = [];
        foreach ($jobs as $jobPayload) {
            $data[] = json_decode($jobPayload, true);

        }

        return $data;
    }

    public function render()
    {
        return view('ccm::livewire.admin.queues.view')
            ->with([
                'jobs' => $this->getJobs(),
                'size' => \Queue::size($this->queue),
            ]);
    }
}
