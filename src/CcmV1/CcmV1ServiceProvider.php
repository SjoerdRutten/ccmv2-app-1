<?php

namespace Sellvation\CCMV2\CcmV1;

use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1Command;
use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1Environment;
use Illuminate\Support\ServiceProvider;

class CcmV1ServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->commands([
            MigrateCcmV1Command::class,
            MigrateCcmV1Environment::class,
        ]);
    }
}
