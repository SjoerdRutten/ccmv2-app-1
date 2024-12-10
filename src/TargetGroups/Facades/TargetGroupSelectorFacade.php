<?php

namespace Sellvation\CCMV2\TargetGroups\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class TargetGroupSelectorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TargetGroupSelectorMongo::class;
    }
}
