<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Livewire\Cards\Forms\CrmCardForm;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class Edit extends Component
{
    use HasModals;

    public CrmCard $crmCard;

    public CrmCardForm $form;

    public string $showLabel = 'name';

    #[Url]
    public array $filter = [
        'q' => '',
        'category_id' => null,
    ];

    public function mount(CrmCard $crmCard)
    {
        $this->showLabel = Cache::get('crm-card-show-label', 'name');

        $this->crmCard = $crmCard;
        $this->form->setCrmCard($this->crmCard);
    }

    public function updated($property, $value)
    {
        switch ($property) {
            case 'showLabel':
                Cache::set('crm-card-show-label', $value, 3600);
                break;
            case 'filter.category_id':
                $this->filter['q'] = null;
                break;
            case 'filter.q':
                $this->filter['category_id'] = null;
                break;
        }
    }

    public function save()
    {
        $this->crmCard = $this->form->save();

        $this->showSuccessModal('CRM Kaart is opgeslagen', href: route('crm-cards::cards::edit', $this->crmCard->id));
    }

    public function getShowCategories($orderBy = 'position')
    {
        return CrmFieldCategory::query()
            ->whereHas('crmFields')
            ->when(! empty($this->filter['category_id']), function ($query) {
                $query->where('id', $this->filter['category_id']);
            })
            ->orderBy($orderBy)
            ->get();
    }

    public function searchFields()
    {
        if (! empty($this->filter['q'])) {
            return CrmField::query()
                ->when(! empty($this->filter['q']), function ($query) {
                    $query->where('name', 'like', '%'.$this->filter['q'].'%')
                        ->orWhere('label', 'like', '%'.$this->filter['q'].'%');
                })
                ->orderBy('name')
                ->get();
        }

        return [];
    }

    public function setFieldPosition(CrmField $field, $position)
    {
        $field->update(['position' => $position]);

        $crmFields = CrmField::query()
            ->where('id', '<>', $field->id)
            ->when(empty($field->crm_field_category_id), function ($query) {
                $query->whereNull('crm_field_category_id');
            })
            ->when(! empty($field->crm_field_category_id), function ($query) use ($field) {
                $query->where('crm_field_category_id', $field->crm_field_category_id);
            })
            ->orderBy('position')
            ->get();

        $index = 0;
        foreach ($crmFields as $key => $crmField) {
            if ($index === $position) {
                $index++;
            }
            $crmField->update(['position' => $index]);
            $index++;
        }
    }

    public function render()
    {
        return view('crm-cards::livewire.cards.edit')
            ->with([
                'categories' => $this->getShowCategories(),
                'foundFields' => $this->searchFields(),
            ]);
    }
}
