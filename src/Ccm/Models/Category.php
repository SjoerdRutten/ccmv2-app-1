<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;

class Category extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function targetGroups(): HasMany
    {
        return $this->hasMany(TargetGroup::class);
    }
}
