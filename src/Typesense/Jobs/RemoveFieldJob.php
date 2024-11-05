<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveFieldJob extends TypesenseJob implements ShouldQueue
{
    public function __construct(private readonly string $collection, private readonly string $fieldName) {}

    public function handle(): void
    {
        try {
            $this->initClient();
            $this->client->collections[$this->collection]
                ->update(['fields' => [
                    [
                        'name' => $this->fieldName,
                        'drop' => true,
                    ],
                ]]);
        } catch (\Exception $e) {
        }
    }
}
