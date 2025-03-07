<?php

namespace Sellvation\CCMV2\Ems\Livewire\Mailings;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ems\Models\EmailMailing;

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

    public function getMailings()
    {
        return EmailMailing::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->latest()
            ->paginate();
    }

    public function render()
    {
        return view('ems::livewire.mailings.overview')
            ->with([
                'mailings' => $this->getMailings(),
            ]);
    }
}
