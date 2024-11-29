<?php

namespace Sellvation\CCMV2\Sites\Livewire\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Pages\Forms\PageForm;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteLayout;
use Sellvation\CCMV2\Sites\Models\SitePage;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SitePage $sitePage;

    public PageForm $form;

    public function mount(SitePage $sitePage)
    {
        $this->sitePage = $sitePage;
        $this->form->setSitePage($sitePage);
    }

    public function updated($property, $value)
    {
        if (($property === 'form.name') && ($this->form->slugGenerated)) {
            $this->form->slug = \Str::slug($this->form->name);
        } elseif ($property === 'form.slug') {
            $this->form->slugGenerated = false;
        }
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
            ]);
    }
}
