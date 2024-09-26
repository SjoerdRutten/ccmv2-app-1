<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see TargetGroupSelector
 */
class TargetGroupSelectorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TargetGroupSelector::class;
    }
}
