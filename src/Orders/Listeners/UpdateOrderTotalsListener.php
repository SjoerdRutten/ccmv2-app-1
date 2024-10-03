<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Sellvation\CCMV2\Orders\Events\OrderRowSavedEvent;

class UpdateOrderTotalsListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct() {}

    public function handle(OrderRowSavedEvent $event): void
    {
        $order = $event->orderRow->order;

        $order->total_price = $order->orderRows()->sum('price');
        $order->number_of_products = $order->orderRows()->sum('amount');
        $order->save();
    }
}
