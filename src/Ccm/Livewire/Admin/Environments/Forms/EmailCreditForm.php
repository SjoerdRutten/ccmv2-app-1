<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Environments\Models\Environment;

class EmailCreditForm extends Form
{
    public Environment $environment;

    #[Validate]
    public int $quantity = 0;

    public function rules(): array
    {
        return [
            'quantity' => [
                'int',
            ],
        ];
    }

    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function save()
    {
        $this->validate();

        $this->environment->emailCredits()->create([
            'quantity' => $this->quantity,
        ]);

        $this->reset('quantity');
    }
}
