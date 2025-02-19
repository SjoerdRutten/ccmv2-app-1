<?php

namespace Sellvation\CCMV2\Extensions\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected function showActive(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->is_active && (! $this->start_at || $this->start_at?->isPast()) && (! $this->end_at || $this->end_at?->isFuture());
            }
        );
    }

    public function newEloquentBuilder($query)
    {
        return new ExtensionQueryBuilder($query);
    }
}
