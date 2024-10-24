<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEan extends Model
{
    protected $fillable = [
        'product_id',
        'ean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
