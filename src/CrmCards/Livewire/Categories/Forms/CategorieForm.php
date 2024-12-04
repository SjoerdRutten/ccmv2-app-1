<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Categories\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class CategorieForm extends Form
{
    public CrmCard $crmCard;

    #[Locked]
    public ?int $id = null;

    public array $data = [];

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
        ];
    }

    public function setCrmCard(CrmCard $crmCard): void
    {
        $this->crmCard = $crmCard;

        $this->data = $crmCard->data;
    }

    public function save()
    {
        $this->validate();

        $this->crmCard->data = $this->data;
        $this->crmCard->save();
    }

    public function noCategoryFields()
    {
        return CrmField::whereNull('crm_field_category_id')
            ->orderBy('position')
            ->get();
    }

    public function categories()
    {
        return CrmFieldCategory::query()
            ->whereHas('crmFields')
            ->orderBy('name')
            ->get();
    }
}
