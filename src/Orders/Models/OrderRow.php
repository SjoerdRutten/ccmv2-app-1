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
}
