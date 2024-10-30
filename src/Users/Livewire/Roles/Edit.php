<?php

namespace Sellvation\CCMV2\Users\Livewire\Roles;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Livewire\Roles\Forms\RoleForm;
use Sellvation\CCMV2\Users\Models\Role;
use Sellvation\CCMV2\Users\Models\User;

class Edit extends Component
{
    use HasModals;

    public Role $role;

    public RoleForm $form;

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

    public function render()
    {
        return view('user::livewire.roles.edit');
    }
}
