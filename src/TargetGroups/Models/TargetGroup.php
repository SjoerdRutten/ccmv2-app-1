<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;

class TargetGroup extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'filters',
    ];

    protected function casts()
    {
        return [
            'filters' => 'json',
        ];
    }

    protected function numberOfResults(): Attribute
    {
        return Attribute::make(
            get: fn () => TargetGroupSelectorFacade::count($this->filters)
        );
    }
}
