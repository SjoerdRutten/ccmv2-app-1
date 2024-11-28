<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Sites\Models\Builders\SiteImportQueryBuilder;

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

    protected function js(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'js'
        );
    }

    protected function css(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->type === 'css'
        );
    }

    public function newEloquentBuilder($query)
    {
        return new SiteImportQueryBuilder($query);
    }
}
