<?php

namespace Sellvation\CCMV2\DataFeeds\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see CrmFieldCorrector
 */
class DataFeedConnectorFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'data-feed-connector';
    }
}
