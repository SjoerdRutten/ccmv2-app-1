<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Jobs\AddTagToCrmCardJob;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Form extends Component
{
    #[Locked]
    public ?int $id = null;

    public ?string $name = null;

    public array $elements = [];

    public string $tag = '';

    public string $fieldName = 'v23_0091_doelgroepen_kenmerk';

    public string $seperator = ',';

    public int $count = 0;

    public bool $showTagModal = false;

    public function mount(TargetGroup $targetGroup)
    {
        if ($targetGroup->id) {
            $this->id = $targetGroup->id;
            $this->name = $targetGroup->name;
            $this->elements = $targetGroup->filters;
        }

        $this->updateCount();
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
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
                'value' => null,
                'from' => null,
                'to' => null,
                'columnType' => null,
            ]);
    }

    public function save($redirect = true)
    {
        $this->validate();

        $targetGroup = TargetGroup::updateOrCreate([
            'id' => $this->id,
        ], [
            'name' => $this->name,
            'filters' => $this->elements,
        ]);

        if ($redirect) {
            $this->dispatch('show-modal-success', title: 'Selectie opgeslagen', href: route('target-groups::form', $targetGroup));
        }
    }

    public function addTag()
    {
        $this->save(false);

        $this->validate([
            'tag' => 'required',
            'fieldName' => 'required',
            'seperator' => 'required',
        ]);

        $batch = \Bus::batch([])
            ->name('AddTagToCrmCardJob - '.$this->id);

        $page = 0;
        do {
            $rows = TargetGroupSelectorFacade::getQuery($this->elements, 100, $page)->get();

            foreach ($rows as $row) {
                $batch->add(new AddTagToCrmCardJob($row, $this->tag, $this->fieldName, $this->seperator));
            }

            $page++;
        } while (count($rows) > 0);

        $batch->dispatch();
    }

    #[On('update-count')]
    public function updateCount()
    {
        $this->count = TargetGroupSelectorFacade::count($this->elements);
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
