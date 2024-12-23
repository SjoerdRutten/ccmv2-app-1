<?php

namespace Sellvation\CCMV2\MailServers\Livewire\MailServers;

use Livewire\Component;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class Overview extends Component
{
    public function render()
    {
        return view('mailservers::livewire.mail-servers.overview')
            ->with([
                'mailServers' => MailServer::all(),
            ]);
    }
}
