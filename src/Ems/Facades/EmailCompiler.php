<?php

namespace Sellvation\CCMV2\Ems\Facades;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailContent;
use Symfony\Component\DomCrawler\Crawler;

class EmailCompiler
{
    public function compile(Email $email, CrmCard $crmCard, bool $tracking = true, bool $onlineVersion = false): string
    {
        \Context::add('crmCard', $crmCard);
        \Context::add('email', $email);

        $html = $email->html_type === Email::STRIPO ? $email->stripo_html : $email->html;

        $html = $this->render($html, $email, $crmCard, $tracking, $onlineVersion);

        if ($email->html_type === Email::STRIPO) {
            $html = \Stripo::compileTemplate($html, $email->stripo_css);
        }

        if ($tracking) {
            $html = $this->addTrackingPixel($email, $crmCard, $onlineVersion, $html);
            $html = $this->makeTrackingLinks($email, $crmCard, $html);
        }

        return $html;
    }

    public function render($html, ?Email $email = null, ?CrmCard $crmCard = null, bool $tracking = true, bool $online = false): string
    {
        $crmCard = $crmCard ?? \Context::get('crmCard');
        $email = $email ?? \Context::get('email');

        // Fill data for template
        $data = [];
        $data['email'] = $email;
        $data['crmCard'] = $crmCard;
        $data['crmCardData'] = $crmCard->data;
        $data['isOnline'] = $online;
        $data['preHeader'] = $email->pre_header;

        // Generate links for opt-out and the online version
        if ($email->id && $crmCard->id) {
            $optOutLink = URL::signedRoute('public.opt_out', ['email' => $email, 'crmCard' => $crmCard], null, false);
            $onlineVersionLink = URL::signedRoute('public.online_version', ['email' => $email, 'crmCard' => $crmCard], null, false);

            $data['optOutLink'] = empty($email->optout_url) ? $optOutLink : $email->optout_url;
            $data['onlineVersionLink'] = $onlineVersionLink;
        } else {
            $data['optOutLink'] = null;
            $data['onlineVersionLink'] = null;
        }

        if ($tracking) {
            $html = $this->makeTrackingLinks($email, $crmCard, $html);
        }

        $data = \BladeExtensions::mergeData($data, 'EMS');

        return Blade::render(
            $html,
            $data,
        );
    }

    /**
     * @return array
     *
     * Get all the links from a html fragment, this will be done before the blade is rendered
     */
    public function getLinksFromHtml($html, $links = []): array
    {
        /**
         * Get all the emailContent directives in the HTML and obtain the links in these
         * contents. This will be done recursively
         */
        preg_match_all('/@emailContent(\((\d), (.*)\))?/', $html, $emailContents);

        foreach ($emailContents[2] as $emailContentId) {
            if ($emailContent = EmailContent::find($emailContentId)) {
                $links = $this->getLinksFromHtml($emailContent->content, $links);
            }
        }

        /**
         * Crawl the html for all a tags and get the href and content of that tag. If a link
         * is used multiple times in the html the count of that link wel be increased so every
         * link will be online once in the links array
         */
        $crawler = new Crawler($html);
        $crawler->filter('a')->each(function (Crawler $node, $i) use (&$links) {
            $href = $node->attr('href');

            if (! empty($href)) {
                $found = \Arr::first($links, function ($value, $key) use ($href, &$links) {
                    if ($value['link'] === $href) {
                        $links[$key]['count']++;
                    }
                }, false);

                if (! $found) {
                    $links[] = [
                        'link' => $href,
                        'html' => $node->html(),
                        'text' => $node->text(),
                        'count' => 1,
                    ];
                }
            }
        });

        return $links;
    }

    private function addTrackingPixel(Email $email, CrmCard $crmCard, bool $onlineVersion, $html): string
    {
        $dom = new Dom;
        $dom->load($html);

        $node = new HtmlNode('img');
        $node->setAttribute('src', $this->getDomain($email).URL::signedRoute('public::tracking_pixel', ['email' => $email->id, 'crmCard' => $crmCard->id, 'onlineVersion' => $onlineVersion], null, false));

        /** @var HtmlNode $body */
        $body = $dom->find('body')[0];
        $firstChild = $body->firstChild();
        $body->addChild($node, $firstChild->id());

        return $dom->outerHtml;
    }

    private function makeTrackingLinks(Email $email, CrmCard $crmCard, $html): string
    {

        $search = [];
        $replace = [];
        foreach ($email->trackableLinks as $link) {
            $search[] = $link->link;
            $replace[] = $this->getDomain($email).URL::signedRoute('public::trackable_link', [$email, $link, $crmCard], null, false);
        }

        return Str::replace($search, $replace, $html);
    }

    private function getDomain(Email $email)
    {
        $site = $email->site;

        return $site ? 'https://'.$site->domain : config('app.url');
    }
}
