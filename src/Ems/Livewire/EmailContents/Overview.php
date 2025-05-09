<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailContents;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ems\Models\EmailCategory;
use Sellvation\CCMV2\Ems\Models\EmailContent;

class Overview extends Component
{
    use WithPagination;

    #[Url]
    public array $filter = [
        'q' => null,
        'email_category_id' => null,
    ];

    public function updated($property, $value)
    {
        if ($property === 'filter.q') {
            $this->resetPage();
        }
    }

    public function getEmailContents()
    {
        return EmailContent::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->when($this->filter['email_category_id'], function ($query, $filter) {
                $query->where('email_category_id', $filter);
            })
            ->paginate();
    }

    public function render()
    {
        return view('ems::livewire.email-contents.overview')
            ->with([
                'emailContents' => $this->getEmailContents(),
                'emailCategories' => EmailCategory::query()
                    ->whereHas('emailContents')
                    ->orderBy('name')
                    ->get(),
            ]);
    }
}
