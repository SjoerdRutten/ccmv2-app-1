<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Support\Facades\Config;
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
