<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;

class UpdateTypesenseSchemaListener
{
    public function __construct()
    {
    }

    public function handle(CrmFieldSavedEvent $event): void
    {
        $crmField = $event->crmField;
    }
}
