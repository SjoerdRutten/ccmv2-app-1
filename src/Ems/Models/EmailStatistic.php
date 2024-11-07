<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class EmailStatistic extends Model
{
    protected $fillable = [
        'email_id',
        'crm_card_id',
        'send',
        'bounced',
        'opened',
        'clicked',
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
