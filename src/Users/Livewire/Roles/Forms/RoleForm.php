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

    public array $permissions = [];

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
        $this->permissions = $role->permissions()
            ->wherePivot('environment_id', \Auth::user()->currentEnvironmentId)
            ->pluck('id')->toArray();
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

        $permissions = [];
        foreach ($this->permissions as $permission) {
            $permissions[$permission] = ['environment_id' => \Auth::user()->currentEnvironmentId];
        }

        $this->role->permissions()->sync($permissions);

        return $this->role;
    }
}
