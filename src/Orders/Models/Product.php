<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Product extends Model
{
    use HasEnvironment;
    use Searchable;

    protected $fillable = [
        'environment_id',
        'brand_id',
        'sku',
        'ean',
        'name',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function searchableAs()
    {
        return $this->getTable().'_'.$this->environment_id;
    }

    public function indexableAs()
    {
        return $this->searchableAs();
    }

    public function toSearchableArray()
    {
        $data = $this->toArray();
        $data['id'] = (string) $data['id'];
        $data['brand'] = (string) $this->brand?->name;

        return $data;
    }

    public function typesenseCollectionSchema()
    {
        return [
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'string',
                ], [
                    'name' => 'ean',
                    'type' => 'string',
                    'optional' => true,
                ], [
                    'name' => 'sku',
                    'type' => 'string',
                    'optional' => true,
                ], [
                    'name' => 'name',
                    'type' => 'string',
                ], [
                    'name' => 'brand',
                    'type' => 'string',
                    'optional' => true,
                ],
            ],
        ];
    }

    public function shouldBeSearchable()
    {
        return true;
    }
}
