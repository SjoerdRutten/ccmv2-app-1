<?php

namespace Sellvation\CCMV2\Ccm\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class CcmMenuFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ccm-menu';
    }
}
