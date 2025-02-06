<?php

namespace Sellvation\CCMV2\Orders;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Orders\Events\OrderReadyEvent;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;
use Sellvation\CCMV2\Orders\Facades\CustomOrderFields;
use Sellvation\CCMV2\Orders\Facades\CustomOrderFieldsFacade;
use Sellvation\CCMV2\Orders\Listeners\OrderReadyListener;
use Sellvation\CCMV2\Orders\Listeners\OrderRowCreatingListener;
use Sellvation\CCMV2\Orders\Models\Order;
use Sellvation\CCMV2\Orders\Models\OrderRow;
use Sellvation\CCMV2\Orders\Models\Product;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerEvents();
        $this->registerFacades();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }

        // Unguard models to be able to fill all custom fields
        Order::unguard();
        Product::unguard();
        OrderRow::unguard();
    }

    private function registerLivewireComponents(): void {}

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(OrderRowCreatingEvent::class, OrderRowCreatingListener::class);
        $events->listen(OrderReadyEvent::class, OrderReadyListener::class);
    }

    private function registerFacades()
    {
        $this->app->bind('custom-order-fields', CustomOrderFields::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CustomOrderFields', CustomOrderFieldsFacade::class);
    }
}
