<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Typesense\Exceptions\ObjectUnprocessable;

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

            Log::error('Field removed', ['collection' => $this->collection, 'field' => $this->fieldName]);
        } catch (ObjectUnprocessable $e) {
            $this->release(60);
            Log::error('RemoveField: Try again in 60 seconds:', ['collection' => $this->collection, 'field' => $this->fieldName]);
        } catch (\Exception $e) {
            Log::error('RemoveField: '.$e->getMessage(), ['collection' => $this->collection, 'field' => $this->fieldName]);
        }
    }
}
