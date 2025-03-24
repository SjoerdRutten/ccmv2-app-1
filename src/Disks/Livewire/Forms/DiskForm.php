<?php

namespace Sellvation\CCMV2\Disks\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Disks\Models\Disk;

class DiskForm extends Form
{
    public Disk $disk;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $name;

    #[Validate]
    public string $type;

    #[Validate]
    public ?string $description = null;

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
            'type' => [
                'required',
            ],
            'description' => [
                'nullable',
            ],
            'settings' => [
                'array',
            ],
        ];
    }

    public function setModel(Disk $disk)
    {
        $this->disk = $disk;

        if ($this->disk->id) {
            $this->fill($disk->toArray());
        } else {
            $this->settings = [];
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['disk']);

        if ($this->disk->id) {
            $this->disk->update($data);
        } else {
            $this->disk = Disk::create($data);
        }

        return $this->disk;
    }
}
