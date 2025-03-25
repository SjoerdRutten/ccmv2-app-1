<?php

namespace Sellvation\CCMV2\Disks\Livewire\DiskTypes\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Disks\Models\DiskType;

class DiskTypeForm extends Form
{
    public DiskType $diskType;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public string $name;

    #[Validate]
    public int $disk_id;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'disk_id' => [
                'required',
            ],
        ];
    }

    public function setModel(DiskType $diskType)
    {
        $this->diskType = $diskType;

        if ($this->diskType->id) {
            $this->fill($diskType->toArray());
        }
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['diskType']);

        if ($this->diskType->id) {
            $this->diskType->update($data);
        } else {
            $this->diskType = DiskType::create($data);
        }

        return $this->diskType;
    }
}
