<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Site extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'site_page_id',
        'name',
        'domain',
        'favicon',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function sitePage(): BelongsTo
    {
        return $this->belongsTo(SitePage::class);
    }
}
