<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Typesense\Jobs\AddFieldJob;
use Sellvation\CCMV2\Typesense\Jobs\RemoveFieldJob;

class UpdateTypesenseSchemaListener implements ShouldQueue
{
    use Queueable;

    public function __construct() {}

    public function viaQueue()
    {
        return 'typesense';
    }

    public function handle(CrmFieldSavedEvent $event): void
    {
        /** @var CrmField $crmField */
        $crmField = $event->crmField;

        $batch = Bus::batch([]);

        $adding = false;
        if ($crmField->isDirty('is_shown_on_target_group_builder')) {
            if ($crmField->is_shown_on_target_group_builder) {
                $adding = true;
                foreach ($crmField->getTypesenseFields() as $field) {
                    $batch->add(new AddFieldJob('crm_cards_'.$crmField->environment_id, $field));
                }
            } else {
                foreach ($this->removeIndex($crmField) as $fieldName) {
                    $batch->add(new RemoveFieldJob('crm_cards_'.$crmField->environment_id, $fieldName));
                }
            }
        } elseif ($crmField->isDirty('name')) {
            $adding = true;
            foreach ($this->removeIndex($crmField, $crmField->getOriginal('name')) as $fieldName) {
                $batch->add(new RemoveFieldJob('crm_cards_'.$crmField->environment_id, $fieldName));
            }
            foreach ($crmField->getTypesenseFields() as $field) {
                $batch->add(new AddFieldJob('crm_cards_'.$crmField->environment_id, $field));
            }
        }

        $batch
            ->finally(function (Batch $batch) use ($adding) {
                if ($adding) {
                    Artisan::call('scout:import '.addslashes(CrmCard::class));
                }
            })
            ->dispatch();

    }

    private function removeIndex(CrmField $crmField, $name = null): array
    {
        $name = $name ?: $crmField->name;

        $fields = [];

        switch ($crmField->type) {
            case 'MEDIA':
                $fields[] = '_'.$name.'_allowed';
                $fields[] = '_'.$name.'_optin';
                $fields[] = '_'.$name.'_confirmed_optin';
                $fields[] = '_'.$name.'_confirmed_optin_timestamp';
                $fields[] = '_'.$name.'_confirmed_optout';
                $fields[] = '_'.$name.'_optout_timestamp';
                break;
            case 'EMAIL':
                $fields[] = $name;
                $fields[] = $name.'_infix';
                $fields[] = '_'.$name.'_valid';
                $fields[] = '_'.$name.'_possible';
                $fields[] = '_'.$name.'_abuse';
                $fields[] = '_'.$name.'_abuse_timestamp';
                $fields[] = '_'.$name.'_bounce_reason';
                $fields[] = '_'.$name.'_bounce_score';
                $fields[] = '_'.$name.'_bounce_type';
                $fields[] = '_'.$name.'_type';
                break;
            default:
                $fields[] = $name;
        }

        return $fields;
    }
}
