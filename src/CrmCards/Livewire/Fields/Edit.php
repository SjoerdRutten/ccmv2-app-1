<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms\CrmFieldForm;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class Edit extends Component
{

    public CrmField $crmField;

    public CrmFieldForm $form;

    public function mount()
    {
        $this->form->setCrmField($this->crmField);
    }


    public function save()
    {
        dd($this->crmField);
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.edit');
    }
}
