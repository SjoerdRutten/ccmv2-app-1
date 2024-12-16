<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Sellvation\CCMV2\CrmCards\Events\CrmCardDeletingEvent;
use Sellvation\CCMV2\CrmCards\Jobs\RemoveCrmCardMongoDbJob;

class CrmCardDeletingListener
{
    public function __construct() {}

    public function handle(CrmCardDeletingEvent $event): void
    {
        RemoveCrmCardMongoDbJob::dispatch($event->crmCard)->onQueue('scout');
    }
}
