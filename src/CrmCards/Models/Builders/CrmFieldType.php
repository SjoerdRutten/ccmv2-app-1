<?php

namespace Sellvation\CCMV2\CrmCards\Models\Builders;

use Illuminate\Database\Eloquent\Model;

class CrmFieldType extends Model
{
    protected $fillable = [
        'name',
        'label',
        'description',
    ];
}
