<?php

namespace Sellvation\CCMV2\Forms\Actions;

use Illuminate\Contracts\View\View;

class FormActionUpdateBrowser extends FormAction
{
    public bool $alwaysExecute = true;

    public string $name = 'Update Algemeen velden CRM Kaart';

    public function handle(): void
    {
        $crmCard = $this->formResponse->crmCard;
        $headers = $this->formResponse->headers;

        $crmCard->browser_ua = \Arr::get($headers, 'user-agent');

        $crmCard->latest_ip = $this->formResponse->ip_address;
        $crmCard->first_ip = empty($crmCard->first_ip) ? $this->formResponse->ip_address : $crmCard->first_ip;

        $crmCard->save();

    }

    public function form(): ?View
    {
        return null;
    }
}
