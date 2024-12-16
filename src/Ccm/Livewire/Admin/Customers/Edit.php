<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Customers;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Forms\CustomerForm;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Models\Customer;

class Edit extends Component
{
    use HasModals;

    public Customer $customer;

    public CustomerForm $form;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
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
