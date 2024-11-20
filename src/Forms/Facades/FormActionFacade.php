<?php

namespace Sellvation\CCMV2\Forms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class FormActionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'form-action';
    }
}
