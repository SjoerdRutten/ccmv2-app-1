<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Ems\Events\EmailDkimCreatedEvent;

class EmailDkim extends Model
{
    protected $fillable = [
        'email_domain_id',
        'selector_prefix',
        'private_key',
        'public_key',
        'expires_at',
        'status',
        'status_message',
        'status_timestamp',
    ];

    protected $casts = [
        'expires_at' => 'datetime:Y-m-d H:i',
        'status_timestamp' => 'datetime:Y-m-d H:i',
    ];

    protected $dispatchesEvents = [
        'created' => EmailDkimCreatedEvent::class,
    ];

    public function emailDomain(): BelongsTo
    {
        return $this->belongsTo(EmailDomain::class);
    }

    public function emailDkimDomains(): HasMany
    {
        return $this->hasMany(EmailDkimDomain::class);
    }

    protected function dnsRecordKey(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->selector_prefix.'._domainkey'
        );
    }

    protected function dnsRecordValue(): Attribute
    {
        return Attribute::make(
            get: fn () => 'v=DKIM1;p='.\Str::replace(['-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'], '', $this->public_key)
        );
    }
}
