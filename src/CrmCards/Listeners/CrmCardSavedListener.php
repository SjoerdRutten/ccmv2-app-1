<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Sellvation\CCMV2\CrmCards\Events\CrmCardSavedEvent;
use Sellvation\CCMV2\CrmCards\Jobs\UpdateCrmCardMongoDbJob;

class CrmCardSavedListener
{
    public function __construct() {}

    public function handle(CrmCardSavedEvent $event): void
    {
        UpdateCrmCardMongoDbJob::dispatchSync($event->crmCard);
    }
}
