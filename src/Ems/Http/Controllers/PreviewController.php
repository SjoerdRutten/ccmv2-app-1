<?php

namespace Sellvation\CCMV2\Ems\Http\Controllers;

use Illuminate\Http\Request;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class PreviewController extends EmailController
{
    public function __invoke(Request $request, Email $email, CrmCard $crmCard)
    {
        return response($email->getCompiledHtml(crmCard: $crmCard, tracking: false, online: true));
    }
}
