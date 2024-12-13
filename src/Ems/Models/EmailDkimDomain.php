<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailDkimDomain extends Model
{
    protected $fillable = [
        'domain',
    ];

    public function emailDkim(): BelongsTo
    {
        return $this->belongsTo(EmailDkim::class);
    }
}
