<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use Sellvation\CCMV2\Orders\Models\OrderMongo;

class CrmCardMongo extends Model
{
    protected $connection = 'mongodb';

    public function getTable()
    {
        return 'crm_cards_'.($this->environment_id ?: \Context::get('environment_id'));
    }

    public function orders(): HasMany
    {
        return $this->hasMany(OrderMongo::class, 'crm_card_id', 'id');
    }
}
