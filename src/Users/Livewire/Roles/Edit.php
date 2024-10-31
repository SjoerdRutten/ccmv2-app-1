<?php

namespace Sellvation\CCMV2\Users\Livewire\Roles;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Livewire\Roles\Forms\RoleForm;
use Sellvation\CCMV2\Users\Models\Permission;
use Sellvation\CCMV2\Users\Models\Role;
use Sellvation\CCMV2\Users\Models\User;

class Edit extends Component
{
    use HasModals;

    public Role $role;

    public RoleForm $form;

    public string $q = '';

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->form->setRole($role);
    }

    public function save()
    {
        $this->role = $this->form->save();
        $this->form->setRole($this->role);
        $this->showSuccessModal('Rol opgeslagen');
    }

    public function loginAs(User $user)
    {
        Auth::login($user);

        return redirect()->route('ccm::dashboard');
    }

    public function getUsers()
    {
        return $this->role
            ->users()
            ->orderBy('name')
            ->when(! empty($this->q), function ($query) {
                $query->where('name', 'like', '%'.$this->q.'%')
                    ->orWhere('email', 'like', '%'.$this->q.'%');
            })
            ->get();
    }

    public function render()
    {
        return view('user::livewire.roles.edit')
            ->with([
                'permissions' => Permission::all(),
            ]);
    }
}
