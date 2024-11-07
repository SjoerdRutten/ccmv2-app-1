<?php

namespace Sellvation\CCMV2\TargetGroups\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Context;
use Maatwebsite\Excel\Facades\Excel;
use Sellvation\CCMV2\TargetGroups\Exports\CrmCardsExport;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;
use Throwable;

class ExportTargetGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly TargetGroupExport $targetGroupExport)
    {
        $this->queue = 'exports';
    }

    public function handle(): void
    {
        $targetGroup = $this->targetGroupExport->targetGroup;

        // Just for testing
        if (! Context::has('environment_id')) {
            Context::add('environment_id', 105);
        }

        $this->targetGroupExport->update([
            'status' => 1,
            'error_message' => null,
            'number_of_records' => $targetGroup->numberOfResults,
        ]);

        switch ($this->targetGroupExport->file_type) {
            case 'xlsx':
                $exportType = \Maatwebsite\Excel\Excel::XLSX;
                break;
            case 'csv':
                $exportType = \Maatwebsite\Excel\Excel::CSV;
                break;
            default:
                throw new \Exception('Unknown filetype');
        }

        $path = 'CRM-Cards-'.now()->toDateTimeLocalString().'.'.$this->targetGroupExport->file_type;

        $this->targetGroupExport->update([
            'disk' => 'local',
            'path' => $path,
        ]);

        if (Excel::store(new CrmCardsExport($this->targetGroupExport), $path, 'local', $exportType)) {
            $this->targetGroupExport->update([
                'status' => 2,
            ]);
        } else {
            $this->targetGroupExport->update([
                'status' => 99,
            ]);
        }
    }

    public function failed(Throwable $exception)
    {
        $this->targetGroupExport->update([
            'status' => 99,
            'error_message' => $exception->getMessage(),
        ]);
    }
}
