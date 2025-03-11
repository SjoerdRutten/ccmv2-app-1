<?php

namespace Sellvation\CCMV2\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class ApiScopesFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-scopes';
    }
}
