<?php

namespace Sellvation\CCMV2\Orders\Events\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderRowCreatedEvent;

class UpdateOrderTotalsListener
{
    public function __construct() {}

    public function handle(OrderRowCreatedEvent $event): void
    {
        $order = $event->orderRow->order;

        $order->total_price = $order->orderRows()->sum('total_price');
        $order->number_of_products = $order->orderRows()->sum('amount');
        $order->save();
    }
}
