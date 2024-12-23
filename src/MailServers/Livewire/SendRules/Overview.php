<?php

namespace Sellvation\CCMV2\MailServers\Livewire\SendRules;

use Livewire\Component;
use Sellvation\CCMV2\MailServers\Models\SendRule;

class Overview extends Component
{
    public function remove(SendRule $sendRule)
    {
        $sendRule->delete();
    }

    public function render()
    {
        return view('mailservers::livewire.send-rules.overview')
            ->with([
                'sendRules' => SendRule::all(),
            ]);
    }
}
