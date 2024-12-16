<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Environments\Models\Environment;
use Sellvation\CCMV2\Environments\Models\Timezone;
use Sellvation\CCMV2\Users\Models\Customer;

class EnvironmentForm extends Form
{
    public Environment $environment;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public int $customer_id;

    #[Validate]
    public int $timezone_id;

    #[Validate]
    public string $name;

    #[Validate]
    public ?string $description;

    #[Validate]
    public ?int $email_credits;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'customer_id' => [
                'required',
                'exists:customers,id',
            ],
            'timezone_id' => [
                'required',
                'exists:timezones,id',
            ],
            'name' => [
                'required',
                'max:40',
            ],
            'description' => [
                'nullable',
                'max:80',
            ],
        ];
    }

    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        $this->fill($environment->toArray());
    }

    public function getCustomers()
    {
        return Customer::orderBy('name')->pluck('name', 'id');
    }

    public function getTimezones()
    {
        return Timezone::orderBy('name')->pluck('name', 'id');
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['environment']);

        if ($this->environment->id) {
            $this->environment->update($data);
        } else {
            $this->environment = Environment::create($data);
        }

        return $this->environment;

    }
}
