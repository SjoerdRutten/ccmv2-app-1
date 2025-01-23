<?php

namespace Sellvation\CCMV2\Scheduler\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class CcmSchedulerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ccm-scheduler';
    }
}
