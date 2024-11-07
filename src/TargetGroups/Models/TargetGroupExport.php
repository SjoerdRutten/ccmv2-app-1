<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportCreatedEvent;
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
    ];

    protected $dispatchesEvents = [
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
}
