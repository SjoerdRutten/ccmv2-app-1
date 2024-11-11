<?php

namespace Sellvation\CCMV2\Typesense\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Orders\Models\Order;
use Sellvation\CCMV2\Orders\Models\Product;

class CheckSchemaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Model $model;

    public function __construct(private readonly string $modelName)
    {
        $this->queue = 'typesense';
    }

    public function handle(): void
    {
        switch ($this->modelName) {
            case 'Order':
                $this->model = new Order;
                break;
            case 'Product':
                $this->model = new Product;
                break;
            case 'CrmCard':
                $this->model = new CrmCard;
                break;
        }

        $schemaFields = $this->model->typesenseCollectionSchema();

        $collection = \Typesense::getCollection($this->model->indexableAs());

        $dropFields = [];
        $addFields = [];
        $updateFields = [];

        $ignoreFields = ['id', '.*'];

        // Find fields in collection which aren't in the schema definition of the model anymore
        foreach ($collection['fields'] as $field) {
            if (! in_array($field['name'], $ignoreFields)) {
                $find = \Arr::where($schemaFields['fields'], function ($value, $key) use ($field) {
                    return $value['name'] === $field['name'];
                });

                if (count($find) === 0) {
                    $dropFields[] = [
                        'name' => $field['name'],
                        'drop' => true,
                    ];
                }
            }
        }

        // Find fields in schema definition to be added to schema
        foreach ($schemaFields['fields'] as $field) {
            if (! in_array($field['name'], $ignoreFields)) {
                $find = \Arr::where($collection['fields'], function ($value, $key) use ($field) {
                    return $value['name'] === $field['name'];
                });

                if (count($find) === 0) {
                    $addFields[] = $field;
                }
            }
        }

        // Find fields in schema to update
        foreach ($schemaFields['fields'] as $field) {
            if (! in_array($field['name'], $ignoreFields)) {
                $find = \Arr::where($collection['fields'], function ($value, $key) use ($field) {
                    if ($value['name'] === $field['name']) {
                        return
                            (\Arr::get($value, 'type') !== \Arr::get($field, 'type')) ||
                            (\Arr::get($value, 'optional') !== (bool) \Arr::get($field, 'optional')) ||
                            (\Arr::get($value, 'facet') !== (bool) \Arr::get($field, 'facet'));
                    }

                    return false;
                });

                if (count($find) > 0) {
                    $updateFields[] = [
                        'name' => $field['name'],
                        'drop' => true,
                    ];
                    $updateFields[] = $field;
                }
            }
        }

        $fields = array_merge($dropFields, $addFields, $updateFields);

        if (count($fields)) {
            \Typesense::updateCollectionSchema($this->model->indexableAs(), ['fields' => $fields]);
        }
    }
}
