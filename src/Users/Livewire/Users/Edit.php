<?php

namespace Sellvation\CCMV2\Users\Livewire\Users;

use Livewire\Component;
use Sellvation\CCMV2\Ccm\Livewire\Traits\HasModals;
use Sellvation\CCMV2\Users\Livewire\Users\Forms\ApiForm;
use Sellvation\CCMV2\Users\Livewire\Users\Forms\UserForm;
use Sellvation\CCMV2\Users\Models\Permission;
use Sellvation\CCMV2\Users\Models\Role;
use Sellvation\CCMV2\Users\Models\User;

class Edit extends Component
{
    use HasModals;

    public User $user;

    public UserForm $form;

    public ApiForm $apiForm;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->form->setUser($user);
        $this->apiForm->setUser($user);
    }

    public function save()
    {
        $this->user = $this->form->save();
        $this->showSuccessModal('Gebruiker opgeslagen');
    }

    public function createToken()
    {
        $token = $this->apiForm->create();

        $message = '%s<br><br>LET OP: Dit token wordt maar eenmalig getoond, kopieer hem dus direct';

        $this->showSuccessModal(title: 'Token aangemaakt', message: sprintf($message, $token));
    }

    public function deleteToken($tokenId)
    {
        $this->user->tokens()->whereId($tokenId)->delete();
    }

    public function render()
    {
        return view('user::livewire.users.edit')
            ->with([
                'permissions' => Permission::orderBy('group')->orderBy('name')->get(),
                'roles' => Role::orderBy('name')->get(),
                'scopes' => \ApiScopes::getScopes(),
            ]);
    }
}
