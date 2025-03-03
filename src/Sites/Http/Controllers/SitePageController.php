<?php

namespace Sellvation\CCMV2\Sites\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SitePage;

class SitePageController extends FrontendController
{
    public function __invoke(Request $request, SitePage $sitePage)
    {
        // If homepage is asked, get the homepage of the site
        if (! $sitePage->id) {
            $sitePage = $this->site->sitePage;
        }

        // No page found
        if (! $sitePage) {
            abort(404);
        }

        $this->saveVisit($sitePage);

        // Fill data for template
        $data = [];
        $data['site'] = $this->site;
        $data['page'] = $sitePage;
        $data['layout'] = $sitePage->siteLayout;

        $data = \BladeExtensions::mergeData($data, 'CMS');

        foreach ($sitePage->siteLayout->config as $row) {
            $data[$row['key']] = '';

            if (\Arr::get($row, 'multiple') && is_array(\Arr::get($sitePage->config, $row['key']))) {
                foreach (\Arr::get($sitePage->config, $row['key']) as $blockId) {
                    if ($block = SiteBlock::find($blockId)) {
                        $blockData = $data;
                        $blockData['form'] = '';
                        if ($block->form) {
                            $blockData['form'] = Blade::render($block->form->html_form, $data);
                        }
                        $data[$row['key']] .= Blade::render($block->body, $blockData);
                    }
                }
            } else {
                if ($block = SiteBlock::find(\Arr::get($sitePage->config, $row['key']))) {
                    $blockData = $data;
                    $blockData['form'] = '';
                    if ($block->form) {
                        $blockData['form'] = Blade::render($block->form->html_form, $data);
                    }

                    $data[$row['key']] = Blade::render($block->body, $blockData);
                }
            }
        }

        if (! \Arr::has($data, 'crmCard')) {
            $data['crmCard'] = new CrmCard;
        }

        $content = Blade::render(
            $sitePage->siteLayout->body,
            $data,
        );

        $response = response($content);

        if (($crmCard = \Arr::get($data, 'crmCard')) && $crmCard->id) {
            $response->withCookie($crmCard->getCookie());    // Set cookie for 365 days
        }

        return $response;
    }

    private function saveVisit(SitePage $sitePage)
    {
        //        $agent = new Agent;

        $sitePage->sitePageVisits()->create([
            'crm_id' => request()->cookie('crmId'),
            'browser_ua' => request()->userAgent(),
            'browser' => '', // $agent->browser(),
            'browser_device_type' => '', // $agent->deviceType(),
            'browser_device' => '', // $agent->device(),
            'browser_os' => '', // $agent->platform(),
            'ip' => request()->ip(),
            'uri' => request()->getRequestUri(),
            'referer' => request()->headers->get('referer'),
        ]);
    }
}
