<?php

namespace Sellvation\CCMV2\Ems\Facades;

use Illuminate\Support\Facades\Facade;

class EmailCompilerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'email-compiler';
    }
}
