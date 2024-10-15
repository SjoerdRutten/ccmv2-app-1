<?php

namespace App\Models;

use App\Domains\Environments\Models\Environment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

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
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
            'allowed_ips' => 'json',
        ];
    }

    public function environments(): HasMany
    {
        return $this->hasMany(Environment::class);
    }

    public function helpdeskUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'helpdesk_user_id');
    }
}
