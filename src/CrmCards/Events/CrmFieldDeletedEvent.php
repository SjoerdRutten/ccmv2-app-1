<?php

namespace Sellvation\CCMV2\CrmCards\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class CrmFieldDeletedEvent
{
    use Dispatchable;

    public function __construct(public readonly CrmField $crmField) {}
}
