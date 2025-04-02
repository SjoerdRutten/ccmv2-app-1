<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Cards;

use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;
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
        'crm_field_id' => null,
    ];

    public function mount()
    {
        if (\Cache::has('crm-card-filter')) {
            $this->filter = \Cache::get('crm-card-filter');
        }
    }

    public function updated($property, $value)
    {
        if (Str::startsWith($property, 'filter')) {
            \Cache::set('crm-card-filter', $this->filter, 3600);
            $this->resetPage();
        }
    }

    public function removeCard(CrmCard $card)
    {
        $card->delete();
    }

    public function getCrmCards()
    {
        if ($this->filter['target_group_id']) {
            $targetGroup = TargetGroup::find($this->filter['target_group_id']);

            $query = TargetGroupSelectorFacade::getQuery($targetGroup->filters);
        } else {
            $query = CrmCardMongo::query();
        }

        if ($this->filter['q']) {
            if ($crmField = $this->filter['crm_field_id'] ? CrmField::find($this->filter['crm_field_id']) : null) {
                $query->where($crmField->name, 'like', '%'.$this->filter['q'].'%');
            } else {
                foreach (CrmField::where('is_shown_on_target_group_builder', 1)->get() as $crmField) {
                    $query->orWhere($crmField->name, 'like', '%'.$this->filter['q'].'%');
                }
            }
        }

        return $query->select('id')->paginate(25);
    }

    public function render()
    {
        return view('crm-cards::livewire.cards.overview')
            ->with([
                'crmCards' => $this->getCrmCards(),
                'crmFields' => CrmField::where('is_shown_on_overview', 1)->orderBy('overview_index')->get(),
                'searchableCrmFields' => CrmField::where('is_shown_on_target_group_builder', 1)->orderBy('name')->get(),
                'targetGroups' => TargetGroup::orderBy('name')->get(),
            ]);
    }
}
