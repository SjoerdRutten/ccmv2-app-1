<?php

namespace Sellvation\CCMV2\CrmCards\Listeners;

use Illuminate\Bus\Queueable;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Symfony\Component\HttpClient\HttplugClient;
use Typesense\Client;

class UpdateTypesenseSchemaListener
{
    use Queueable;

    public function __construct()
    {
    }

    public function handle(CrmFieldSavedEvent $event): void
    {
        /** @var CrmField $crmField */
        $crmField = $event->crmField;
        $crmCard = new CrmCard;

        $fields = [];

        if ($crmField->isDirty('is_shown_on_target_group_builder')) {
            if ($crmField->is_shown_on_target_group_builder) {
                $fields = $this->addIndex($crmField);
            } else {
                $fields = $this->removeIndex($crmField);
            }
        } elseif ($crmField->isDirty('name')) {
            $fields = $this->addIndex($crmField);
            $fields = array_merge($fields, $this->removeIndex($crmField, $crmField->getOriginal('name')));
        }

        if (count($fields) > 0) {
            $client = new Client(
                [
                    'api_key' => config('scout.typesense.client-settings.api_key'),
                    'nodes' => [
                        [
                            'host' => 'localhost',
                            'port' => '8108',
                            'protocol' => 'http',
                        ],
                    ],
                    'client' => new HttplugClient(),
                ]
            );

            $client->collections[$crmCard->searchableAs()]->update(['fields' => $fields]);
        }

    }

    private function removeIndex(CrmField $crmField, $name = null): array
    {
        $name = $name ?: $crmField->name;

        $fields = [];

        switch ($crmField->type) {
            case 'MEDIA':
                $fields[] = ['name' => '_'.$name.'_optin', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_confirmed_optin', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_confirmed_optin_timestamp', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_confirmed_optout', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_optout_timestamp', 'drop' => true];
                break;
            case 'EMAIL':
                $fields[] = ['name' => '_'.$name.'_abuse', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_abuse_timestamp', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_bounce_reason', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_bounce_score', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_bounce_type', 'drop' => true];
                $fields[] = ['name' => '_'.$name.'_type', 'drop' => true];
                break;
            default:
                $fields[] = [
                    'name' => $name,
                    'drop' => true,
                ];
        }

        return $fields;
    }

    private function addIndex(CrmField $crmField): array
    {
        $fields = [];

        switch ($crmField->type) {
            case 'BOOLEAN':
            case 'CONSENT':
                $fieldType = 'bool';
                break;
            case 'DATETIME':
                $fieldType = 'int64';
                break;
            case 'DECIMAL':
                $fieldType = 'float';
                break;
            case 'INT':
                $fieldType = 'int32';
                break;
            case 'MEDIA':
                $fields[] = ['name' => '_'.$crmField->name.'_optin', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optin', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optin_timestamp', 'type' => 'int64', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_confirmed_optout', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_optout_timestamp', 'type' => 'int64', 'optional' => true];

                $fieldType = false;
                break;
            case 'EMAIL':
                $fields[] = ['name' => '_'.$crmField->name.'_abuse', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_abuse_timestamp', 'type' => 'int64', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_bounce_reason', 'type' => 'string', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_bounce_score', 'type' => 'int32', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_bounce_type', 'type' => 'string', 'optional' => true];
                $fields[] = ['name' => '_'.$crmField->name.'_type', 'type' => 'string', 'optional' => true];

                $fieldType = false;
                break;
            case 'TEXTBIG':
            case 'TEXTMICRO':
            case 'TEXTMIDDLE':
            case 'TEXTMINI':
            case 'TEXTSMALL':
            default:
                $fieldType = 'string';

        }

        if ($fieldType) {
            $fields[] = [
                'name' => $crmField->name,
                'type' => $fieldType,
                'optional' => true,
            ];
        }

        return $fields;
    }
}
