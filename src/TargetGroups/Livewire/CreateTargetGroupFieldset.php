<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupFieldset;
use Symfony\Contracts\Service\Attribute\Required;

class CreateTargetGroupFieldset extends Component
{
    public int $count;

    #[Required]
    public string $selectedIds = '';

    #[Required]
    public string $name = '';

    protected array $rules = [
        'name' => 'required',
        'selectedIds' => 'required',
    ];

    #[Computed]
    public function targetGroupFieldsets()
    {
        return TargetGroupFieldset::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate();

        $ids = explode(',', $this->selectedIds);

        $fieldSet = TargetGroupFieldset::create(['name' => $this->name]);
        $fieldSet->crmFields()->sync($ids);

        $this->dispatch('refresh-field-sets', $fieldSet->id);
    }

    public function render()
    {
        return view('target-group::livewire.create-target-group-fieldset');
    }
}
