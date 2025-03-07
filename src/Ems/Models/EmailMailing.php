<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Ccm\Traits\HasTrackedJobs;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class EmailMailing extends Model
{
    use HasEnvironment;
    use HasTrackedJobs;

    protected $fillable = [
        'email_id',
        'target_group_id',
        'name',
        'description',
        'status',
        'start_at',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }
}
