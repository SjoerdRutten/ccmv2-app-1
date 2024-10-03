<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Orders\Events\OrderRowSavedEvent;

class OrderRow extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'order_row_id',
        'amount',
        'unit',
        'price',
        'sku',
        'ean',
        'extra_data',
    ];

    protected $dispatchesEvents = [
        'saved' => OrderRowSavedEvent::class,
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
