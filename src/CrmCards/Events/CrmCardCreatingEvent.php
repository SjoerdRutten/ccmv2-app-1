<?php

namespace Sellvation\CCMV2\CrmCards\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class CrmCardCreatingEvent
{
    use Dispatchable;

    public function __construct(public readonly CrmCard $crmCard) {}
}
