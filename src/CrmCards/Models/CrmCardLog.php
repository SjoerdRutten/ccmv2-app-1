<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrmCardLog extends Model
{
    protected $fillable = [
        'crm_card_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'json',
    ];

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
