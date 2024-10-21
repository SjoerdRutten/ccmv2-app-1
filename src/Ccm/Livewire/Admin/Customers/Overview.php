<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Customers;

use Livewire\Component;
use Sellvation\CCMV2\Users\Models\Customer;

class Overview extends Component
{
    public function render()
    {
        return view('ccm::livewire.admin.customers.overview')
            ->with([
                'customers' => Customer::get(),
            ]);
    }
}
