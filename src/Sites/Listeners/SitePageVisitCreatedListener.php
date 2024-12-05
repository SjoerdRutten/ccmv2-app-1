<?php

namespace Sellvation\CCMV2\Sites\Listeners;

use Sellvation\CCMV2\Sites\Events\SitePageVisitCreatedEvent;
use Sellvation\CCMV2\Sites\Jobs\AddCrmIdToSitePageVisitJob;

class SitePageVisitCreatedListener
{
    public function __construct() {}

    public function handle(SitePageVisitCreatedEvent $event): void
    {
        AddCrmIdToSitePageVisitJob::dispatch($event->sitePageVisit);
    }
}
