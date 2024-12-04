<?php

namespace Sellvation\CCMV2\Sites\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPHtmlParser\Dom;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SiteLayout;
use Sellvation\CCMV2\Sites\Models\SiteScraper;

class ScrapeAndConvertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Dom $dom;

    public function __construct(private readonly SiteScraper $scraper)
    {
        $this->dom = new Dom;
    }

    public function handle(): void
    {
        $this->scraper->update([
            'status' => 'running',
            'last_scraped_at' => null,
        ]);

        $this->dom->loadFromUrl($this->scraper->url, [
            'cleanupInput' => false,
        ]);

        $this->scraper->original_html = $this->dom->outerHtml;

        $this->convertLinks('a', 'href');
        $this->convertLinks('script', 'src');
        $this->convertLinks('iframe', 'src');
        $this->convertLinks('img', 'src');
        $this->convertLinks('form', 'action');

        $this->scraper->converted_html = $this->dom->outerHtml;
        $this->scraper->save();

        if ($this->scraper->target === 'layout') {
            if (! ($siteLayout = $this->scraper->siteLayout)) {
                $siteLayout = new SiteLayout;
                $siteLayout->name = $this->scraper->layout_name;
                $siteLayout->environment()->associate($this->scraper->environment_id);
                $siteLayout->config = [];
                $siteLayout->save();

                $this->scraper->update([
                    'site_layout_id' => $siteLayout->id,
                    'layout_name' => null,
                ]);
            }
            $siteLayout->meta_title = \Arr::first($this->dom->find('title'))->innerHtml();
            $siteLayout->meta_description = \Arr::first($this->dom->find('meta[name=description]'))?->getAttribute('content');
            $siteLayout->meta_keywords = \Arr::first($this->dom->find('meta[name=keywords]'))?->getAttribute('content');

            $this->generateHeadNode();

            $siteLayout->update(['body' => $this->dom->outerHtml]);
        } elseif ($this->scraper->target === 'block') {
            $nodes = $this->dom->find($this->scraper->start_selector);

            if ($nodes->count()) {
                if (! ($siteBlock = $this->scraper->siteBlock)) {
                    $siteBlock = new SiteBlock;
                    $siteBlock->name = $this->scraper->block_name;
                    $siteBlock->environment()->associate($this->scraper->environment_id);
                    $siteBlock->save();

                    $this->scraper->update([
                        'site_block_id' => $siteBlock->id,
                        'block_name' => null,
                    ]);
                }

                $siteBlock->update(['body' => \Arr::first($nodes)->outerHtml()]);
            }
        }

        $this->scraper->update([
            'status' => 'done',
            'last_scraped_at' => now(),
        ]);

    }

    private function convertUrl($url)
    {
        if (! empty($url)) {
            $parsedUrl = parse_url($url);

            if (! \Arr::has($parsedUrl, 'host')) {
                $url = $this->scraper->base_url.\Arr::get($parsedUrl, 'path');
            }
        }

        return $url;
    }

    private function convertLinks($tag, $attribute)
    {
        /** @var Dom\HtmlNode $node */
        foreach ($this->dom->find($tag) as $node) {
            $link = $node->getAttribute($attribute);
            $node->setAttribute($attribute, $this->convertUrl($link));
        }
    }

    private function generateHeadNode()
    {
        /** @var Dom\HtmlNode $htmlNode */
        $htmlNode = \Arr::first($this->dom->find('html'));
        $bodyNode = \Arr::first($this->dom->find('body'));
        $headNode = \Arr::first($htmlNode->find('head'));

        // Slots in the head component
        $ccmHeadNode = new Dom\HtmlNode('x-sites::head');
        $metaSlot = new Dom\HtmlNode('x-slot:meta');
        $cssSlot = new Dom\HtmlNode('x-slot:css');
        $jsSlot = new Dom\HtmlNode('x-slot:js');

        $ccmHeadNode->addChild($metaSlot);
        $ccmHeadNode->addChild($cssSlot);
        $ccmHeadNode->addChild($jsSlot);

        $attributes = [
            'site',
            'layout',
            'page',
            'crmCard',
            'crmCardData',
        ];

        // Pass these attributes from the layout to the head
        foreach ($attributes as $attribute) {
            $ccmHeadNode->setAttribute(':'.\Str::snake($attribute), '$'.$attribute);
        }

        // remove meta tags, they are in de head component
        foreach ($headNode->find('meta') as $metaNode) {
            $metaSlot->delete();
        }
        // Move script tags to component
        foreach ($headNode->find('script') as $scriptNode) {
            $jsSlot->addChild($scriptNode);
        }
        // Move link tags to component
        foreach ($headNode->find('link') as $linkNode) {
            if ($linkNode->getAttribute('rel') === 'stylesheet') {
                $cssSlot->addChild($linkNode);
            }
        }

        $headNode->delete();
        $htmlNode->insertBefore($ccmHeadNode, $bodyNode->id());
    }

    public function failed()
    {
        $this->scraper->update([
            'status' => 'failed',
            'last_scraped_at' => null,
        ]);
    }
}
