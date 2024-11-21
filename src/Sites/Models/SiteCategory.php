<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SiteCategory extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
    ];
}
