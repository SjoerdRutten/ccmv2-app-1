<?php

namespace Sellvation\CCMV2\Sites\Http\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Sites\Models\Site;

class FrontendController extends Controller
{
    protected Site $site;

    protected CrmCard $crmCard;

    public function __construct()
    {
        if ($site = Site::where('domain', request()->host())->first()) {
            $this->site = $site;

            $this->getCrmCard();
        } else {
            abort(404);
        }
    }

    private function getCrmCard()
    {
        if (request()->cookie('crmId')) {
            $this->crmCard = CrmCard::whereCrmId(request()->cookie('crmId'))->first();
            \Context::add('crmCard', $this->crmCard);
        }
    }
}
