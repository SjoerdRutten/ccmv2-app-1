<?php

namespace Sellvation\CCMV2\MailServers\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class MailServer extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'position',
        'host',
        'description',
        'port',
        'username',
        'password',
        'encryption',
        'is_active',
        'is_valid',
        'status',
    ];

    public function mailServerStats(): HasMany
    {
        return $this->hasMany(MailServerStat::class)->latest();
    }

    public function mailServerStat(): HasOne
    {
        return $this->hasOne(MailServerStat::class)->latest();
    }

    public function sendRules(): BelongsToMany
    {
        return $this->belongsToMany(SendRule::class);
    }

    protected function keyName(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::replace('.', '_', $this->host)
        );
    }
}
