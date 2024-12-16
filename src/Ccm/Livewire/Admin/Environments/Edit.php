<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Environments;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Forms\EmailCreditForm;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Forms\EnvironmentForm;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Environments\Models\Environment;

class Edit extends Component
{
    use HasModals;

    public Environment $environment;

    public EnvironmentForm $form;

    public EmailCreditForm $emailCreditsForm;

    public function mount(Environment $environment)
    {
        $this->environment = $environment;
        $this->form->setEnvironment($this->environment);
        $this->emailCreditsForm->setEnvironment($this->environment);
    }

    public function save()
    {
        $this->environment = $this->form->save();

        $this->showSuccessModal('Omgeving is opgeslagen', href: route('admin::environments::edit', $this->environment->id));
    }

    public function addEmailCredits()
    {
        $this->emailCreditsForm->save();
        $this->showSuccessModal('Credits zijn toegevoegd');
    }

    public function render()
    {
        return view('ccm::livewire.admin.environments.edit');
    }
}
