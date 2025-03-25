<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Disks\Models\Disk;
use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportCreatedEvent;
use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportDeletingEvent;
use Sellvation\CCMV2\Users\Traits\HasUser;

class TargetGroupExport extends Model
{
    use HasUser;

    protected $fillable = [
        'status',
        'error_message',
        'progress',
        'number_of_records',
        'file_type',
        'disk',
        'path',
        'target_group_fieldset_id',
        'started_at',
        'ended_at',
        'expected_end_time',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'expected_end_time' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'deleting' => TargetGroupExportDeletingEvent::class,
        'created' => TargetGroupExportCreatedEvent::class,
    ];

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }

    public function targetGroupFieldset(): BelongsTo
    {
        return $this->belongsTo(TargetGroupFieldset::class);
    }

    public function disk(): BelongsTo
    {
        return $this->belongsTo(Disk::class);
    }
}
