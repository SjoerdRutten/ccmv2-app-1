<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SiteImport extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'type',
        'position',
        'name',
        'slug',
        'description',
        'body',
        'minimized_body',
    ];

    // TODO: Listener voor minimizing

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }
}
