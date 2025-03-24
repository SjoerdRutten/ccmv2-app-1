<?php

namespace Sellvation\CCMV2\Disks\Models;

use Illuminate\Database\Eloquent\Model;
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
}
