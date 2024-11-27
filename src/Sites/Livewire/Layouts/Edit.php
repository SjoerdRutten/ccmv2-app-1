<?php

namespace Sellvation\CCMV2\Sites\Livewire\Layouts;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Layouts\Forms\LayoutForm;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteLayout;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SiteLayout $siteLayout;

    public LayoutForm $form;

    public function mount(SiteLayout $siteLayout)
    {
        $this->siteLayout = $siteLayout;
        $this->form->setSiteLayout($siteLayout);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal(title: 'Layout is opgeslagen', href: route('cms::layouts::edit', $this->siteLayout->id));
    }

    public function render()
    {
        return view('sites::livewire.layouts.edit')
            ->with([
                'siteCategories' => SiteCategory::orderBy('name')->get(),
            ]);
    }
}
