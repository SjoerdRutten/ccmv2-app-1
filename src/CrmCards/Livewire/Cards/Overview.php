<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
        'target_group_id' => null,
    ];

    public function updated($property, $value)
    {
        if ($property === 'filter.q') {
            $this->resetPage();
        }
    }

    public function getCrmCards()
    {
        if ($this->filter['target_group_id']) {
            $targetGroup = TargetGroup::find($this->filter['target_group_id']);

            return TargetGroupSelectorFacade::getQuery($targetGroup->filters, 25)->paginate();
        } elseif ($this->filter['q']) {
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
                'targetGroups' => TargetGroup::orderBy('name')->get(),
            ]);
    }
}
