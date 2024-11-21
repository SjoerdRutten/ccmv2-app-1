<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class FormActionSetTimestamp extends FormAction
{
    public string $name = 'Set timestamp van form submit voor geselecteerd veld';

    public function handle(): void
    {
        $params = $this->params;

        if ($crmField = CrmField::find(\Arr::get($params, 'crm_field_id'))) {

            $this->formResponse->crmCard->setData([
                $crmField->name => $this->formResponse->created_at,
            ]);
            $this->formResponse->crmCard->save();
        }
    }

    public function form(): ?View
    {
        return view('forms::actions.form-action-optin')
            ->with([
                'crmFields' => CrmField::query()
                    ->isDatetimeFieldType()
                    ->orderBy('label')
                    ->get(),
            ]);
    }
}
