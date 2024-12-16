<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Sellvation\CCMV2\CrmCards\Events\CrmFieldDeletedEvent;
use Sellvation\CCMV2\CrmCards\Jobs\RemoveFieldFromCrmCardsJob;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class CrmFieldDeletedListener
{
    public function __construct() {}

    public function handle(CrmFieldDeletedEvent $event): void
    {
        for ($i = 0; $i < CrmCard::count(); $i += 1000) {
            RemoveFieldFromCrmCardsJob::dispatch($event->crmField->name, $event->crmField->crmFieldType, $i, 1000);
        }
    }
}
