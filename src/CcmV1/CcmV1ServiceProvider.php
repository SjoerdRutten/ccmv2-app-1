<?php

namespace Sellvation\CCMV2\CcmV1;

use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1Environment;
use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1GlobalCommand;

class CcmV1ServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->commands([
            MigrateCcmV1GlobalCommand::class,
            MigrateCcmV1Environment::class,
        ]);
    }
}
