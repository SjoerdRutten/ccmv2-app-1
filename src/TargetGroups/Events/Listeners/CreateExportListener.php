<?php

namespace Sellvation\CCMV2\TargetGroups\Events\Listeners;

use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportCreatedEvent;
use Sellvation\CCMV2\TargetGroups\Jobs\ExportTargetGroupJob;

class CreateExportListener
{
    public function __construct() {}

    public function handle(TargetGroupExportCreatedEvent $event): void
    {
        ExportTargetGroupJob::dispatch($event->targetGroupExport);
    }
}
