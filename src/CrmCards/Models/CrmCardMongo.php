<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmCardMongoQueryBuilder;
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

    protected function crmCard(): Attribute
    {
        return Attribute::make(
            get: fn () => CrmCard::find($this->id)
        );
    }

    public function getAttribute($key)
    {
        if (\Arr::exists($this->attributes, $key)) {
            return $this->attributes[$key];
        } elseif (\Arr::exists($this->attributes, 'id')) {
            //            dd($this->attributes['id']);
            $this->crmCard = $this->crmCard ?? CrmCard::find($this->attributes['id']);

            return $this->crmCard->$key;
        }
    }

    public function newEloquentBuilder($query)
    {
        return new CrmCardMongoQueryBuilder($query);
    }
}
