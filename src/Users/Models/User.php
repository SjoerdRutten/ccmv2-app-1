<?php

namespace Sellvation\CCMV2\Users\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Sellvation\CCMV2\Environments\Models\Environment;
use Sellvation\CCMV2\Users\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    //    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'role_id',
        'customer_id',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'expiration_date' => 'date',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_system' => 'boolean',
            'allowed_ips' => 'json',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id')
            ->withPivot('environment_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    protected function active(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_active && (! $this->expiration_date || $this->expiration_date->isAfter(now()))
        );
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles()->where('is_admin', 1)->exists()
        );
    }

    protected function currentEnvironmentId(): Attribute
    {
        return Attribute::make(
            get: fn () => \Session::has('environment_id') ? \Session::get('environment_id') : $this->customer->environments()->first()->id
        );
    }

    protected function currentEnvironment(): Attribute
    {
        return Attribute::make(
            get: fn () => Environment::find($this->currentEnvironmentId)
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function hasPermissionTo($group, $permission)
    {
        return $this->roles()
            ->where('is_admin', 1)
            ->orWhereHas('permissions', function ($query) use ($group, $permission) {
                $query
                    ->where('model_has_permissions.environment_id', $this->currentEnvironmentId)
                    ->whereGroup($group)
                    ->whereName($permission);
            })->exists()
            ||
            $this->permissions()
                ->where('model_has_permissions.environment_id', $this->currentEnvironmentId)
                ->whereGroup($group)
                ->whereName($permission)
                ->exists();
    }
}
