<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatedEvent;
use Sellvation\CCMV2\Orders\Events\OrderRowCreatingEvent;

class OrderRow extends Model
{
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
        $data = [];
        $data['id'] = (string) $this->id;
        $data['order_id'] = (string) $this->order_id;
        $data['product_id'] = (string) $this->product_id;
        $data['amount'] = (int) $this->amount;
        $data['unit_price'] = (int) $this->unit_price;
        $data['total_price'] = (int) $this->total_price;
        $data['is_promo'] = (int) $this->is_promo;

        return $data;
    }
}
