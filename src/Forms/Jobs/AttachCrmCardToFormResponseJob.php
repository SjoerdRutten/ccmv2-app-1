<?php

namespace Sellvation\CCMV2\Forms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Forms\Models\FormResponse;

class AttachCrmCardToFormResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly FormResponse $formResponse) {}

    public function handle(): void
    {
        if (! $this->formResponse->crmCard) {
            $formResponse = $this->formResponse;
            $form = $formResponse->form;
            $crmCard = null;

            foreach ($form->fields as $field) {
                if (\Arr::get($field, 'attach_to_crm_card')) {
                    $crmField = CrmField::find($field['crm_field_id']);

                    if ($crmField->is_shown_on_target_group_builder) {
                        $crmCard = CrmCard::search('*')
                            ->options([
                                'page' => 1,
                                'per_page' => 1,
                                'filter_by' => $crmField['name'].':='.$formResponse->data[$crmField->name],
                            ])
                            ->first();
                    } else {
                        // Slow, but necessary if data nog available in index
                        $crmCard = CrmCard::query()
                            ->where(\DB::raw('data->"$.'.$crmField->name.'"'), '=', $formResponse->data[$crmField->name])
                            ->first();
                    }
                }
            }

            // If no crmCard has been created, create a CRM Card
            if (! $crmCard) {
                $crmCard = new CrmCard;
                $crmCard->setData($formResponse->data);
                $crmCard->save();
            }

            $formResponse->crmCard()->associate($crmCard);
            $formResponse->save();
        }
    }
}
