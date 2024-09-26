<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Categories;

use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Livewire\Component;

class Overview extends Component
{
    public function render()
    {
        return view('crm-cards.categories.overview')
            ->with([
                'categories' => CrmFieldCategory::orderBy('name')->get(),
            ]);
    }
}
