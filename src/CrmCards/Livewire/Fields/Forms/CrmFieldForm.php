<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldType;

class CrmFieldForm extends Form
{
    public CrmField $crmField;

    public ?int $id = null;
    public ?int $crm_field_category_id = null;
    public ?int $crm_field_type_id = null;
    public string $name = '';
    public string $label = '';
    public ?string  $label_en = null;
    public ?string $label_de = null;
    public ?string $label_fr = null;
    public bool $is_shown_on_overview = false;
    public bool $is_shown_on_target_group_builder = false;
    public bool $is_hidden = false;
    public bool $is_locked = false;
    public int $position = 0;
    public ?string $log_file = null;
    public int $overview_index = 0;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'crm_field_type_id' => [
                'required',
                'exists:crm_field_types,id',
            ],
            'crm_field_category_id' => [
                'nullable',
                'exists:crm_field_categories,id',
            ],
            'name' => [
                'required',
                Rule::unique('users')->ignore($this->crmField->id),
            ],
            'label' => [
                'required',
            ],
            'label_en' => [
                'nullable',
            ],
            'label_de' => [
                'nullable',
            ],
            'label_fr' => [
                'nullable',
            ],
            'is_shown_on_overview' => [
                'boolean',
            ],
            'is_shown_on_target_group_builder' => [
                'boolean',
            ],
            'is_hidden' => [
                'boolean',
            ],
            'is_locked' => [
                'boolean',
            ],
            'position' => [
                'integer',
            ],
            'log_file' => [
                'nullable',
                'string'
            ],
            'overview_index' => [
                'integer',
            ],
        ];
    }

    public function updated($property, $value)
    {
        dd($property, $value);
    }

    public function setCrmField(CrmField $crmField)
    {
        $this->crmField = $crmField;

        $this->fill($crmField->toArray());
    }

    public function crmFieldTypes()
    {
        return CrmFieldType::orderBy('name')->get();
    }

    public function crmFieldCategories()
    {
        return CrmFieldCategory::orderBy('name')->get();
    }
}
