<?php

namespace Sellvation\CCMV2\Sites\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'config',
        'body',
    ];

    protected $casts = [
        'follow' => 'boolean',
        'index' => 'boolean',
        'config' => 'json',
    ];

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class);
    }

    public function siteImports(): BelongsToMany
    {
        return $this->belongsToMany(SiteImport::class)
            ->withPivot('position');
    }

    public function siteImportsJs(): BelongsToMany
    {
        return $this->belongsToMany(SiteImport::class)
            ->withPivot('position')
            ->isJs()
            ->orderBy('position');
    }

    public function siteImportsCss(): BelongsToMany
    {
        return $this->belongsToMany(SiteImport::class)
            ->withPivot('position')
            ->isCss()
            ->orderBy('position');
    }
}
