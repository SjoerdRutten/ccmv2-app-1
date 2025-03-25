<?php

namespace Sellvation\CCMV2\Disks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class DiskType extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'disk_id',
        'name',
    ];

    public function disk(): BelongsTo
    {
        return $this->belongsTo(Disk::class);
    }
}
