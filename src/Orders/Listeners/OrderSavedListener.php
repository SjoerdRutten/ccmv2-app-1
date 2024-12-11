<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderSavedEvent;
use Sellvation\CCMV2\Orders\Jobs\UpdateOrderMongoDbJob;

class OrderSavedListener
{
    public function __construct() {}

    public function handle(OrderSavedEvent $event): void
    {
        UpdateOrderMongoDbJob::dispatch($event->order);
    }
}
