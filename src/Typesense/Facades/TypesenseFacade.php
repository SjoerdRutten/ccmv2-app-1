<?php

namespace Sellvation\CCMV2\Typesense\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Typesense
 */
class TypesenseFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'typesense';
    }
}
