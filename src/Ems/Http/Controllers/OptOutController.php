<?php

namespace Sellvation\CCMV2\Ems\Http\Controllers;

use App\Http\Controllers\Controller;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class OptOutController extends Controller
{
    public function __invoke(Email $email, CrmCard $crmCard)
    {
        $crmCard->optout($email, $email->recipientCrmField);
        $crmCard->save();

        return response('OPT OUT')
            ->withCookie($crmCard->getCookie());
    }
}
