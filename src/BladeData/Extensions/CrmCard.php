<?php

namespace Sellvation\CCMV2\BladeData\Extensions;

class CrmCard extends BladeExtension
{
    public bool $showEMS = false;

    public function getVariables(): array
    {
        return [
            'crmCard' => 'CrmCard object',
            'crmCardData' => 'Array met alle CrmCard data',
        ];
    }

    public function addData(array $data): array
    {
        if (request()->has('crmId') && ! app()->isProduction()) {
            $crmId = request()->get('crmId');
        } elseif (request()->has('crm_id') && ! app()->isProduction()) {
            $crmId = request()->get('crm_id');
        } elseif (request()->cookie('crmId')) {
            $crmId = request()->cookie('crmId');
        } else {
            $crmId = 'xxxxxxxxxxx';
        }

        $crmCard = \Sellvation\CCMV2\CrmCards\Models\CrmCard::whereCrmId($crmId)->firstOrNew();

        \Context::add('crmCard', $crmCard);
        \Context::add('crmId', $crmCard->crm_id);

        $data['crmCard'] = $crmCard;
        $data['crmCardData'] = $crmCard->data ?? [];

        return $data;
    }
}
