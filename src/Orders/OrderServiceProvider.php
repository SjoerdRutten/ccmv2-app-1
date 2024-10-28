<?php

namespace Sellvation\CCMV2\Orders;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Orders\Events\Listeners\UpdateOrderRowTotalListener;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void {}

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(OrderRowCreatingEvent::class, UpdateOrderRowTotalListener::class);
    }
}
