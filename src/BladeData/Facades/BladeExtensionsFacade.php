<?php

namespace Sellvation\CCMV2\BladeData\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class BladeExtensionsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'blade-extensions';
    }
}
