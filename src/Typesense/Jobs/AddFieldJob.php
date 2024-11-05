<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class AddFieldJob extends TypesenseJob implements ShouldQueue
{
    public function __construct(private readonly string $collection, private readonly array $field) {}

    public function handle(): void
    {
        try {
            $this->initClient();
            $this->client->collections[$this->collection]
                ->update(['fields' => [$this->field]]);
        } catch (\Exception $e) {
        }
    }
}
