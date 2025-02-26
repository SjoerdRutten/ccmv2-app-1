<?php

namespace Sellvation\CCMV2\Ccmp\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmFieldType;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class ConvertOptinOptoutCommand extends Command
{
    protected $signature = 'convert:optin-optout';

    protected $description = 'Convert the opt-in and opt-out fields to seperate models';

    public function handle(): void
    {
        $fieldType = CrmFieldType::whereName('MEDIA')->first();
        $count = CrmCard::count();
        $perPage = 1000;

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < ceil($count / $perPage); $i++) {
            foreach (CrmCard::limit($perPage)->skip($i * $perPage)->cursor() as $crmCard) {
                $bar->advance();

                $data = $crmCard->data;

                foreach ($fieldType->crmFields as $crmField) {
                    $optinTimestamp = \Arr::get($data, '_'.$crmField->name.'_optin_timestamp');
                    $confirmedOptin = \Arr::get($data, '_'.$crmField->name.'_confirmed_optin');
                    $confirmedOptinTimestamp = \Arr::get($data, '_'.$crmField->name.'_confirmed_optin_timestamp');
                    $optout = \Arr::get($data, '_'.$crmField->name.'_optout');
                    $optoutTimestamp = \Arr::get($data, '_'.$crmField->name.'_optout_timestamp');

                    if ($confirmedOptin && ((int) $confirmedOptinTimestamp > 0) && (! $crmCard->emailOptIns()->whereCrmFieldId($crmField->id)->exists())) {
                        $crmCard->emailOptIns()->create([
                            'crm_field_id' => $crmField->id,
                            'confirmed_at' => Carbon::parse($confirmedOptinTimestamp),
                            'created_at' => (int) $optinTimestamp > 0 ? Carbon::parse($optinTimestamp) : Carbon::parse($confirmedOptinTimestamp),
                        ]);
                    }
                    if ($optout && ((int) $optoutTimestamp > 0) && (! $crmCard->emailOptOuts()->whereCrmFieldId($crmField->id)->exists())) {
                        $crmCard->emailOptOuts()->create([
                            'crm_field_id' => $crmField->id,
                            'created_at' => Carbon::parse($optoutTimestamp),
                        ]);
                    }
                }
            }
        }

        $bar->finish();
    }
}
