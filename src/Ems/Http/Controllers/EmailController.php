<?php

namespace Sellvation\CCMV2\Ems\Http\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Sites\Models\Site;

class EmailController extends Controller
{
    protected Site $site;

    protected CrmCard $crmCard;

    public function __construct()
    {
        $this->getCrmCard();
    }

    private function getCrmCard()
    {
        if (request()->cookie('crmId')) {
            $this->crmCard = CrmCard::whereCrmId(request()->cookie('crmId'))->first();
            \Context::add('crmCard', $this->crmCard);
        }
    }
}
