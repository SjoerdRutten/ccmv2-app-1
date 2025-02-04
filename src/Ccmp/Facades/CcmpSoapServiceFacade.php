<?php

namespace Sellvation\CCMV2\Ccmp\Facades;

use Illuminate\Support\Facades\Facade;

class CcmpSoapServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ccmp-soap-service';
    }
}
