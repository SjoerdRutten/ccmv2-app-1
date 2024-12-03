<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class SitePage extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'site_category_id',
        'site_layout_id',
        'name',
        'slug',
        'description',
        'start_at',
        'end_at',
        'config',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i:s',
        'end_at' => 'datetime:Y-m-d H:i:s',
        'config' => 'json',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function siteLayout(): BelongsTo
    {
        return $this->belongsTo(SiteLayout::class);
    }

    public function sites(): BelongstoMany
    {
        return $this->belongsToMany(Site::class);
    }

    protected function isOnline(): Attribute
    {
        return Attribute::make(
            get: fn () => (! $this->start_at || $this->start_at->isPast()) && (! $this->end_at || $this->end_at->isFuture())
        );
    }
}
