<?php

namespace Sellvation\CCMV2\Orders\Models;

use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'environment_id',
        'name',
    ];
}
