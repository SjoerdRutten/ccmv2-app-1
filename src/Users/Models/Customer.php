<?php

namespace Sellvation\CCMV2\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Models\Environment;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'helpdesk_user_id',
        'name',
        'visiting_address',
        'visiting_address_postcode',
        'visiting_address_city',
        'visiting_address_state',
        'visiting_address_country',
        'postal_address',
        'postal_address_postcode',
        'postal_address_city',
        'postal_address_state',
        'postal_address_country',
        'telephone',
        'fax',
        'email',
        'url',
        'logo',
        'personal_team',
        'allowed_ips',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'allowed_ips' => 'json',
        ];
    }

    public function environments(): HasMany
    {
        return $this->hasMany(Environment::class);
    }
}
