<?php

namespace Sellvation\CCMV2\Orders\Listeners;

use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;

class OrderRowCreatedListener
{
    public function __construct() {}

    public function handle(OrderRowCreatingEvent $event): void {}
}
