<?php

namespace Sellvation\CCMV2\TargetGroups\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Models\Category;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Overview extends Component
{
    #[Url]
    public array $filter = [
        'q' => null,
        'category_id' => null,
    ];

    #[Computed]
    public function targetGroups()
    {
        return TargetGroup::query()
            ->when(! empty($this->filter['q']), function ($query) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('id', (int) $this->filter['q']);
            })
            ->when(! empty($this->filter['category_id']), function ($query) {
                $query->whereCategoryId($this->filter['category_id']);
            })
            ->orderBy('name')
            ->get();
    }

    public function delete(TargetGroup $targetGroup)
    {
        $targetGroup->delete();
    }

    public function render()
    {
        return view('target-group::livewire.overview')
            ->with([
                'categories' => Category::query()
                    ->whereHas('targetGroups')
                    ->orderBy('name')
                    ->get(),
            ]);
    }
}
