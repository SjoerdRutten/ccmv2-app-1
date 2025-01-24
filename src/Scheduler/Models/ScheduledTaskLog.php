<?php

namespace Sellvation\CCMV2\Scheduler\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledTaskLog extends Model
{
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
        return static::where(
            function (Builder $query) {
                $query->where('is_success', 1)
                    ->where('created_at', '<', now()->subDays(2));
            }
        )->orWhere(
            function (Builder $query) {
                $query->where('is_success', 0)
                    ->where('created_at', '<', now()->subWeek());
            }
        );
    }
}
