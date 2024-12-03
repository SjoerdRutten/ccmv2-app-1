<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SiteScraper extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_layout_id',
        'site_block_id',
        'name',
        'description',
        'target',
        'url',
        'base_url',
        'start_tag',
        'end_tag',
        'last_scraped_at',
        'status',
        'original_html',
        'converted_html',
    ];

    public function siteLayout(): BelongsTo
    {
        return $this->belongsTo(SiteLayout::class);
    }

    public function siteBlock(): BelongsTo
    {
        return $this->belongsTo(SiteBlock::class);
    }
}
