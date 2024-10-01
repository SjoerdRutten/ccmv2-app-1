<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
    ];

    public function updated($property, $value)
    {
        if ($property === 'filter.q') {
            $this->resetPage();
        }
    }

    public function getCrmCards()
    {
        if ($this->filter['q']) {
            return CrmCard::search($this->filter['q'])
                ->options(['query_by' => '*'])
                ->paginate(25);
        }
        return CrmCard::orderBy('id')
            ->paginate(25);
    }

    public function render()
    {
        return view('crm-cards::livewire.cards.overview')
            ->with([
                'crmCards' => $this->getCrmCards(),
                'crmFields' => CrmField::where('is_shown_on_overview', 1)->orderBy('overview_index')->get(),
            ]);
    }
}
