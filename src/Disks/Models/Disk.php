<?php

namespace Sellvation\CCMV2\Disks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Disk extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'description',
        'type',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function diskTypes(): HasMany
    {
        return $this->hasMany(DiskType::class);
    }
}
