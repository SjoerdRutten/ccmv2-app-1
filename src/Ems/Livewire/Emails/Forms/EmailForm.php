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

    public ?int $site_id = null;

    public ?string $utm_code = null;

    public string $name = '';

    public ?string $type = null;

    public ?int $email_category_id = null;

    public ?int $recipient_crm_field_id = null;

    public ?string $description = null;

    public ?string $pre_header = null;

    public string $sender_email = '';

    public ?string $sender_name = null;

    public string $recipient_type = 'CRMFIELD';

    public ?string $recipient = null;

    public ?string $reply_to = null;

    public string $subject = '';

    public ?string $text = null;

    public ?string $html_type = null;

    public ?string $html = null;

    public ?string $css = null;

    public ?string $stripo_html = null;

    public ?string $stripo_css = null;

    public ?string $optout_url = null;

    public int $email_id;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'site_id' => [
                'required',
                'exists:sites,id',
            ],
            'utm_code' => [
                'nullable',
                'string',
            ],
            'name' => [
                'required',
            ],
            'type' => [
                'required',
            ],
            'sender_email' => [
                'required',
                'email:rfc,dns',
            ],
            'subject' => [
                'required',
                'string',
            ],
            'html_type' => [
                'required',
            ],
            'optout_url' => [
                'nullable',
                'url',
            ],
        ];
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;

        $this->email_id = \Auth::user()->current_environment_id;
        $this->fill($email->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = \Arr::only($this->all(), [
            'site_id',
            'utm_code',
            'email_category_id',
            'name',
            'type',
            'description',
            'pre_header',
            'sender_email',
            'sender_name',
            'recipient_type',
            'recipient_crm_field_id',
            'recipient',
            'reply_to',
            'subject',
            'optout_url',
            'stripo_html',
            'stripo_css',
            'html',
            'html_type',
            'text',
        ]);

        $this->email->fill($data);
        $this->email->save();

        return $this->email;

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
