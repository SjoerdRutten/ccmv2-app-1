<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

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
        if ($data = $this->getQuery()) {
            $data = $data->raw();

            return Arr::only($data, ['found', 'out_of']);
        }

        return 0;
    }

    #[computed]
    public function exampleResults()
    {
        return $this->getQuery()->get();
    }

    private function getQuery($perPage = 10)
    {
        $filterBy = $this->getQueryFilters();

        return CrmCard::search('*')
            ->options([
                'page' => 0,
                'per_page' => $perPage,
                'filter_by' => $filterBy,
            ]);
    }

    #[Computed]
    public function getQueryFilters($elements = null)
    {
        $root = ! $elements;
        $elements = $elements ?: $this->elements;

        $filters = [];
        foreach ($elements as $row) {
            if (Arr::get($row, 'type') == 'rule') {
                if ($filter = TargetGroupSelectorFacade::getFilter($row)) {
                    $filters[] = $filter;
                }
            } elseif ((Arr::get($row, 'type') == 'block') && (count(Arr::get($row, 'subelements')))) {
                if ($filter = $this->getQueryFilters(Arr::get($row, 'subelements'))) {
                    $filters[] = $filter;
                }
            }
        }

        if (count($filters)) {

            if ($root) {
                return '('.implode(' || ', $filters).')';
            } else {
                return '('.implode(' && ', $filters).')';
            }
        }

        return null;
    }

    public function render()
    {
        return view('target-group::livewire.form');
    }
}
