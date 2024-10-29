<?php

namespace Sellvation\CCMV2\Ccm\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TypesenseReindexCollectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly string $collectionName, private readonly string $model) {}

    public function handle(): void
    {
        \Typesense::removeCollection($this->collectionName);

        $model = $this->model;
        $model::query()->searchable();
    }

    public function viaQueue()
    {
        return 'typesense';
    }
}
