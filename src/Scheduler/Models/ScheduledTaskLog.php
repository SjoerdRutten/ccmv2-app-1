<?php

namespace Sellvation\CCMV2\Scheduler\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class ScheduledTaskLog extends Model
{
    use HasEnvironment;
    use Prunable;

    protected $fillable = [
        'is_success',
        'output',
        'error_message',
    ];

    public function scheduledTask(): BelongsTo
    {
        return $this->belongsTo(ScheduledTask::class);
    }

    public function prunable()
    {
        return $this->created_at->isBefore(now()->subMonth());
    }
}
