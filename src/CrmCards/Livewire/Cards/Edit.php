<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

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

    #[Url]
    public array $filter = [
        'q' => '',
        'category_id' => null,
    ];

    public function mount(CrmCard $crmCard)
    {
        $this->crmCard = $crmCard;
        $this->form->setCrmCard($this->crmCard);
    }

    public function updated($property, $value)
    {
        switch ($property) {
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

    public function render()
    {
        return view('crm-cards::livewire.cards.edit')
            ->with([
                'categories' => $this->getShowCategories(),
                'foundFields' => $this->searchFields(),
            ]);
    }
}
