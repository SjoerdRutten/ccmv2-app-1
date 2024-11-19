<?php

namespace Sellvation\CCMV2\Forms\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\Forms\Models\FormResponse;

class FormResponseCreatedEvent
{
    use Dispatchable;

    public function __construct(public readonly FormResponse $formResponse) {}
}
