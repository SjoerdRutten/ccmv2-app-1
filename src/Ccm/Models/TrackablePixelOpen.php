<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class TrackablePixelOpen extends Model
{
    protected $fillable = [
        'crm_card_id',
        'online_version',
    ];

    protected $casts = [
        'online_version' => 'boolean',
    ];

    public function trackable(): MorphTo
    {
        return $this->morphTo();
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
