<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class OrderType extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'environment_id',
        'name',
    ];
}
