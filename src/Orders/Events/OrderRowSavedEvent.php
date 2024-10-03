<?php

namespace Sellvation\CCMV2\Orders\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\Orders\Models\OrderRow;

class OrderRowSavedEvent
{
    use Dispatchable;

    public function __construct(public readonly OrderRow $orderRow) {}
}
