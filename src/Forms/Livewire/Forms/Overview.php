<?php

namespace Sellvation\CCMV2\Forms\Livewire\Forms;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Forms\Models\Form;

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

    public function getForms()
    {
        return Form::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->paginate();
    }

    public function render()
    {
        return view('forms::livewire.forms.overview')
            ->with([
                'forms' => $this->getForms(),
            ]);
    }
}
