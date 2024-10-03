<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Fields\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldType;

class CrmFieldForm extends Form
{
    public CrmField $crmField;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public ?int $crm_field_category_id = null;

    #[Validate]
    public ?int $crm_field_type_id = null;

    #[Validate]
    public string $name = '';

    #[Validate]
    public string $label = '';

    #[Validate]
    public ?string $label_en = null;

    #[Validate]
    public ?string $label_de = null;

    #[Validate]
    public ?string $label_fr = null;

    #[Validate]
    public bool $is_shown_on_overview = false;

    #[Validate]
    public bool $is_shown_on_target_group_builder = false;

    #[Validate]
    public bool $is_hidden = false;

    #[Validate]
    public bool $is_locked = false;

    #[Validate]
    public int $position = 0;

    #[Validate]
    public ?string $log_file = null;

    #[Validate]
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
                'string',
            ],
            'overview_index' => [
                'integer',
            ],
        ];
    }

    public function setCrmField(CrmField $crmField)
    {
        $this->crmField = $crmField;

        $this->fill($crmField->toArray());
    }

    public function save()
    {
        $this->validate();

        $this->name = Str::slug($this->name, '_');

        if ($this->crmField->id) {
            $this->crmField->update(Arr::except($this->all(), ['crmField', 'id']));
        } else {
            $this->crmField = CrmField::create(Arr::except($this->all(), ['crmField', 'id']));
        }
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
