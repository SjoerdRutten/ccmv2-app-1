<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Sellvation\CCMV2\CrmCards\Events\CrmCardCreatingEvent;

class CreateCrmIdListener
{
    public function __construct() {}

    public function handle(CrmCardCreatingEvent $event): void
    {
        $event->crmCard->environment_id = \Context::get('environment_id');
        $event->crmCard->crm_id = \Context::get('environment_id').'_'.uniqid();
    }
}
