<?php

namespace Sellvation\CCMV2\Sites\Livewire\Imports;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Imports\Forms\ImportForm;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteImport;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SiteImport $siteImport;

    public ImportForm $form;

    public function mount(SiteImport $siteImport)
    {
        $this->siteImport = $siteImport;
        $this->form->setSiteImport($siteImport);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal(title: 'JS/CSS is opgeslagen', href: route('cms::imports::edit', $this->siteImport->id));
    }

    public function render()
    {
        return view('sites::livewire.imports.edit')
            ->with([
                'siteCategories' => SiteCategory::orderBy('name')->get(),
            ]);
    }
}
