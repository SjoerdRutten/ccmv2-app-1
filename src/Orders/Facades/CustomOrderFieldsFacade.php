<?php

namespace Sellvation\CCMV2\Orders\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CustomOrderFields
 */
class CustomOrderFieldsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'custom-order-fields';
    }
}
