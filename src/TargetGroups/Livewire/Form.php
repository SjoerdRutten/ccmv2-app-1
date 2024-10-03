<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Form extends Component
{
    #[Locked]
    public ?int $id = null;

    public ?string $name = null;

    public array $elements = [];

    public function mount(TargetGroup $targetGroup)
    {
        if ($targetGroup->id) {
            $this->id = $targetGroup->id;
            $this->name = $targetGroup->name;
            $this->elements = $targetGroup->filters;
        }
    }

    public function addBlock()
    {
        $index = count($this->elements);

        Arr::set($this->elements, $index, [
            'type' => 'block',
            'index' => $index,
            'name' => uniqid(),
            'operation' => 'AND',
            'subelements' => [],
        ]);
    }

    public function addSubBlock($index)
    {
        $keys = array_keys(Arr::get($this->elements, $index.'.subelements'));
        $count = Arr::last($keys) + 1;

        Arr::set($this->elements, $index.'.subelements.'.$count,
            [
                'type' => 'block',
                'index' => $index.'.subelements.'.$count,
                'name' => uniqid(),
                'operation' => 'AND',
                'subelements' => [],
            ]);
    }

    public function removeElement($index)
    {
        data_forget($this->elements, $index);
        $this->save();
    }

    public function addRule($index)
    {
        $keys = array_keys(Arr::get($this->elements, $index.'.subelements'));
        $count = Arr::last($keys) + 1;

        Arr::set($this->elements, $index.'.subelements.'.$count,
            [
                'type' => 'rule',
                'index' => $index.'.subelements.'.$count,
                'name' => uniqid(),
                'column' => '',
                'operator' => '',
            ]);
    }

    public function save()
    {
        $targetGroup = TargetGroup::updateOrCreate([
            'id' => $this->id,
        ], [
            'name' => $this->name,
            'filters' => $this->elements,
        ]);

        $this->redirectRoute('target-groups::form', $targetGroup);
    }

    #[Computed]
    public function count()
    {
        return TargetGroupSelectorFacade::count($this->elements);
    }

    #[computed]
    public function exampleResults()
    {
        return TargetGroupSelectorFacade::getQuery($this->elements, 10)->get();
    }

    #[Computed]
    public function getQueryFilters()
    {
        return TargetGroupSelectorFacade::getQueryFilters($this->elements);
    }

    public function render()
    {
        return view('target-group::livewire.form');
    }
}
