<?php

namespace Sellvation\CCMV2\Ems\Facades;

use Illuminate\Support\Facades\Blade;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class EmailCompiler
{
    public function compile(Email $email, CrmCard $crmCard, bool $tracking = true)
    {
        \Context::add('crmCard', $crmCard);

        // Fill data for template
        $data = [];
        $data['email'] = $email;
        $data['crmCard'] = $crmCard;
        $data['crmCardData'] = $crmCard->data;

        $data = \BladeExtensions::mergeData($data, 'EMS');

        if ($email->html_type === 'STRIPO') {
            $html = Blade::render(
                $email->stripo_html,
                $data,
            );

            $html = \Stripo::compileTemplate($html, $email->stripo_css);
        } else {
            $html = Blade::render(
                $email->html,
                $data,
            );
        }

        if ($tracking) {
            $html = $this->addTrackingPixel($html, $crmCard);
            $html = $this->makeTrackingLinks($html);
        }

        return $html;
    }

    private function addTrackingPixel(string $html, CrmCard $crmCard): string
    {
        // TODO

        return $html;
    }

    private function makeTrackingLinks($html): string
    {
        // TODO

        return $html;
    }
}
