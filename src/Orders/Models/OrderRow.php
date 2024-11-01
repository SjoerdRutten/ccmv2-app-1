<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatedEvent;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;

class OrderRow extends Model
{
    use Searchable;

    protected $fillable = [
        'order_id',
        'product_id',
        'order_row_id',
        'amount',
        'unit',
        'unit_price',
        'total_price',
        'extra_data',
    ];

    protected $dispatchesEvents = [
        'creating' => OrderRowCreatingEvent::class,
        'saved' => OrderRowCreatedEvent::class,
    ];

    protected function casts()
    {
        return [
            'extra_data' => 'array',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function searchableAs()
    {
        return $this->getTable().'_'.$this->order->environment_id;
    }

    public function indexableAs()
    {
        return $this->searchableAs();
    }

    public function toSearchableArray()
    {
        $data = $this->toArray();
        $data['id'] = (string) $this->id;
        $data['order_id'] = (string) $this->order_id;
        $data['product_id'] = (string) $this->product_id;
        $data['amount'] = (int) $data['amount'];
        $data['unit_price'] = (int) $data['unit_price'];
        $data['total_price'] = (int) $data['total_price'];

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
                    'name' => 'order_id',
                    'type' => 'string',
                    'reference' => 'orders_'.$this->order->environment_id.'.id',
                ], [
                    'name' => 'product_id',
                    'type' => 'string',
                    'reference' => 'products_'.$this->order->environment_id.'.id',
                ], [
                    'name' => 'is_promo',
                    'type' => 'int32',
                ], [
                    'name' => 'amount',
                    'type' => 'int64',
                    'optional' => true,
                ], [
                    'name' => 'unit_price',
                    'type' => 'int32',
                ], [
                    'name' => 'total_price',
                    'type' => 'int32',
                ],
            ],
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->order->shouldBeSearchable();
    }
}
