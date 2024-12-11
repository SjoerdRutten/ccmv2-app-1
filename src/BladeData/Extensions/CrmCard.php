<?php

namespace Sellvation\CCMV2\BladeData\Extensions;

class CrmCard extends BladeExtension
{
    public function getVariables(): array
    {
        return [
            'crmCard' => 'CrmCard object',
            'crmCardData' => 'Array met alle CrmCard data',
        ];
    }

    public function addData(array $data): array
    {
        if (request()->cookie('crmId')) {
            $crmCard = \Sellvation\CCMV2\CrmCards\Models\CrmCard::whereCrmId(request()->cookie('crmId'))->first();
            \Context::add('crmCard', $crmCard);

            $data['crmCard'] = $crmCard;
            $data['crmCardData'] = $crmCard->data;
        }

        return $data;
    }
}
