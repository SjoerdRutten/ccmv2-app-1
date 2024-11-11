<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class Overview extends Component
{
    public array $crmFields = [];

    #[Url]
    public array $filter = [
        'crm_field_category_id' => null,
        'q' => null,
    ];

    public function mount()
    {
        $this->getCrmFields();
    }

    public function updated($property, $value)
    {
        Arr::set($this->crmFields, $property, $value);

        foreach ($this->crmFields as $key => $row) {
            if ($crmField = CrmField::find(Arr::get($row, 'id'))) {

                $data = Arr::only($row, [
                    'is_shown_on_overview',
                    'is_shown_on_target_group_builder',
                    'is_hidden',
                    'is_locked',
                ]);

                $crmField->fill($data);

                if ($crmField->isDirty()) {
                    $crmField->save();
                }
            }
        }

        $this->getCrmFields();
    }

    public function updateSchema()
    {
        Artisan::call('typesense:check-schemas -n --crmcards');
    }

    public function getCrmFields(): void
    {
        $this->crmFields = CrmField::with(['crmFieldType', 'crmFieldCategory'])
            ->when(! empty($this->filter['crm_field_category_id']), function ($query) {
                $query->where(
                    function ($query) {
                        $query->whereHas('crmFieldCategory', function ($query) {
                            $query->where('id', $this->filter['crm_field_category_id']);
                        });
                    }
                );
            })
            ->when(! empty($this->filter['q']), function ($query) {
                $query->where(
                    function ($query) {
                        $query->where('name', 'like', '%'.$this->filter['q'].'%')
                            ->orWhere('label', 'like', '%'.$this->filter['q'].'%');
                    }
                );
            })
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('crm-cards::livewire.fields.overview')
            ->with([
                'crmFieldCategories' => CrmFieldCategory::whereHas('crmFields')->orderBy('name')->get(),
            ]);
    }
}
