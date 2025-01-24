<?php

namespace Sellvation\CCMV2\Extensions\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Extensions\Enums\ExtensionTypes;

class Extension extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'queue',
        'is_active',
        'class',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'type' => ExtensionTypes::class,
        'settings' => 'array',
    ];
}
