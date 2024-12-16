<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use Sellvation\CCMV2\Orders\Models\OrderMongo;

class CrmCardMongo extends Model
{
    protected $connection = 'mongodb';

    private CrmCard $crmCard;

    public function getTable()
    {
        return 'crm_cards_'.($this->environment_id ?: \Context::get('environment_id'));
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderMongo::class, 'crm_card_id', 'id');
    }

    public function getAttribute($key)
    {
        if (\Arr::exists($this->attributes, $key)) {
            return $this->attributes[$key];
        } elseif (\Arr::exists($this->attributes, 'id')) {
            $this->crmCard = $this->crmCard ?? CrmCard::find($this->attributes['id']);

            return $this->crmCard->$key;
        }
    }
}
