<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class EmailDomain extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'domain',
        'description',
        'return_path',
        'dkim_selector_prefix',
        'dkim_private_key',
        'dkim_public_key',
        'dkim_expires_at',
        'dkim_status',
        'dkim_status_message',
        'dkim_status_timestamp',
    ];

    protected $casts = [
        'dkim_expires_at' => 'datetime:Y-m-d H:i',
        'dkim_status_timestamp' => 'datetime:Y-m-d H:i',
    ];

    public function emailDkims(): HasMany
    {
        return $this->hasMany(EmailDkim::class);
    }
}
