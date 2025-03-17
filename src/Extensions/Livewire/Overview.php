<?php

namespace Sellvation\CCMV2\Extensions\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Extensions\Models\Extension;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => '',
        'event' => '',
        'job' => '',
    ];

    private function getExtensions()
    {
        return Extension::query()
            ->when(! empty($this->filter['q']), function ($query) {
                $query->where('name', 'like', "%{$this->filter['q']}%");
            })
            ->when(! empty($this->filter['event']), function ($query) {
                $query->where('event', "{$this->filter['event']}");
            })
            ->when(! empty($this->filter['job']), function ($query) {
                $query->where('job', "{$this->filter['job']}");
            })
            ->paginate();
    }

    public function render()
    {
        return view('extensions::extensions.overview')
            ->with([
                'extensions' => $this->getExtensions(),
                'events' => \ExtensionService::getExtensionEvents(),
                'jobs' => \ExtensionService::getExtensionJobs(),
            ]);
    }
}
