<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Jobs\AddTagToCrmCardJob;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupFieldset;
use Storage;

class Form extends Component
{
    use HasModals;

    #[Locked]
    public ?int $id = null;

    public TargetGroup $targetGroup;

    public ?string $name = null;

    public array $elements = [];

    public string $tag = '';

    public string $fieldName = 'v23_0091_doelgroepen_kenmerk';

    public string $seperator = ',';

    public int $count = 0;

    public bool $showTagModal = false;

    public array $export = [
        'targetGroupFieldSetId' => null,
        'file_type' => 'xlsx',
    ];

    public function mount(TargetGroup $targetGroup)
    {
        if ($targetGroup->id) {
            $this->id = $targetGroup->id;
            $this->name = $targetGroup->name;
            $this->elements = $targetGroup->filters;

            $this->targetGroup = $targetGroup;
        } else {
            $this->targetGroup = new TargetGroup;
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
        Arr::set($this->elements, $index, null);
    }

    public function addRule($index)
    {
        //        $keys = array_keys(Arr::get($this->elements, $index.'.subelements'));
        //        $count = Arr::last($keys) + 1;

        $count = uniqid();

        Arr::set($this->elements, $index.'.subelements.'.$count,
            [
                'type' => 'rule',
                'active' => true,
                'id' => uniqid(),
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
            $this->showSuccessModal(title: 'Selectie opgeslagen', href: route('target-groups::form', $targetGroup));
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

        $this->showTagModal = false;

        $this->showSuccessModal(title: 'Kenmerken worden toegevoegd', message: 'Kenmerken worden toegevoegd op de achtergrond, dit kan enkele minuten duren');
    }

    public function startExport()
    {
        $this->targetGroup
            ->targetGroupExports()
            ->create([
                'target_group_fieldset_id' => $this->export['targetGroupFieldSetId'],
                'file_type' => $this->export['file_type'],
            ]);

        $this->reset(['export']);
        $this->showSuccessModal('Export gestart', 'Export wordt gestart, dit kan enkele minuten duren.');
    }

    public function downloadExport(TargetGroupExport $targetGroupExport)
    {
        return Storage::disk($targetGroupExport->disk)->download($targetGroupExport->path);
    }

    public function deleteExport(TargetGroupExport $targetGroupExport)
    {
        $targetGroupExport->delete();
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

    #[On('refresh-field-sets')]
    public function refreshFieldSets($id)
    {
        $this->targetGroupFieldSetId = $id;
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('target-group::livewire.form')
            ->with([
                'fieldSets' => TargetGroupFieldset::orderBy('name')->get(),
            ]);
    }
}
