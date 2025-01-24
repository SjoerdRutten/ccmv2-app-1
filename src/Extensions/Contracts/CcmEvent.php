<?php

namespace Sellvation\CCMV2\Extensions\Contracts;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class CcmEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Returns string with name of listener
     */
    abstract public static function getName(): string;

    /**
     * Returns string with description of listener
     */
    abstract public static function getDescription(): string;
}
