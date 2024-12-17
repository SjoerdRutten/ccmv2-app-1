<?php

namespace Sellvation\CCMV2\MailServers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MailServerStat extends Model
{
    use Prunable;

    protected $fillable = [
        'load',
        'memory_total',
        'memory_used',
        'memory_free',
        'queue_size',
        'deferred_queue_size',
    ];

    public function mailServer(): BelongsTo
    {
        return $this->belongsTo(MailServer::class);
    }

    public function prunable()
    {
        return static::where('created_at', '<', now()->subHours(6));
    }
}
