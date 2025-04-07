<?php

namespace Sellvation\CCMV2\TargetGroups\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Context;
use Maatwebsite\Excel\Facades\Excel;
use Sellvation\CCMV2\Disks\Models\Disk;
use Sellvation\CCMV2\TargetGroups\Exports\CrmCardsExport;
use Sellvation\CCMV2\TargetGroups\Models\TargetGroupExport;
use Throwable;

class ExportTargetGroupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 360;

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
            'started_at' => now(),
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

        if ($disk = Disk::whereHas('diskTypes', function ($query) {
            $query->whereName('DGS Export');
        })->first()) {

            $path = 'CRM-Cards-'.now()->toDateTimeLocalString().'.'.$this->targetGroupExport->file_type;
            $path = implode('/', [$disk->settings['path'], $path]);

            $this->targetGroupExport->update([
                'disk_id' => $disk->id,
                'path' => $path,
            ]);

            if ($data = Excel::raw(new CrmCardsExport($this->targetGroupExport), $exportType)) {
                /** @var Filesystem $disk */
                $fsDisk = \DiskService::disk($disk);
                $fsDisk->put($path, $data);

                $this->targetGroupExport->update([
                    'status' => 2,
                    'ended_at' => now(),
                ]);
            } else {
                $this->targetGroupExport->update([
                    'status' => 99,
                    'ended_at' => now(),
                ]);
            }
        } else {
            throw new \Exception('Geen disk gevonden voor DGS Export');
        }
    }

    public function failed(Throwable $exception)
    {
        $this->targetGroupExport->update([
            'status' => 99,
            'error_message' => $exception->getMessage(),
            'ended_at' => now(),
        ]);
    }
}
