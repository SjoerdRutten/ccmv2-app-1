<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\Events\CrmCardCreatingEvent;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class CrmCardCreatingListener
{
    public function __construct() {}

    public function handle(CrmCardCreatingEvent $event): void
    {
        $event->crmCard->environment_id = $event->crmCard->environment_id ?: \Context::get('environment_id');

        if (empty($event->crmCard->crm_id)) {
            // Generate unique crm_id
            do {
                $crmId = $event->crmCard->environment_id.'_'.Str::random(16);
            } while (CrmCard::where('crm_id', $crmId)->exists());

            $event->crmCard->crm_id = $crmId;
        }
    }
}
