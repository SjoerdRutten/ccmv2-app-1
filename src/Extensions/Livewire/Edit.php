<?php

namespace Sellvation\CCMV2\Extensions\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Extensions\Livewire\Forms\ExtensionForm;
use Sellvation\CCMV2\Extensions\Models\Extension;

class Edit extends Component
{
    use HasModals;
    use WithPagination;

    public Extension $extension;

    public ExtensionForm $form;

    public function mount(Extension $extension)
    {
        $this->extension = $extension;
        $this->form->setModel($this->extension);
    }

    public function save()
    {
        $this->extension = $this->form->save();

        $this->showSuccessModal(title: 'Extensie is opgeslagen', href: route('admin::extensions::edit', $this->extension->id));
    }

    public function getSettings()
    {
        if (! empty($this->form->job)) {
            return $this->form->job::getSettingsForm();
        }

        return [];
    }

    public function render()
    {
        return view('extensions::extensions.edit')
            ->with([
                'settings' => $this->getSettings(),
                'events' => \ExtensionService::getExtensionEvents(),
                'jobs' => \ExtensionService::getExtensionJobs(),
            ]);
    }
}
