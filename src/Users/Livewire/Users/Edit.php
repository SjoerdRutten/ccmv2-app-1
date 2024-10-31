<?php

namespace Sellvation\CCMV2\Users\Livewire\Users;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Livewire\Users\Forms\UserForm;
use Sellvation\CCMV2\Users\Models\Role;
use Sellvation\CCMV2\Users\Models\User;

class Edit extends Component
{
    use HasModals;

    public User $user;

    public UserForm $form;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->form->setUser($user);
    }

    public function save()
    {
        $this->user = $this->form->save();
        $this->showSuccessModal('Gebruiker opgeslagen');
    }

    public function render()
    {
        return view('user::livewire.users.edit')
            ->with([
                'roles' => Role::orderBy('name')->get(),
            ]);
    }
}
