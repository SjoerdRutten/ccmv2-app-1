<?php

namespace Sellvation\CCMV2\Ems\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\Ems\Models\EmailQueue;

class EmailQueueCreatingEvent
{
    use Dispatchable;

    public function __construct(public readonly EmailQueue $emailQueue) {}
}
