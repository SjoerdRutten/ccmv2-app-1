<?php

namespace Sellvation\CCMV2\Extensions\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Config;

trait InteractsWithCcmpCrmCards
{
    protected function getCrmCardQuery(array $select = ['*'], string $connection = 'db02'): Builder
    {
        if (! \Context::has('environment_id')) {
            throw new \Exception('Environment id not set in context');
        }

        Config::set('database.connections.'.$connection.'.database', 'ccmp');
        \DB::purge($connection);

        return \DB::connection($connection)
            ->table('crm_'.\Context::get('environment_id'))
            ->select($select);
    }

    protected function getCrmCardByCrmId(string $crmId, array $select = ['*'], string $connection = 'db02')
    {
        return $this->getCrmCardQuery($select, $connection)
            ->where('crm_id', $crmId)
            ->first();
    }
}
