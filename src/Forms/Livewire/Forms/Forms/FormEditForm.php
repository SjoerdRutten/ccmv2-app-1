<?php

namespace Sellvation\CCMV2\Forms\Livewire\Forms\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class FormEditForm extends Form
{
    #[Locked]
    public \Sellvation\CCMV2\Forms\Models\Form $form;

    #[Locked]
    public ?int $id = null;

    public string $name = '';

    public ?string $description = null;

    public ?array $fields = [];

    public ?string $success_redirect_action = '';

    public ?array $success_redirect_params = [];

    public ?array $async_actions = [];

    public ?string $html_form = '';

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
        ];
    }

    public function setFormEditForm(\Sellvation\CCMV2\Forms\Models\Form $form): void
    {
        $this->form = $form;
        $this->fill($form->toArray());

        $this->success_redirect_params = is_array($this->success_redirect_params) ? $this->success_redirect_params : [];
        $this->async_actions = is_array($this->async_actions) ? $this->async_actions : [];

        $this->fields = $form->fields ?: [];
    }

    public function addField()
    {
        $this->fields[uniqid()] = [
            'crm_field_id' => null,
            'label' => null,
            'required' => false,
            'attach_to_crm_card' => false,
            'create' => true,
        ];
    }

    public function removeField($key)
    {
        \Arr::pull($this->fields, $key);
    }

    public function addAsyncAction()
    {
        $this->async_actions[uniqid()] = [
            'action' => '',
            'params' => [],
        ];
    }

    public function removeAsyncAction($key)
    {
        \Arr::pull($this->async_actions, $key);
    }

    public function updateLabel($key)
    {
        $fieldKey = explode('.', $key);
        $fieldKey = \Arr::get($fieldKey, 2);

        if (\Str::endsWith($this->fields[$fieldKey]['crm_field_id'], '_optin')) {
            $crmField = CrmField::find(\Str::substr($this->fields[$fieldKey]['crm_field_id'], 0, -6));
            $this->fields[$fieldKey]['label'] = $crmField->label.' Optin';
        } else {
            $crmField = CrmField::find($this->fields[$fieldKey]['crm_field_id']);
            $this->fields[$fieldKey]['label'] = $crmField->label;
        }

    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        $data = \Arr::only($data, [
            'name',
            'description',
            'fields',
            'success_redirect_action',
            'success_redirect_params',
            'async_actions',
            'html_form',
        ]);

        $this->form->fill($data);
        $this->form->save();

    }
}
