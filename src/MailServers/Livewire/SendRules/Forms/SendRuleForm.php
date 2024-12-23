<?php

namespace Sellvation\CCMV2\MailServers\Livewire\SendRules\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\MailServers\Models\SendRule;

class SendRuleForm extends Form
{
    public SendRule $sendRule;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public bool $is_active;

    #[Validate]
    public int $priority = 0;

    #[Validate]
    public string $name;

    #[Validate]
    public array $rules = [];

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
        ];
    }

    public function setSendRule(SendRule $sendRule)
    {
        $this->sendRule = $sendRule;
        $this->fill($sendRule->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['sendRule']);

        if ($this->sendRule->id) {
            $this->sendRule->update($data);
        } else {
            $this->sendRule = SendRule::create($data);
        }

        return $this->sendRule;
    }
}
