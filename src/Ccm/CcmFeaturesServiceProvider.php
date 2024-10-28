<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Sellvation\CCMV2\Environments\Models\Environment;

class CcmFeaturesServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        Feature::resolveScopeUsing(fn ($driver) => Auth::user()?->currentEnvironment);

        $environmentFeatures = [
            'crm',
            'ems',
            'targetGroups',
        ];

        $userFeatures = [
            'admin',
        ];

        foreach ($environmentFeatures as $feature) {
            Feature::define($feature, fn (Environment $environment) => Auth::user()->isAdmin || $environment->hasFeature($feature));
        }
        foreach ($userFeatures as $feature) {
            Feature::define($feature, fn (Environment $environment) => Auth::user()->isAdmin);
        }
    }
}
