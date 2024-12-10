<?php

namespace Sellvation\CCMV2\Orders\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;
use Sellvation\CCMV2\CrmCards\Models\CrmCardMongo;

class OrderMongo extends Model
{
    protected $connection = 'mongodb';

    public function getTable()
    {
        return 'orders_'.($this->environment_id ?: \Context::get('environment_id'));
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCardMongo::class);
    }
}
