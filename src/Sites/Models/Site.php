<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Sites\Events\SiteSavingEvent;
use Sellvation\CCMV2\Sites\Events\SiteUpdatingEvent;

class Site extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'site_page_id',
        'name',
        'domain',
        'favicon_disk',
        'favicon',
    ];

    protected $dispatchesEvents = [
        'updating' => SiteUpdatingEvent::class,
        'saving' => SiteSavingEvent::class,
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function sitePage(): BelongsTo
    {
        return $this->belongsTo(SitePage::class);
    }

    public function siteLayouts(): HasMany
    {
        return $this->hasMany(SiteLayout::class);
    }
}
