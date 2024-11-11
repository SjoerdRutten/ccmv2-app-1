<?php

namespace Sellvation\CCMV2\Orders;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Orders\Events\Listeners\UpdateOrderRowTotalListener;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;
use Sellvation\CCMV2\Orders\Facades\CustomFields;
use Sellvation\CCMV2\Orders\Facades\CustomFieldsFacade;
use Sellvation\CCMV2\Orders\Models\Order;
use Sellvation\CCMV2\Orders\Models\OrderRow;
use Sellvation\CCMV2\Orders\Models\Product;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('custom-fields', CustomFields::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CustomFields', CustomFieldsFacade::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->registerEvents();

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

        $events->listen(OrderRowCreatingEvent::class, UpdateOrderRowTotalListener::class);
    }
}
