<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Typesense\Exceptions\ObjectUnprocessable;

class AddFieldJob extends TypesenseJob implements ShouldQueue
{
    public function __construct(private readonly string $collection, private readonly array $field) {}

    public function handle(): void
    {
        try {
            $this->initClient();
            $this->client->collections[$this->collection]
                ->update(['fields' => [$this->field]]);

            Log::error('Field added', ['collection' => $this->collection, 'field' => $this->fieldName]);
        } catch (ObjectUnprocessable $e) {
            $this->release(60);
            Log::error('AddField: Try again in 60 seconds:', ['collection' => $this->collection, 'field' => $this->fieldName]);
        } catch (\Exception $e) {
            Log::error('AddField: '.$e->getMessage(), ['collection' => $this->collection, 'field' => $this->fieldName]);
        }
    }
}
