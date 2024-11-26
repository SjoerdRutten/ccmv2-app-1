<?php

namespace Sellvation\CCMV2\Sites\Livewire\Sites;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Sites\Forms\SiteForm;
use Sellvation\CCMV2\Sites\Models\Site;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SitePage;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public Site $site;

    public SiteForm $form;

    public function mount(Site $site)
    {
        $this->site = $site;
        $this->form->setSite($site);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal(title: 'Site is opgeslagen', href: route('cms::sites::edit', $this->site->id));
    }

    public function render()
    {
        return view('sites::livewire.sites.edit')
            ->with([
                'siteCategories' => SiteCategory::orderBy('name')->get(),
                'sitePages' => SitePage::query()->orderBy('name')->get(),
            ]);
    }
}
