<?php

namespace Sellvation\CCMV2\Disks\Livewire\Disks;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Disks\Models\Disk;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => '',
    ];

    private function getDisks()
    {
        return Disk::query()
            ->when(! empty($this->filter['q']), function ($query) {
                $query->where('name', 'like', "%{$this->filter['q']}%");
            })
            ->paginate();
    }

    public function render()
    {
        return view('disks::disks.overview')
            ->with([
                'disks' => $this->getDisks(),
            ]);
    }
}
