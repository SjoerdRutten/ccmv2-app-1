<?php

namespace Sellvation\CCMV2\Orders\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CustomFields
 */
class CustomFieldsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'custom-fields';
    }
}
