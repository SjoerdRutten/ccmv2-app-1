<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Sellvation\CCMV2\Ccm\Actions\CrmCards\SetConfirmedOptInAction;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class FormActionSetCrmCardField extends FormAction
{
    public string $name = 'Set opt-in en confirmed opt-in voor geselecteerd veld';

    public function handle(): void
    {
        $params = $this->params;

        if ($crmField = CrmField::find(\Arr::get($params, 'crm_field_id'))) {

            (new SetConfirmedOptInAction($this->formResponse->crmCard, $crmField))->handle();

            $this->formResponse->crmCard->save();
        }
    }

    public function form(): ?View
    {
        return view('forms::actions.form-action-optin')
            ->with([
                'crmFields' => CrmField::query()
                    ->isMediaFieldType()
                    ->orderBy('label')
                    ->get(),
            ]);
    }
}
