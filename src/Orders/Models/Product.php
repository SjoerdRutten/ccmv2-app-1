<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        'name',
    ];

    protected $hidden = [
        'environment_id',
        'brand_id',
        'created_at',
        'updated_at',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function eans(): HasMany
    {
        return $this->hasMany(ProductEan::class);
    }

    public function searchableAs()
    {
        if ($this->environment_id) {
            $environmentId = $this->environment_id;
        } elseif (app()->runningInConsole()) {
            if (\Context::has('environment_id')) {
                $environmentId = \Context::get('environment_id');
            } else {
                $environmentId = config('ccm.environment_id');
            }
        } else {
            $environmentId = \Auth::check() ? \Auth::user()->currentEnvironmentId : $this->environment_id;
        }

        return $this->getTable().'_'.$environmentId;
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
        $data['ean'] = Arr::map($this->eans()->pluck('ean')->toArray(), function ($item) {
            return (int) $item;
        });
        $data['name_infix'] = $this->makeStringArray($data['name']);

        return $data;
    }

    public function typesenseCollectionSchema()
    {
        $fields = [
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'string',
                ], [
                    'name' => 'ean',
                    'type' => 'int64[]',
                    'optional' => true,
                ], [
                    'name' => 'sku',
                    'type' => 'string',
                    'optional' => true,
                ], [
                    'name' => 'name',
                    'type' => 'string',
                ], [
                    'name' => 'name_infix',
                    'type' => 'string[]',
                ], [
                    'name' => 'brand',
                    'type' => 'string',
                    'optional' => true,
                ],
            ],
        ];

        $fields['fields'] = array_merge($fields['fields'], \CustomFields::getSchemaFields('products'));

        return $fields;
    }

    public function shouldBeSearchable()
    {
        return true;
    }

    private function makeStringArray($string)
    {
        $data = [];
        do {
            if (! empty($string[0])) {
                $data[] = $string;
            }
            $string = Str::substr($string, 1);
        } while (strlen($string) > 2);

        return $data;
    }
}
