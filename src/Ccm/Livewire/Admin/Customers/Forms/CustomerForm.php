<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Users\Models\Customer;

class CustomerForm extends Form
{
    public Customer $customer;

    #[Locked]
    public ?int $id = null;

    //    #[Validate]
    //    public $user_id;
    //
    //    #[Validate]
    //    public $helpdesk_user_id;

    #[Validate]
    public $name;

    #[Validate]
    public $visiting_address;

    #[Validate]
    public $visiting_address_postcode;

    #[Validate]
    public $visiting_address_city;

    #[Validate]
    public $visiting_address_state;

    #[Validate]
    public $visiting_address_country;

    #[Validate]
    public $postal_address;

    #[Validate]
    public $postal_address_postcode;

    #[Validate]
    public $postal_address_city;

    #[Validate]
    public $postal_address_state;

    #[Validate]
    public $postal_address_country;

    #[Validate]
    public $telephone;

    #[Validate]
    public $fax;

    #[Validate]
    public $email;

    #[Validate]
    public $url;

    #[Validate]
    public $logo;

    #[Validate]
    public $allowed_ips;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
        ];
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        $this->fill($customer->toArray());

        $this->allowed_ips = implode("\n", $this->allowed_ips ?? []);
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['customer']);

        $data['allowed_ips'] = explode("\n", $this->allowed_ips);

        if ($this->customer->id) {
            $this->customer->update($data);
        } else {
            $this->customer = Customer::create($data);
        }

    }
}
