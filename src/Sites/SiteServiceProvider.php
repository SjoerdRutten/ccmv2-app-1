<?php

namespace Sellvation\CCMV2\Sites;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Sites\Events\SitePageVisitCreatedEvent;
use Sellvation\CCMV2\Sites\Events\SiteSavingEvent;
use Sellvation\CCMV2\Sites\Events\SiteUpdatingEvent;
use Sellvation\CCMV2\Sites\Http\Controllers\FaviconController;
use Sellvation\CCMV2\Sites\Http\Controllers\SiteImportController;
use Sellvation\CCMV2\Sites\Http\Controllers\SitePageController;
use Sellvation\CCMV2\Sites\Listeners\SitePageVisitCreatedListener;
use Sellvation\CCMV2\Sites\Listeners\SiteSavingListener;
use Sellvation\CCMV2\Sites\Listeners\SiteUpdatingListener;
use Sellvation\CCMV2\Sites\Livewire\Sites\Edit;
use Sellvation\CCMV2\Sites\Livewire\Sites\Overview;
use Sellvation\CCMV2\Sites\Models\Site;

class SiteServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'sites');

        $this->registerEvents();
        $this->registerFrontendRoutes();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('blocks::overview', \Sellvation\CCMV2\Sites\Livewire\Blocks\Overview::class);
        Livewire::component('blocks::edit', \Sellvation\CCMV2\Sites\Livewire\Blocks\Edit::class);
        Livewire::component('imports::overview', \Sellvation\CCMV2\Sites\Livewire\Imports\Overview::class);
        Livewire::component('imports::edit', \Sellvation\CCMV2\Sites\Livewire\Imports\Edit::class);
        Livewire::component('layouts::overview', \Sellvation\CCMV2\Sites\Livewire\Layouts\Overview::class);
        Livewire::component('layouts::edit', \Sellvation\CCMV2\Sites\Livewire\Layouts\Edit::class);
        Livewire::component('pages::overview', \Sellvation\CCMV2\Sites\Livewire\Pages\Overview::class);
        Livewire::component('pages::edit', \Sellvation\CCMV2\Sites\Livewire\Pages\Edit::class);
        Livewire::component('scrapers::overview', \Sellvation\CCMV2\Sites\Livewire\Scrapers\Overview::class);
        Livewire::component('scrapers::edit', \Sellvation\CCMV2\Sites\Livewire\Scrapers\Edit::class);
        Livewire::component('sites::overview', Overview::class);
        Livewire::component('sites::edit', Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(SiteUpdatingEvent::class, SiteUpdatingListener::class);
        $events->listen(SiteSavingEvent::class, SiteSavingListener::class);
        $events->listen(SitePageVisitCreatedEvent::class, SitePageVisitCreatedListener::class);
    }

    private function registerFrontendRoutes()
    {
        $router = app()->make('router');

        try {
            foreach (Site::all() as $site) {
                $router->domain($site->domain)
                    ->middleware([
                        'web',
                    ])
                    ->name('frontend::')
                    ->group(function () use ($router, $site) {
                        $router->get('assets/favicon.ico', FaviconController::class)->name('assets.favicon');
                        $router->get('assets/{siteImport}/{name}', SiteImportController::class)->name('assets.siteImport');
                        $router->get('/{sitePage:slug}', SitePageController::class)->name('sitePage.'.$site->id);
                        $router->get('/', SitePageController::class)->name('homePage.'.$site->id);
                    });
            }
        } catch (\Exception $e) {
        }
    }
}
