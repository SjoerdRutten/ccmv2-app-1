<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;
use Sellvation\CCMV2\Orders\Jobs\UpdateOrderRowTotalJob;

class OrderRowCreatingListener
{
    public function __construct() {}

    public function handle(OrderRowCreatingEvent $event): void
    {
        UpdateOrderRowTotalJob::dispatchSync($event->orderRow);
    }
}
