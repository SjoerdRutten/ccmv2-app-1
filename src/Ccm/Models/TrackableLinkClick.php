<?php

namespace Sellvation\CCMV2\Ccm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;

class TrackableLinkClick extends Model
{
    protected $fillable = [
        'trackable_link_id',
        'crm_card_id',
    ];

    public function trackableLink(): BelongsTo
    {
        return $this->belongsTo(TrackableLink::class);
    }

    public function crmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
