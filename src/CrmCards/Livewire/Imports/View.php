<?php

namespace Sellvation\CCMV2\CrmCards\Livewire\Imports;

use Livewire\Component;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;

class View extends Component
{
    public CrmCardImport $crmCardImport;

    public function render()
    {
        return view('crm-cards::livewire.imports.view');
    }
}
