<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;
use Sellvation\CCMV2\Ccm\Actions\CrmCards\SetOptInAction;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class FormActionSetOptins extends FormAction
{
    public bool $alwaysExecute = true;

    public string $name = 'Set opt-in voor optin velden in formulier';

    public function handle(): void
    {
        foreach (\Arr::get($this->formResponse->data, 'optin', []) as $optin) {
            $crmField = CrmField::where('name', $optin)->first();
            (new SetOptInAction($this->formResponse->crmCard, $crmField))->handle();
        }

        $this->formResponse->crmCard->save();
    }

    public function form(): ?View
    {
        return null;
    }
}
