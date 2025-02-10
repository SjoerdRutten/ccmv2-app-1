<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderSavedEvent;
use Sellvation\CCMV2\Orders\Jobs\UpdateOrderMongoDbJob;
use Sellvation\CCMV2\Orders\Jobs\UpdateOrderTotalJob;

class OrderReadyListener
{
    public function __construct() {}

    public function handle(OrderSavedEvent $event): void
    {
        UpdateOrderTotalJob::dispatch($event->order)
            ->chain([
                new UpdateOrderMongoDbJob($event->order),
            ]);

    }
}
