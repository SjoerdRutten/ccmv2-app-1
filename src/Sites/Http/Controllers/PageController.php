<?php

namespace Sellvation\CCMV2\Sites\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Sellvation\CCMV2\Sites\Models\SitePage;

class PageController extends FrontendController
{
    public function __invoke(Request $request, SitePage $sitePage)
    {
        // If homepage is asked, get the homepage of the site
        if (! $sitePage->id) {
            $sitePage = $this->site->sitePage;
        }

        // No page found
        if (! $sitePage->id) {
            abort(404);
        }

        // Fill data for template
        $data = [];
        $data['site'] = $this->site;
        $data['page'] = $sitePage;
        $data['layout'] = $sitePage->siteLayout;
        $data['crmCard'] = $this->crmCard;

        // TODO: Extensies moeten ook data toe kunnen voegen
        // TODO: De blokken van de pagina moeten in de layout geplaatst worden

        $content = Blade::render(
            $sitePage->siteLayout->body,
            $data,
        );

        $response = response($content);

        if ($this->crmCard) {
            $response->withCookie(cookie('crmId', $this->crmCard->crm_id, 60 * 24 * 365));    // Set cookie for 365 days
        }

        return $response;
    }
}
