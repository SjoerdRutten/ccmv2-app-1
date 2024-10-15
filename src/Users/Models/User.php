<?php

namespace Sellvation\CCMV2\Users\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'gender',
        'first_name',
        'suffix',
        'last_name',
        'department',
        'function',
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
        'email',
        'telephone',
        'fax',
        'password',
        'old_password',
        'profile_photo_path',
        'screen_resolution',
        'rows',
        'first_login',
        'last_login',
        'expiration_date',
        'is_active',
        'is_system',
        'allowed_ips',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'old_password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_system' => 'boolean',
            'allowed_ips' => 'json',
        ];
    }

    protected function currentEnvironmentId(): Attribute
    {
        // TODO: return current environment
        return Attribute::make(
            get: fn () => 105
        );
    }
}
