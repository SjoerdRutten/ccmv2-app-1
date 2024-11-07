<?php

namespace Sellvation\CCMV2\TargetGroups\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;

class DeleteTargetGroupExportStorageJob
{
    use Dispatchable, SerializesModels;

    public function __construct(private readonly TargetGroupExport $targetGroupExport) {}

    public function handle(): void
    {
        if (\Storage::disk($this->targetGroupExport->disk)->exists($this->targetGroupExport->path)) {
            \Storage::disk($this->targetGroupExport->disk)->delete($this->targetGroupExport->path);
        }
    }
}
