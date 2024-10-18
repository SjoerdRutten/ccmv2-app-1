<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TypesenseCard extends Component
{
    public function render(): View
    {
        return view('ccm::components.dashboard.typesense-card')
            ->with([
                'metrics' => \Typesense::getMetrics(),
            ]);
    }
}
