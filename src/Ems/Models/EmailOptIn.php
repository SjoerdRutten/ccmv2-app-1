<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class EmailOptIn extends Model
{
    protected $fillable = [
        'crm_card_id',
        'crm_field_id',
        'confirmed_at',
        'ip',
        'created_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }

    public function crmField(): BelongsTo
    {
        return $this->belongsTo(CrmField::class);
    }
}
