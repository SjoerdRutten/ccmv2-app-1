<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Orders\Events\OrderCreatingEvent;
use Sellvation\CCMV2\Orders\Events\OrderSavedEvent;
use Sellvation\CCMV2\Orders\Events\OrderSavingEvent;

class Order extends Model
{
    use HasEnvironment;

    protected $dispatchesEvents = [
        'creating' => OrderCreatingEvent::class,
        'saving' => OrderSavingEvent::class,
        'saved' => OrderSavedEvent::class,
    ];

    protected function casts()
    {
        return [
            'order_time' => 'datetime',
        ];
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }

    public function orderRows(): HasMany
    {
        return $this->hasMany(OrderRow::class);
    }

    public function orderType(): BelongsTo
    {
        return $this->belongsTo(OrderType::class);
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orderRows->sum('total_price')
        );
    }

    protected function numberOfProducts(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orderRows->sum('amount')
        );
    }
}
