<?php

namespace Sellvation\CCMV2\Sites\Listeners;

use Sellvation\CCMV2\Sites\Events\SiteSavingEvent;

class SiteSavingListener
{
    public function __construct() {}

    public function handle(SiteSavingEvent $event): void
    {
        $site = $event->site;

        if (\Str::startsWith($site->domain, 'http://')) {
            $site->domain = \Str::substr($site->domain, 7);
        } elseif (\Str::startsWith($site->domain, 'https://')) {
            $site->domain = \Str::substr($site->domain, 8);
        }
    }
}
