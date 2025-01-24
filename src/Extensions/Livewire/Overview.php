<?php

namespace Sellvation\CCMV2\Extensions\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Extensions\Models\Extension;

class Overview extends Component
{
    use WithPagination;

    private function getExtensions()
    {
        return Extension::query()
            ->paginate();
    }

    public function render()
    {
        return view('extensions::extensions.overview')
            ->with([
                'extensions' => $this->getExtensions(),
            ]);
    }
}
