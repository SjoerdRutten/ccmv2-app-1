<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TypesenseMemoryCard extends Component
{
    public function render(): View
    {
        return view('ccm::components.dashboard.typesense-memory-card')
            ->with([
                'metrics' => \Typesense::getMetrics(),
            ]);
    }
}
