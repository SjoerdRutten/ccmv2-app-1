<?php

declare(strict_types=1);

use Sellvation\CCMV2\Sites\Models\Site;
use Sellvation\CCMV2\Sites\Models\SitePage;

if (! function_exists('webpageLink')) {
    function webpageLink(int $sitePageId, array $parameters = [], ?int $siteId = null): string
    {
        $site = $siteId ? Site::find($siteId) : Site::first();

        if ($sitePage = SitePage::find($sitePageId)) {
            $parameters['sitePage'] = $sitePage;

            return route('frontend::sitePage.'.$site->id, $parameters);
        } else {
            return route('frontend::homePage.'.$site->id, $parameters);
        }
    }
}
