<?php

namespace Sellvation\CCMV2\CrmCards\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Sellvation\CCMV2\CrmCards\Models\CrmCardImport;

class ImportCrmCardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $numberOfRows = 0;

    private int $quantityUpdatedRows = 0;

    private int $quantityCreatedRows = 0;

    private int $quantityEmptyRows = 0;

    private int $quantityErrorRows = 0;

    private array $updatedRows = [];

    private array $createdRows = [];

    private array $emptyRows = [];

    private array $errorRows = [];

    public function __construct(private readonly CrmCardImport $import)
    {
        \Context::add('environment_id', 105);
    }

    public function handle(): void
    {
        $this->import->update([
            'started_at' => now(),
            'finished_at' => null,
            'number_of_rows' => 0,
            'quantity_updated_rows' => 0,
            'updated_rows' => [],
            'quantity_created_rows' => 0,
            'created_rows' => [],
            'quantity_empty_rows' => 0,
            'empty_rows' => [],
            'quantity_error_rows' => 0,
            'error_rows' => [],

        ]);

        Excel::import((new \Sellvation\CCMV2\CrmCards\Imports\CrmCardChunkedImport($this->import)), $this->import->path);

        $this->import->save();

        $this->import->update(['finished_at' => now()]);
    }

    public function failed(): void
    {
        $this->import->update(['finished_at' => now()]);
    }
}
