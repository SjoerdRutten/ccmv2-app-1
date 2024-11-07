<?php

namespace Sellvation\CCMV2\TargetGroups\Events\Listeners;

use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportDeletingEvent;
use Sellvation\CCMV2\TargetGroups\Jobs\DeleteTargetGroupExportStorageJob;

class DeleteExportListener
{
    public function __construct() {}

    public function handle(TargetGroupExportDeletingEvent $event): void
    {
        DeleteTargetGroupExportStorageJob::dispatch($event->targetGroupExport);
    }
}
