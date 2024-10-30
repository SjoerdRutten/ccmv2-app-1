<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Customers;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Forms\RoleForm;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Models\Customer;

class Edit extends Component
{
    use HasModals;

    public Customer $customer;

    public RoleForm $form;

    public function mount()
    {
        $this->form->setCustomer($this->customer);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal('Klant is opgeslagen');
    }

    public function render()
    {
        return view('ccm::livewire.admin.customers.edit');
    }
}
