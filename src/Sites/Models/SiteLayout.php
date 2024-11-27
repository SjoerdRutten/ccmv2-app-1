<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SiteLayout extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'follow',
        'index',
        'body',
    ];

    protected $casts = [
        'follow' => 'boolean',
        'index' => 'boolean',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }
}
