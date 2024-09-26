<?php

namespace Sellvation\CCMV2\Orders\Events;

use Sellvation\CCMV2\Orders\Models\OrderRow;
use Illuminate\Foundation\Events\Dispatchable;

class OrderRowSavedEvent
{
    use Dispatchable;

    public function __construct(public readonly OrderRow $orderRow) {}
}
