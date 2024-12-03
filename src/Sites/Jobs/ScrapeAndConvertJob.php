<?php

namespace Sellvation\CCMV2\Sites\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPHtmlParser\Dom;
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
            //TODO: Header aanpassen naar stub

            $this->scraper->siteLayout->update(['body' => $this->dom->outerHtml]);
        } elseif ($this->scraper->target === 'block') {
            $nodes = $this->dom->find($this->scraper->start_selector);

            if ($nodes->count()) {
                /** @var Dom\HtmlNode $node */
                $node = $nodes->offsetGet(0);
                $this->scraper->siteBlock->update(['body' => $node->outerHtml()]);
            }
        }

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
}
