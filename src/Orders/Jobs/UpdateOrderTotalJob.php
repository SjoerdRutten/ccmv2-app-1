<?php

namespace Sellvation\CCMV2\Orders\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Orders\Models\Order;

class UpdateOrderTotalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Order $order) {}

    public function handle(): void
    {
        $this->order->total_price = $this->order->orderRows()->sum('total_price');
        $this->order->number_of_products = $this->order->orderRows()->sum('amount');
        $this->order->save();
    }
}
