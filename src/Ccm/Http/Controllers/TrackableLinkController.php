<?php

namespace Sellvation\CCMV2\Ccm\Http\Controllers;

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

        if (! empty($email->utm_code)) {
            $parsedUrl = parse_url($link);

            parse_str($email->utm_code, $query1);
            parse_str(\Arr::get($parsedUrl, 'query'), $query2);

            $query = array_merge($query1, $query2);

            $parsedUrl['query'] = http_build_query($query);

            $link = $this->unparseUrl($parsedUrl);
        }

        return redirect()
            ->to($link);
    }

    private function unparseUrl($parsed_url)
    {

        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : '';

        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';

        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';

        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';

        $pass = isset($parsed_url['pass']) ? ':'.$parsed_url['pass'] : '';

        $pass = ($user || $pass) ? "$pass@" : '';

        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';

        $query = isset($parsed_url['query']) ? '?'.$parsed_url['query'] : '';

        $fragment = isset($parsed_url['fragment']) ? '#'.$parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";

    }
}
