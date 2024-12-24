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

    #[Validate]
    public array $mailServers = [];

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

        foreach ($this->sendRule->mailServers as $mailServer) {
            $this->mailServers[uniqid()] = [
                'mailServerId' => $mailServer->id,
                'priority' => $mailServer->pivot->priority,
            ];
        }
    }

    public function addRule()
    {
        $this->rules[uniqid()] = [
            'check' => '',
            'value' => '',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['sendRule', 'mailServers']);

        if ($this->sendRule->id) {
            $this->sendRule->update($data);
        } else {
            $this->sendRule = SendRule::create($data);
        }

        $mailServers = [];
        foreach ($this->mailServers as $mailServer) {
            if (\Arr::get($mailServer, 'mailServerId')) {
                $mailServers[\Arr::get($mailServer, 'mailServerId')] = ['priority' => \Arr::get($mailServer, 'priority', 100)];
            }
        }
        $this->sendRule->mailServers()->sync($mailServers);

        return $this->sendRule;
    }
}
