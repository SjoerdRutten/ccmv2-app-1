<?php

namespace Sellvation\CCMV2\Ems\Livewire\Emails;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailCategory;

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

    public function getEmails()
    {
        return Email::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('subject', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->when($this->filter['email_category_id'], function ($query, $filter) {
                $query->where('email_category_id', $filter);
            })
            ->paginate();
    }

    public function render()
    {
        return view('ems::livewire.emails.overview')
            ->with([
                'emails' => $this->getEmails(),
                'emailCategories' => EmailCategory::query()
                    ->whereHas('emails')
                    ->orderBy('name')
                    ->get(),
            ]);
    }
}
