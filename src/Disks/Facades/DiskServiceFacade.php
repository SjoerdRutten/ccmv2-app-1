<?php

namespace Sellvation\CCMV2\Disks\Facades;

use Illuminate\Support\Facades\Facade;

class DiskServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'disk-service';
    }
}
