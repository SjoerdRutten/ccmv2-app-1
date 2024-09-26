<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Illuminate\Database\Eloquent\Model;

class TargetGroup extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'filters',
    ];

    protected function casts()
    {
        return [
            'filters' => 'json',
        ];
    }
}
