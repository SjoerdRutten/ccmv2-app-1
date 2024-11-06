<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Illuminate\Bus\Queueable;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\Typesense\Jobs\UpdateCrmFieldJob;

class UpdateTypesenseSchemaListener
{
    use Queueable;

    public function __construct() {}

    public function viaQueue()
    {
        return 'typesense';
    }

    public function handle(CrmFieldSavedEvent $event): void
    {
        $action = 'add';

        if ($event->crmField->isDirty('is_shown_on_target_group_builder')) {
            if ($event->crmField->is_shown_on_target_group_builder) {
                $action = 'update';
            } else {
                $action = 'remove';
            }
        } elseif ($event->crmField->isDirty('name')) {
            $action = 'update';
        }

        UpdateCrmFieldJob::dispatch($event->crmField, $action);
    }
}
