<?php

namespace Sellvation\CCMV2\Orders\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Orders\Models\OrderRow;

class UpdateOrderRowTotalJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly OrderRow $orderRow) {}

    public function handle(): void
    {
        $orderRow = $this->orderRow;

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
