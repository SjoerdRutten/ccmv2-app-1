<?php

namespace Sellvation\CCMV2\Sites\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Pages\Forms\PageForm;
use Sellvation\CCMV2\Sites\Models\Site;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteLayout;
use Sellvation\CCMV2\Sites\Models\SitePage;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SitePage $sitePage;

    public PageForm $form;

    public $layoutConfigBlocks = [];

    public function mount(SitePage $sitePage)
    {
        $this->sitePage = $sitePage;
        $this->form->setSitePage($sitePage);

        $this->layoutConfigBlocks = $sitePage->siteLayout?->config ?: [];
    }

    public function updated($property, $value)
    {
        if (($property === 'form.name') && ($this->form->slugGenerated)) {
            $this->form->slug = \Str::slug($this->form->name);
        } elseif ($property === 'form.slug') {
            $this->form->slugGenerated = false;
        } elseif ($property === 'form.site_layout_id') {
            if ($siteLayout = SiteLayout::find($value)) {
                $this->sitePage->siteLayout()->associate($siteLayout);
                $this->form->setSitePageConfig($siteLayout);
            } else {
                $this->sitePage->siteLayout()->dissociate();
            }
            $this->layoutConfigBlocks = $this->sitePage->siteLayout?->config ?: [];
        }
    }

    public function addBlockToList($list)
    {
        $this->form->config[$list][] = null;
    }

    public function removeBlockFromList($list, $index)
    {
        \Arr::pull($this->form->config, $list.'.'.$index);
    }

    public function reOrderBlocks($list, $from, $to)
    {
        $result = [];
        $item = $this->form->config[$list][$from];
        foreach ($this->form->config[$list] as $key => $row) {
            if (count($result) === $to) {
                $result[] = $item;
            }
            if ($key !== $from) {
                $result[] = $row;
            }
            if (count($result) === $to) {
                $result[] = $item;
            }
        }

        $this->form->config[$list] = $result;
    }

    public function save()
    {
        $this->sitePage = $this->form->save();

        $this->showSuccessModal(title: 'Pagina is opgeslagen', href: route('cms::pages::edit', $this->sitePage->id));
    }

    public function render()
    {
        return view('sites::livewire.pages.edit')
            ->with([
                'siteCategories' => SiteCategory::orderBy('name')->get(),
                'siteLayouts' => SiteLayout::orderBy('name')->get(),
                'siteBlocks' => SiteBlock::orderBy('name')->get(),
                'sites' => Site::orderBy('name')->get(),
            ]);
    }
}
