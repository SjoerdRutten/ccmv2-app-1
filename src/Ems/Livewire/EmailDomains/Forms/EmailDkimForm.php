<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailDomains\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\Ems\Models\EmailDkim;
use Sellvation\CCMV2\Ems\Models\EmailDomain;

class EmailDkimForm extends Form
{
    #[Locked]
    public EmailDomain $emailDomain;

    #[Locked]
    public ?EmailDkim $emailDkim = null;

    #[Locked]
    public ?int $id = null;

    public ?string $selector_prefix = null;

    public array $emailDkimDomains = [];

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'selector_prefix' => [
                'required',
            ],
        ];
    }

    public function setEmailDomain(EmailDomain $emailDomain): void
    {
        $this->emailDomain = $emailDomain;
    }

    public function setEmailDkim(EmailDkim $emailDkim): void
    {
        $this->emailDkim = $emailDkim;
        $this->fill($emailDkim->toArray());
        $this->emailDkimDomains = $this->emailDkim->emailDkimDomains()->pluck('domain')->toArray();
    }

    public function resetEmailDkim()
    {
        $this->reset([
            'email_domain_id',
            'selector_prefix',
        ]);
    }

    public function addEmailDkimDomain()
    {
        $this->emailDkimDomains[] = '';
    }

    public function removeEmailDkimDomain($key)
    {
        \Arr::pull($this->emailDkimDomains, $key);
        $this->emailDkimDomains = array_values($this->emailDkimDomains);
    }

    public function save()
    {
        $this->validate();

        if (! $this->emailDkim) {
            $this->emailDkim = new EmailDkim;
        }

        $this->emailDkim->selector_prefix = \Str::slug(\Str::lower($this->selector_prefix), '_');
        $this->emailDkim->expires_at = now()->addYear();
        $this->emailDkim->emailDomain()->associate($this->emailDomain);
        $this->emailDkim->save();

        $this->emailDkim->emailDkimDomains()->delete();

        foreach ($this->emailDkimDomains as $emailDkimDomain) {
            $emailDkimDomain = \Str::trim(\Str::lower($emailDkimDomain));

            if (! empty($emailDkimDomain)) {
                $this->emailDkim->emailDkimDomains()->create([
                    'domain' => $emailDkimDomain,
                ]);
            }
        }

        return $this->emailDkim;
    }
}
