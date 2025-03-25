<?php

namespace Sellvation\CCMV2\Disks\Livewire\DiskTypes;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Disks\Models\DiskType;

class Overview extends Component
{
    use WithPagination;

    private function getDiskTypes()
    {
        return DiskType::query()
            ->paginate();
    }

    public function render()
    {
        return view('disks::disktypes.overview')
            ->with([
                'diskTypes' => $this->getDiskTypes(),
            ]);
    }
}
