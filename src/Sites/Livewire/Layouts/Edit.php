<?php

namespace Sellvation\CCMV2\Sites\Livewire\Layouts;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Sites\Livewire\Layouts\Forms\LayoutForm;
use Sellvation\CCMV2\Sites\Models\SiteCategory;
use Sellvation\CCMV2\Sites\Models\SiteImport;
use Sellvation\CCMV2\Sites\Models\SiteLayout;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SiteLayout $siteLayout;

    public LayoutForm $form;

    public $importId = null;

    public $layoutImportJs;

    public $layoutImportCss;

    public function mount(SiteLayout $siteLayout)
    {
        $this->siteLayout = $siteLayout;
        $this->form->setSiteLayout($siteLayout);

        $this->loadImports();
    }

    public function updated($property, $value)
    {
        if ($property === 'importId') {
            $this->addItemToList(SiteImport::find($value));
        }
    }

    public function reOrderSiteImport(SiteImport $import, $position)
    {
        $list = $import->js ? $this->siteLayout->siteImportsJs : $this->siteLayout->siteImportsCss;

        /** @var SiteImport $import */
        $import = $list->where('id', $import->id)->first();

        $index = 0;
        foreach ($list as $siteImport) {
            if ($index === $position) {
                $index++;
            }

            if ($siteImport->id !== $import->id) {
                $siteImport->pivot->position = $index++;
            } else {
                $siteImport->pivot->position = $position;
            }
            $siteImport->pivot->save();
        }

        $this->loadImports();
    }

    public function removeItemFromList(SiteImport $import)
    {
        $this->siteLayout->siteImports()->detach($import);
        $this->loadImports();
        $list = $import->js ? $this->siteLayout->siteImportsJs : $this->siteLayout->siteImportsCss;
        $this->reIndexImportLists($list);
        $this->loadImports();
    }

    public function addItemToList(SiteImport $import)
    {
        /** @var Collection $list */
        $list = $import->js ? $this->siteLayout->siteImportsJs : $this->siteLayout->siteImportsCss;
        $this->siteLayout->siteImports()->attach($import, ['position' => $list->last()?->pivot?->position + 1]);
        $this->loadImports();
        $this->reset('importId');
    }

    private function loadImports()
    {
        $this->siteLayout->refresh();
        $this->layoutImportJs = $this->siteLayout->siteImportsJs;
        $this->layoutImportCss = $this->siteLayout->siteImportsCss;
    }

    private function reIndexImportLists($list)
    {
        foreach ($list as $key => $item) {
            $item->pivot->position = $key;
            $item->pivot->save();
        }
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
                'importsCSS' => SiteImport::isCss()
                    ->whereNotIn('id', $this->layoutImportCss->pluck('id')->toArray())
                    ->orderBy('name')
                    ->get(),
                'importsJS' => SiteImport::isJs()
                    ->whereNotIn('id', $this->layoutImportJs->pluck('id')->toArray())
                    ->orderBy('name')
                    ->get(),
            ]);
    }
}
