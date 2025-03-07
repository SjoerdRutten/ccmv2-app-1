<?php

namespace Sellvation\CCMV2\Ems\Livewire\Mailings\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\Ems\Models\EmailMailing;

class MailingForm extends Form
{
    #[Locked]
    public EmailMailing $emailMailing;

    #[Locked]
    public ?int $id = null;

    public string $name = '';

    public ?string $description = null;

    public ?string $start_at = null;

    public ?int $email_id = null;

    public ?int $target_group_id = null;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'email_id' => [
                'required',
            ],
            'target_group_id' => [
                'required',
            ],
            'name' => [
                'required',
            ],
            'start_at' => [
                'nullable',
            ],
        ];
    }

    public function setMailing(EmailMailing $emailMailing): void
    {
        $this->emailMailing = $emailMailing;

        $this->fill($emailMailing->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = \Arr::only($this->all(), [
            'name',
            'description',
            'email_id',
            'target_group_id',
            'start_at',
        ]);

        $data['start_at'] = empty($this->start_at) ? null : $this->start_at;
        $this->emailMailing->fill($data);
        $this->emailMailing->save();

        return $this->emailMailing;

    }
}
