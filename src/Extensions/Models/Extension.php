<?php

namespace Sellvation\CCMV2\Extensions\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Extensions\Models\Builders\ExtensionQueryBuilder;

class Extension extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'event',
        'listener',
        'settings',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function newEloquentBuilder($query)
    {
        return new ExtensionQueryBuilder($query);
    }
}
