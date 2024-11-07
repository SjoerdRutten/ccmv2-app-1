<?php

namespace Sellvation\CCMV2\TargetGroups\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;

class TargetGroupExportDeletingEvent
{
    use Dispatchable;

    public function __construct(public readonly TargetGroupExport $targetGroupExport) {}
}
