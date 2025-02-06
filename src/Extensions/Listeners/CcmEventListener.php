<?php

namespace Sellvation\CCMV2\Extensions\Listeners;

use Sellvation\CCMV2\Extensions\Models\Extension;

class CcmEventListener
{
    public function handle($event): void
    {
        foreach (Extension::where('event', get_class($event))->isActive()->get() as $extension) {
            dispatch(new $extension->job($extension->settings, $event));
        }
    }
}
