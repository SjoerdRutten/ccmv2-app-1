<?php

namespace Sellvation\CCMV2\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group',
        'name',
        'description',
    ];

    public function permissionable(): MorphTo
    {
        return $this->morphTo();
    }
}
