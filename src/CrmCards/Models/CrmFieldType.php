<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Illuminate\Database\Eloquent\Model;

class CrmFieldType extends Model
{
    protected $fillable = [
        'name',
        'label',
    ];
}
