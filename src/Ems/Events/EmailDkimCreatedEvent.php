<?php

namespace Sellvation\CCMV2\Ems\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\Ems\Models\EmailDkim;

class EmailDkimCreatedEvent
{
    use Dispatchable;

    public function __construct(public readonly EmailDkim $emailDkim) {}
}
