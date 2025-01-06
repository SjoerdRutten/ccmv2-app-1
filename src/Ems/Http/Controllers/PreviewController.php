<?php

namespace Sellvation\CCMV2\Ems\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class PreviewController extends EmailController
{
    public function __invoke(Request $request, Email $email, CrmCard $crmCard)
    {
        \Context::add('crmCard', $crmCard);

        // Fill data for template
        $data = [];
        $data['email'] = $email;
        $data['crmCard'] = $crmCard;

        $data = \BladeExtensions::mergeData($data, 'EMS');

        $content = Blade::render(
            $email->html,
            $data,
        );

        return response($content);
    }
}
