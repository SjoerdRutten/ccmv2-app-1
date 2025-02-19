<?php

namespace Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\DataFeeds\Models\DataFeed;

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

    public function getDataFeeds()
    {
        return DataFeed::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->orderBy('name')
            ->paginate();
    }

    public function render()
    {
        return view('df::livewire.data-feeds.overview')
            ->with([
                'dataFeeds' => $this->getDataFeeds(),
            ]);
    }
}
