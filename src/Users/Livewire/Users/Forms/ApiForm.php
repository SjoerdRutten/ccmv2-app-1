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

    public int $allScopes = 1;

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
                'required_if:allScopes,0',
                'array',
            ],
        ];
    }

    public function create()
    {
        $this->validate();

        $expiresAt = empty($this->expires_at) ? null : Carbon::parse($this->expires_at);
        $scopes = $this->allScopes ? ['*'] : $this->scopes;

        $token = $this->user->createToken($this->name, $scopes, $expiresAt);

        return $token->plainTextToken;
    }
}
