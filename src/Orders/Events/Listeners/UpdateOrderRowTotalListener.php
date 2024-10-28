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
            $totalPrice = $orderRow->amount * $orderRow->unit_price;

            if ($totalPrice < 2147483647) {
                $orderRow->total_price = $totalPrice;
            } else {
                $orderRow->total_price = 0;
            }
        }
    }
}
