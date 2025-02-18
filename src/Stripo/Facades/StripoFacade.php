<?php

namespace Sellvation\CCMV2\Stripo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class StripoFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'stripo';
    }
}
