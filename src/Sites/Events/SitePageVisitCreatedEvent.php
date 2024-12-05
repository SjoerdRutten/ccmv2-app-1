<?php

namespace Sellvation\CCMV2\Sites\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\Sites\Models\SitePageVisit;

class SitePageVisitCreatedEvent
{
    use Dispatchable;

    public function __construct(public readonly SitePageVisit $sitePageVisit) {}
}
