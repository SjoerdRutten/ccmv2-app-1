<?php

namespace Sellvation\CCMV2\Orders\Events\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;

class UpdateOrderRowTotalListener
{
    public function __construct() {}

    public function handle(OrderRowCreatingEvent $event): void
    {
        $orderRow = $event->orderRow;

        if (! $orderRow->total_price) {
            $orderRow->total_price = $orderRow->amount * $orderRow->unit_price;
        }
    }
}
