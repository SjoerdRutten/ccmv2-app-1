<?php

namespace Sellvation\CCMV2\Users\Livewire\Users\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Sellvation\CCMV2\Users\Models\User;

class UserForm extends Form
{
    public User $user;

    #[Locked]
    public ?int $id = null;

    public ?string $name = '';

    public ?string $gender = '';

    public ?string $first_name = '';

    public ?string $suffix = '';

    public ?string $last_name = '';

    public ?string $department = '';

    public ?string $visiting_address = '';

    public ?string $visiting_address_postcode = '';

    public ?string $visiting_address_city = '';

    public ?string $visiting_address_state = '';

    public ?string $visiting_address_country = '';

    public ?string $postal_address = '';

    public ?string $postal_address_postcode = '';

    public ?string $postal_address_city = '';

    public ?string $postal_address_state = '';

    public ?string $postal_address_country = '';

    public ?string $email = '';

    public ?string $telephone = '';

    public ?string $screen_resolution = '';

    public ?string $expiration_date = '';

    public int $is_active = 0;

    public int $is_system = 0;

    public array $allowed_ips = [];

    public array $roles = [];

    public array $permissions = [];

    public string $password = '';

    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'id' => [
                'nullable',
            ],
            'name' => [
                'required',
            ],
            'password' => [
                'nullable',
                'confirmed',
            ],
            'permissions' => [
                'array',
            ],
        ];
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        $this->fill($user->toArray());

        $this->expiration_date = $this->user->expiration_date?->toDateString();
        $this->roles = $user->roles()->pluck('id')->toArray();
        $this->permissions = $user->permissions()->pluck('id')->toArray();
    }

    public function save()
    {
        $this->validate();

        $data = $this->except(['user', 'password', 'password_confirmation', 'roles', 'permissions']);

        if ($this->user->id) {
            $this->user->update($data);
        } else {
            $this->user = User::create($data);
        }

        if (! empty($this->password)) {
            $this->user->password = \Hash::make($this->password);
            $this->user->save();

            $this->reset(['password', 'password_confirmation']);
        }

        $this->user->roles()->sync($this->roles);

        $permissions = [];
        foreach ($this->permissions as $permission) {
            $permissions[$permission] = ['environment_id' => \Auth::user()->currentEnvironmentId];
        }

        $this->user->permissions()->sync($permissions);

        return $this->user;
    }
}
