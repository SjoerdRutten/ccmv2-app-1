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

    public function reOrderRules($id, $position)
    {
        $crmFieldCategory = SendRule::find($id);
        $crmFieldCategory->update(['priority' => $position]);

        $index = 0;
        foreach (SendRule::where('id', '<>', $id)->orderBy('priority')->get() as $sendRule) {
            if ($index === $position) {
                $index++;
            }
            $sendRule->update(['priority' => $index]);
            $index++;
        }
    }

    public function render()
    {
        return view('mailservers::livewire.send-rules.overview')
            ->with([
                'sendRules' => SendRule::orderBy('priority')->get(),
            ]);
    }
}
