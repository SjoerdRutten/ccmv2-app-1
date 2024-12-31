<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Imports;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;

class Overview extends Component
{
    use WithPagination;

    public function render()
    {
        return view('crm-cards::livewire.imports.overview')
            ->with([
                'crmCardImports' => CrmCardImport::latest()->paginate(),
            ]);
    }
}
