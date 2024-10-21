<?php

namespace Sellvation\CCMV2\Ccm\Livewire\Admin\Environments;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Forms\EnvironmentForm;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Environments\Models\Environment;

class Edit extends Component
{
    use HasModals;

    public Environment $environment;

    public EnvironmentForm $form;

    public function mount()
    {
        $this->form->setEnvironment($this->environment);
    }

    public function save()
    {
        $this->form->save();

        $this->showSuccessModal('Omgeving is opgeslagen');
    }

    public function render()
    {
        return view('ccm::livewire.admin.environments.edit');
    }
}
