<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use MongoDB\Laravel\Eloquent\Model;

class CrmCardMongo extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'crm_cards';

    public function getTable()
    {
        return 'crm_cards_'.($this->environment_id ?: \Context::get('environment_id'));
    }
}
