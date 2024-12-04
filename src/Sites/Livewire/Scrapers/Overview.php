<?php

namespace Sellvation\CCMV2\Sites\Livewire\Scrapers;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteScraper;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
        'site_category_id' => null,
    ];

    public function updated($property, $value)
    {
        if (\Str::startsWith($property, 'filter.')) {
            $this->resetPage();
        }
    }

    public function getScrapers()
    {
        return SiteScraper::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->when($this->filter['site_category_id'], function ($query, $filter) {
                $query->where('site_category_id', $this->filter['site_category_id']);
            })
            ->paginate();
    }

    public function removeScraper(SiteScraper $scraper)
    {
        $scraper->delete();
    }

    public function render()
    {
        return view('sites::livewire.scrapers.overview')
            ->with([
                'siteCategories' => SiteCategory::all(),
                'scrapers' => $this->getScrapers(),
            ]);
    }
}
