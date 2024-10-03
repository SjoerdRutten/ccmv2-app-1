<?php

namespace Sellvation\CCMV2\Ems\Livewire\Emails\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailCategory;

class EmailForm extends Form
{
    #[Locked]
    public Email $email;

    #[Locked]
    public ?int $id = null;

    public string $name = '';

    public ?int $email_category_id = null;

    public ?int $recipient_crm_field_id = null;

    public ?string $description = null;

    public string $sender_email = '';

    public ?string $sender_name = null;

    public ?string $recipient = null;

    public ?string $reply_to = null;

    public string $subject = '';

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
        ];
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;

        $this->fill($email->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        $data = \Arr::only($data, [
            'email_category_id',
            'name',
            'description',
            'sender_email',
            'sender_name',
            'recipient',
            'reply_to',
            'subject',
            'optout_url',
        ]);

        $this->email->fill($data);
        $this->email->save();

    }

    public function categories()
    {
        return EmailCategory::query()
            ->orderBy('name')
            ->get();
    }

    public function emailFields()
    {
        return CrmField::query()
            ->whereHas('crmFieldType', function ($query) {
                $query->whereName('EMAIL');
            })
            ->orderBy('name')
            ->get();
    }
}
