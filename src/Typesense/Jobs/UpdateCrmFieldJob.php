<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Symfony\Component\HttpClient\HttplugClient;
use Typesense\Client;
use Typesense\Exceptions\ObjectUnprocessable;

class UpdateCrmFieldJob extends TypesenseJob implements ShouldQueue
{
    public function __construct(private readonly CrmField $crmField, public readonly string $action)
    {
        $this->queue = 'typesense';
    }

    public function handle(): void
    {
        /** @var CrmField $crmField */
        $crmField = $this->crmField;

        $fields = [];

        $collectionName = 'crm_cards_'.$crmField->environment_id;

        if (($this->action === 'remove') || ($this->action === 'update')) {
            foreach ($this->removeIndex($crmField) as $fieldName) {
                $fields[] = [
                    'name' => $fieldName,
                    'drop' => true,
                ];
            }
        }
        if (($this->action === 'add') || ($this->action === 'update')) {
            foreach ($crmField->getTypesenseFields() as $field) {
                $fields[] = $field;
            }
        }

        $client = $this->initClient();

        try {
            $client->collections[$collectionName]->update(['fields' => $fields]);
        } catch (ObjectUnprocessable $e) {
            $this->release(60);
            Log::error('UpdateCrmField: Try again in 60 seconds:', ['collection' => $collectionName, 'field' => $crmField->name]);
        } catch (\Exception $e) {
            Log::error('UpdateCrmField: '.$e->getMessage(), ['collection' => $collectionName, 'field' => $crmField->name]);
        }

        if (($this->action === 'add') || ($this->action === 'update')) {
            Artisan::call('scout:import '.addslashes(CrmCard::class));
        }
    }

    protected function initClient()
    {
        $client = new HttplugClient;
        $client->withOptions([
            'timeout' => 600,
            'max_duration' => 600,
        ]);

        return new Client(
            [
                'api_key' => config('scout.typesense.client-settings.api_key'),
                'nodes' => [
                    [
                        'host' => 'localhost',
                        'port' => '8108',
                        'protocol' => 'http',
                    ],
                ],
                'client' => $client,
            ]
        );
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

    //    public function retryUntil(): \DateTime
    //    {
    //        return now()->addDay();
    //    }
}
