<?php

namespace Sellvation\CCMV2\MailServers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
}
