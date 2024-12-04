<?php

namespace Sellvation\CCMV2\Sites\Livewire\Blocks;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Forms\Models\Form;
use Sellvation\CCMV2\Sites\Livewire\Blocks\Forms\BlockForm;
use Sellvation\CCMV2\Sites\Models\SiteBlock;
use Sellvation\CCMV2\Sites\Models\SiteCategory;

class Edit extends Component
{
    use HasModals;
    use WithFileUploads;

    public SiteBlock $siteBlock;

    public BlockForm $form;

    public function mount(SiteBlock $siteBlock)
    {
        $this->siteBlock = $siteBlock;
        $this->form->setSiteBlock($siteBlock);
    }

    public function save()
    {
        $this->siteBlock = $this->form->save();

        $this->showSuccessModal(title: 'Contentblok is opgeslagen', href: route('cms::blocks::edit', $this->siteBlock->id));
    }

    public function render()
    {
        return view('sites::livewire.blocks.edit')
            ->with([
                'siteCategories' => SiteCategory::orderBy('name')->get(),
                'forms' => Form::orderBy('name')->get(),
            ]);
    }
}
