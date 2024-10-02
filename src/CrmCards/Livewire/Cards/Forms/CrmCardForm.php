<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards\Forms;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldType;

class CrmCardForm extends Form
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

    public function categories()
    {
        return CrmFieldCategory::query()
            ->whereHas('crmFields')
            ->orderBy('name')
            ->get();
    }
}
