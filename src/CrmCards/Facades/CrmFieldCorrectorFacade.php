<?php

namespace Sellvation\CCMV2\CrmCards\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class CrmFieldCorrectorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'crm-field-correctors';
    }
}
