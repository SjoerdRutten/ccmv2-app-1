<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;
use Sellvation\CCMV2\Orders\Jobs\UpdateOrderTotalJob;

class OrderRowCreatedListener
{
    public function __construct() {}

    public function handle(OrderRowCreatingEvent $event): void
    {
        UpdateOrderTotalJob::dispatch($event->orderRow->order);
    }
}
