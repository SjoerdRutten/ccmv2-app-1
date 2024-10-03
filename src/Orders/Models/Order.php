<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Order extends Model
{
    use HasEnvironment;
    use Searchable;

    protected $fillable = [
        'environment_id',
        'order_type_id',
        'order_number',
        'store',
        'crm_id',
        'order_time',
        'loyalty_card',
        'paymeny_method',
        'processed_at',
    ];

    protected function casts()
    {
        return [
            'order_time' => 'datetime',
        ];
    }

    public function orderRows(): HasMany
    {
        return $this->hasmany(OrderRow::class);
    }

    public function searchableAs()
    {
        return $this->getTable().'_'.(\Auth::check() ? \Auth::user()->currentEnvironmentId : $this->environment_id);
    }

    public function indexableAs()
    {
        return $this->getTable().'_'.(\Auth::check() ? \Auth::user()->currentEnvironmentId : $this->environment_id);
    }

    public function toSearchableArray()
    {
        $eans = $this->orderRows()->with('product')->get()->pluck('product.ean')->toArray();
        $eans = \Arr::whereNotNull($eans);

        $skus = $this->orderRows()->with('product')->get()->pluck('product.sku')->toArray();
        $skus = \Arr::whereNotNull($skus);

        $data = [
            'id' => (string) $this->id,
            'crm_id' => $this->crm_id,
            'order_type_id' => $this->order_type_id,
            'order_number' => $this->order_number,
            'loyalty_card' => $this->loyalty_card,
            'payment_method' => $this->payment_method,
            'store' => (int) $this->store,
            'order_time' => $this->order_time->timestamp,
            'total_price' => (int) $this->total_price,
            'number_of_products' => (int) $this->number_of_products,
            'eans' => $eans,
            'skus' => $skus,
        ];

        return $data;
    }

    public function shouldBeSearchable()
    {
        return (bool) $this->crm_id;
    }

    public function typesenseCollectionSchema()
    {
        return [
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'string',
                ], [
                    'name' => 'order_type_id',
                    'type' => 'int32',
                ], [
                    'name' => 'order_number',
                    'type' => 'string',
                ], [
                    'name' => 'loyalty_card',
                    'type' => 'int64',
                ], [
                    'name' => 'payment_method',
                    'type' => 'string',
                    'optional' => true,
                ], [
                    'name' => 'store',
                    'type' => 'int32',
                ], [
                    'name' => 'order_time',
                    'type' => 'int64',
                ], [
                    'name' => 'total_price',
                    'type' => 'int64',
                    'optional' => true,
                ], [
                    'name' => 'number_of_products',
                    'type' => 'int32',
                    'optional' => true,
                ], [
                    'name' => 'skus',
                    'type' => 'string[]',
                    'optional' => true,
                ], [
                    'name' => 'eans',
                    'type' => 'string[]',
                    'optional' => true,
                ], [
                    'name' => 'crm_id',
                    'type' => 'string',
                    'reference' => 'crm_cards_'.$this->environment_id.'.crm_id',
                ],
            ],
        ];
    }
}
