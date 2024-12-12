<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailDomains;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ems\Models\EmailDomain;

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

    public function removeEmailDomain(EmailDomain $emailDomain)
    {
        $emailDomain->delete();
    }

    public function getEmailDomains()
    {
        return EmailDomain::query()
            ->when($this->filter['q'], function ($query, $filter) {
                $query->where('name', 'like', '%'.$this->filter['q'].'%')
                    ->orWhere('description', 'like', '%'.$this->filter['q'].'%');
            })
            ->paginate();
    }

    public function render()
    {
        return view('ems::livewire.email-domains.overview')
            ->with([
                'emailDomains' => $this->getEmailDomains(),
            ]);
    }
}
