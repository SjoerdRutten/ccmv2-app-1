<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class EmailOptOut extends Model
{
    protected $fillable = [
        'email_id',
        'crm_card_id',
        'crm_field_id',
        'ip',
        'reason',
        'explanation',
        'created_at',
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }

    public function crmField(): BelongsTo
    {
        return $this->belongsTo(CrmField::class);
    }
}
