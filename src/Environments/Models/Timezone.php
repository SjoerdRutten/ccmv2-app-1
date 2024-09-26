<?php

namespace Sellvation\CCMV2\Environments\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $fillable = [
        'id',
        'timezone',
        'name',
    ];
}
