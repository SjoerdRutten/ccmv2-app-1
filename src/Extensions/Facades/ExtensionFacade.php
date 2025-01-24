<?php

namespace Sellvation\CCMV2\Extensions\Facades;

use Illuminate\Support\Facades\Facade;

class ExtensionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'extension';
    }
}
