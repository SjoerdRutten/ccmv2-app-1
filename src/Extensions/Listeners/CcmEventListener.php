<?php

namespace Sellvation\CCMV2\Extensions\Listeners;

use Sellvation\CCMV2\Extensions\Models\Extension;

class CcmEventListener
{
    public function handle($event): void
    {
        foreach (Extension::where('event', get_class($event))->isActive()->get() as $extension) {
            \Log::info('[CCMEVENTLISTENER] '.get_class($event).' - '.$extension->job);

            dispatch(new $extension->job($extension->settings, $event))->delay(now()->addseconds(5));
        }
    }
}
