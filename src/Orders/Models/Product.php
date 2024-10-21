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
        $data['brand'] = $this->brand?->name;

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
                ], [
                    'name' => 'sku',
                    'type' => 'string',
                ], [
                    'name' => 'name',
                    'type' => 'string',
                ], [
                    'name' => 'brand',
                    'type' => 'string',
                ],
            ],
        ];
    }
}
