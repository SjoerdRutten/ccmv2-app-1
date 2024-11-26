<?php

namespace Sellvation\CCMV2\Sites\Listeners;

use Sellvation\CCMV2\Sites\Events\SiteUpdatingEvent;

class SiteUpdatingListener
{
    public function __construct() {}

    public function handle(SiteUpdatingEvent $event): void
    {
        $site = $event->site;

        if ($site->isDirty('favicon') && $site->getOriginal('favicon')) {
            \Storage::disk($site->favicon_disk)->delete($site->getOriginal('favicon'));
        }
    }
}
