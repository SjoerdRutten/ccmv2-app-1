<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class FormActionOptin extends FormAction
{
    public bool $alwaysExecute = false;

    public string $name = 'Set opt-in voor geselecteerd veld';

    public function handle(): void
    {
        $params = $this->params;

        if ($crmField = CrmField::find(\Arr::get($params, 'crm_field_id'))) {
            $crmCard = $this->formResponse->crmCard;

            $crmCard->setData([
                '_'.$crmField->name.'_optin' => true,
                '_'.$crmField->name.'_optin_timestamp' => now(),
                '_'.$crmField->name.'_optout' => null,
                '_'.$crmField->name.'_optout_timestamp' => null,
            ]);

            $crmCard->save();
        }
    }

    public function form(): ?View
    {
        return view('forms::actions.form-action-optin')
            ->with([
                'crmFields' => CrmField::query()->orderBy('label')->get(),
            ]);
    }
}
