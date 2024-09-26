<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Support\Facades\Config;
use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1Command;
use Sellvation\CCMV2\CcmV1\Console\Commands\MigrateCcmV1Environment;
use Illuminate\Support\ServiceProvider;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');
    }
}
