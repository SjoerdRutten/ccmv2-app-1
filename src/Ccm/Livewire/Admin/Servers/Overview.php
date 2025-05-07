<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Servers;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Models\Server;

class Overview extends Component
{
    public function removeServer(Server $server)
    {
        $server->delete();
    }

    public function render()
    {
        return view('ccm::livewire.admin.servers.overview')
            ->with([
                'servers' => Server::orderBy('type')->orderBy('name')->get(),
            ]);
    }
}
