<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\Sites\Events\SitePageVisitCreatedEvent;

class SitePageVisit extends Model
{
    protected $fillable = [
        'site_page_id',
        'crm_card_id',
        'crm_id',
        'browser_ua',
        'browser',
        'browser_device_type',
        'browser_device',
        'browser_os',
        'ip',
        'uri',
        'referer',
    ];

    protected $dispatchesEvents = [
        'created' => SitePageVisitCreatedEvent::class,
    ];

    public function SitePage(): BelongsTo
    {
        return $this->belongsTo(SitePage::class);
    }

    public function CrmCard(): BelongsTo
    {
        return $this->belongsTo(CrmCard::class);
    }
}
