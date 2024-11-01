<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Order extends Model
{
    use HasEnvironment;
    use Searchable;

    protected $fillable = [
        'environment_id',
        'order_type_id',
        'crm_card_id',
        'order_number',
        'crm_id',
        'store',
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

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }

    public function orderRows(): HasMany
    {
        return $this->hasmany(OrderRow::class);
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
        $data = [
            'id' => (string) $this->id,
            'crm_card_id' => (string) $this->crm_card_id,
            'order_type_id' => $this->order_type_id,
            'order_number' => $this->order_number,
            'loyalty_card' => $this->loyalty_card,
            'payment_method' => $this->payment_method,
            'store' => (int) $this->store,
            'order_time' => $this->order_time->timestamp,
            'total_price' => (int) $this->total_price,
            'number_of_products' => (int) $this->number_of_products,
        ];

        return $data;
    }

    public function shouldBeSearchable()
    {
        return (bool) $this->crm_card_id;
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
                    'optional' => true,
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
                    'name' => 'crm_card_id',
                    'type' => 'string',
                    'reference' => 'crm_cards_'.$this->environment_id.'.id',
                ],
            ],
        ];
    }
}
