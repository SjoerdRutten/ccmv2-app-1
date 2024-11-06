<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Users\Traits\HasUser;

class TargetGroupExport extends Model
{
    use HasUser;

    protected $fillable = [
        'config',
        'path',
    ];

    protected $casts = [
        'is_ready' => 'boolean',
        'config' => 'json',
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
