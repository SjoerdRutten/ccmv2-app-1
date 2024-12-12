<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailDomains\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\Ems\Models\EmailDomain;

class EmailDomainForm extends Form
{
    #[Locked]
    public EmailDomain $emailDomain;

    #[Locked]
    public ?int $id = null;

    public string $domain = '';

    public ?string $description = null;

    public ?string $return_path = null;

    public ?string $dkim_selector_prefix = null;

    public ?string $dkim_private_key = null;

    public ?string $dkim_public_key = null;

    public ?string $dkim_expires_at = null;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'domain' => [
                'required',
            ],
            'return_path' => [
                'nullable',
            ],
            'dkim_selector_prefix' => [
                'nullable',
            ],
        ];
    }

    public function setEmailDomain(EmailDomain $emailDomain): void
    {
        $this->emailDomain = $emailDomain;
        $this->fill($emailDomain->toArray());
    }

    public function save()
    {
        $this->validate();
        $this->emailDomain->fill($this->except(['id', 'emailDomain']));
        $this->emailDomain->save();

        return $this->emailDomain;
    }
}
