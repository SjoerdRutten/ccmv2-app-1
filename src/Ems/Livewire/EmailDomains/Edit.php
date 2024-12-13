<?php

namespace Sellvation\CCMV2\Ems\Livewire\EmailDomains;

use Illuminate\Support\Facades\Process;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Ems\Jobs\CheckDkimJob;
use Sellvation\CCMV2\Ems\Livewire\EmailDomains\Forms\EmailDkimForm;
use Sellvation\CCMV2\Ems\Livewire\EmailDomains\Forms\EmailDomainForm;
use Sellvation\CCMV2\Ems\Models\EmailDkim;
use Sellvation\CCMV2\Ems\Models\EmailDomain;

class Edit extends Component
{
    use HasModals;

    public EmailDomain $emailDomain;

    public EmailDomainForm $form;

    public EmailDkimForm $dkimForm;

    public bool $showDkimModal = false;

    public function mount(EmailDomain $emailDomain)
    {
        $this->emailDomain = $emailDomain;

        $this->form->setEmailDomain($this->emailDomain);
        $this->dkimForm->setEmailDomain($this->emailDomain);
    }

    public function save()
    {
        $this->emailDomain = $this->form->save();

        $this->showSuccessModal(title: 'Domein is opgeslagen', href: route('admin::email_domains::edit', ['emailDomain' => $this->emailDomain]));

    }

    public function generateDkim()
    {
        $fileName = uniqid();
        $fileNamePriv = $fileName.'.priv';
        $fileNamePub = $fileName.'.pub';

        Process::run('openssl genrsa -out '.\Storage::path($fileNamePriv).' 4096');
        $this->form->dkim_private_key = \Storage::get($fileNamePriv);

        $result = Process::run('openssl rsa -in '.\Storage::path($fileNamePriv).' -text -noout');

        Process::run('openssl rsa -in '.\Storage::path($fileNamePriv).' -pubout -out '.\Storage::path($fileNamePub));
        $this->form->dkim_public_key = \Storage::get($fileNamePub);
        $this->form->dkim_expires_at = now()->addYear();

        \Storage::delete($fileNamePriv);
        \Storage::delete($fileNamePub);
    }

    public function getDnsRecordKey()
    {
        return $this->emailDomain->dkimRecordKey;
    }

    public function getDnsRecordValue()
    {
        return $this->emailDomain->dkimRecordValue;
    }

    public function addDkim()
    {
        $emailDkim = new EmailDkim;
        $emailDkim->email_domain_id = $this->emailDomain->id;

        $this->dkimForm->resetEmailDkim();
        $this->showDkimModal = true;
    }

    public function editDkim(EmailDkim $emailDkim)
    {
        $this->dkimForm->setEmailDkim($emailDkim);
        $this->showDkimModal = true;
    }

    public function saveDkim()
    {
        $this->dkimForm->save();
        $this->showDkimModal = false;
    }

    public function removeDkim(EmailDkim $emailDkim)
    {
        $emailDkim->delete();
    }

    public function refreshDkimCheck(EmailDkim $emailDkim)
    {
        CheckDkimJob::dispatchSync($emailDkim);
    }

    public function render()
    {
        return view('ems::livewire.email-domains.edit');
    }
}
