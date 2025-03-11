<?php

namespace Sellvation\CCMV2\Users\Livewire\Users\Forms;

use Carbon\Carbon;
use Livewire\Form;
use Sellvation\CCMV2\Users\Models\User;

class ApiForm extends Form
{
    public User $user;

    public ?string $name = '';

    public ?string $expires_at = '';

    public array $scopes = [];

    public function setUser(User $user)
    {
        $this->user = $user;

    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'expires_at' => [
                'nullable',
                'date',
            ],
            'scopes' => [
                'required',
                'array',
            ],
        ];
    }

    public function create()
    {
        $this->validate();

        $token = $this->user->createToken($this->name, $this->scopes, Carbon::parse($this->expires_at));

        return $token->plainTextToken;
    }
}
