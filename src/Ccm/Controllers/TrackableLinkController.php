<?php

namespace Sellvation\CCMV2\Ccm\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sellvation\CCMV2\Ccm\Models\TrackableLink;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;

class TrackableLinkController extends Controller
{
    public function __invoke(Request $request, Email $email, TrackableLink $trackableLink, ?CrmCard $crmCard = null)
    {
        if ($crmCard) {
            $lastClick = $trackableLink->trackableLinkClicks()
                ->where('crm_card_id', $crmCard->id)
                ->latest()
                ->first();

            if (! $lastClick || $lastClick->created_at->diffInSeconds(now()) > 30) {
                $trackableLink->trackableLinkClicks()->create([
                    'crm_card_id' => $crmCard->id,
                ]);
            }
        }

        $link = \EmailCompiler::render($trackableLink->link, $email, $crmCard, false);

        return redirect()
            ->to($link);
    }
}
