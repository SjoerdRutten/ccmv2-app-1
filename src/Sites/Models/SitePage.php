<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SitePage extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'site_id',
        'site_layout_id',
        'name',
        'slug',
        'description',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function siteLayout(): BelongsTo
    {
        return $this->belongsTo(SiteLayout::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
