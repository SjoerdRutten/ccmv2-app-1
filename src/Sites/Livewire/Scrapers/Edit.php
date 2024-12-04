<?php

namespace Sellvation\CCMV2\Sites\Livewire\Scrapers;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Jobs\ScrapeAndConvertJob;
use Sellvation\CCMV2\Sites\Livewire\Scrapers\Forms\ScraperForm;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SiteLayout;
use Sellvation\CCMV2\Sites\Models\SiteScraper;

class Edit extends Component
{
    use HasModals;

    public SiteScraper $siteScraper;

    public ScraperForm $form;

    public function mount(SiteScraper $siteScraper)
    {
        $this->siteScraper = $siteScraper;
        $this->form->setSiteScraper($siteScraper);
    }

    public function save()
    {
        $this->siteScraper = $this->form->save();

        $this->showSuccessModal(title: 'Scraper is opgeslagen, je kan deze uitvoeren vanaf het overzicht', href: route('cms::scrapers::edit', $this->siteScraper->id));
    }

    public function run()
    {
        $this->siteScraper = $this->form->save();
        ScrapeAndConvertJob::dispatch($this->siteScraper);

        $this->showSuccessModal(title: 'Scraper wordt gestart, dit kan enkele minuten duren', href: route('cms::scrapers::edit', $this->siteScraper->id));
    }

    public function render()
    {
        return view('sites::livewire.scrapers.edit')
            ->with([
                'siteLayouts' => SiteLayout::orderBy('name')->get(),
                'siteBlocks' => SiteBlock::orderBy('name')->get(),
            ]);
    }
}
