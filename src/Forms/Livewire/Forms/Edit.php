<?php

namespace Sellvation\CCMV2\Forms\Livewire\Forms;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Forms\Livewire\Forms\Forms\FormEditForm;
use Sellvation\CCMV2\Forms\Models\Form;

class Edit extends Component
{
    use HasModals;

    public Form $form;

    public FormEditForm $editForm;

    public function mount()
    {
        $this->editForm->setFormEditForm($this->form);
    }

    public function updated($property, $value)
    {
        if (\Str::endsWith($property, 'crm_field_id')) {
            $this->editForm->updateLabel($property);
        }
    }

    public function addField()
    {
        $this->editForm->addField();
    }

    public function removeField($key)
    {
        $this->editForm->removeField($key);
    }

    public function generateHtmlForm()
    {
        $this->editForm->html_form = view('forms::templates.form')
            ->with([
                'form' => $this->form,
                'fields' => $this->editForm->fields,
            ])
            ->render();
        $this->editForm->save();

    }

    public function save()
    {
        $this->editForm->save();
        $this->showSuccessModal('Formulier is opgeslagen');
    }

    public function render()
    {
        return view('forms::livewire.forms.edit')
            ->with([
                'crmFields' => CrmField::query()
                    ->orderBy('name')
                    ->get(),
            ]);
    }
}
