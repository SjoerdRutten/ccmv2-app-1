<?php

namespace Sellvation\CCMV2\Ems\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class OnlineVersionController extends Controller
{
    public function __invoke(Request $request, Email $email, CrmCard $crmCard)
    {
        return response($email->getCompiledHtml($crmCard, true, true))
            ->withCookie(cookie('crmId', $crmCard->crm_id, 60 * 24 * 365));
    }
}
