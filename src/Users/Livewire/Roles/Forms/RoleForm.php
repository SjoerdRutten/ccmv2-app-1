<?php

namespace Sellvation\CCMV2\Users\Livewire\Roles\Forms;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Sellvation\CCMV2\Users\Models\Role;

class RoleForm extends Form
{
    public Role $role;

    #[Locked]
    public ?int $id = null;

    #[Validate]
    public $name;

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
        ];
    }

    public function setRole(Role $role)
    {
        $this->role = $role;

        $this->fill($role->toArray());
    }

    public function save()
    {
        $this->validate();

        $data = $this->all();

        if ($this->role->id) {
            $this->role->update($data);
        } else {
            $this->role = Role::create($data);
        }

        return $this->role;

    }
}
