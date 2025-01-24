<?php

namespace Sellvation\CCMV2\Extensions\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Extensions\Models\Extension;

class ExtensionForm extends Form
{
    public Extension $extension;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $name;

    #[Validate]
    public ?string $description = null;

    #[Validate]
    public bool $is_active = true;

    #[Validate]
    public string $event = '';

    #[Validate]
    public string $job = '';

    #[Validate]
    public ?array $settings = [];

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'is_active' => [
                'bool',
            ],
            'event' => [
                'required',
            ],
            'job' => [
                'required',
            ],
            'settings' => [
                'array',
            ],
        ];
    }

    public function setModel(Extension $extension)
    {
        $this->extension = $extension;

        if ($this->extension->id) {
            $this->fill($extension->toArray());
        } else {
            $this->settings = [];
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['extension']);

        if ($this->extension->id) {
            $this->extension->update($data);
        } else {
            $this->extension = Extension::create($data);
        }

        return $this->extension;
    }
}
