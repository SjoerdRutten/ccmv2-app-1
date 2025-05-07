<?php

namespace Sellvation\CCMV2\Ccm\Components\dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Sellvation\CCMV2\Ccm\Models\Server;

class ServersCard extends Component
{
    public function render(): View
    {
        return view('ccm::components.dashboard.servers-card')
            ->with([
                'servers' => Server::orderBy('type')->orderBy('name')->get(),
            ]);
    }
}
