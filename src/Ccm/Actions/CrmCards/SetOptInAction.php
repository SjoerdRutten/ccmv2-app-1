<?php

namespace Sellvation\CCMV2\Ccm\Actions\CrmCards;

use Sellvation\CCMV2\Ccm\Actions\CcmAction;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class SetOptInAction extends CcmAction
{
    public string $name = 'Set opt-in voor opgegeven veld';

    public string $group = 'Crm Kaart';

    public function __construct(private CrmCard $crmCard, private CrmField $crmField) {}

    public function handle(): void
    {
        $this->crmCard->setData([
            '_'.$this->crmField->name.'_optin' => 1,
            '_'.$this->crmField->name.'_optin_timestamp' => now(),
            '_'.$this->crmField->name.'_optout' => 0,
            '_'.$this->crmField->name.'_optout_timestamp' => null,
        ]);
    }
}
