<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Ccm\Models\Category;

trait HasCategory
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function initializeHasCategory()
    {
        $this->fillable[] = 'category_id';
    }

    public function scopeHasCategory($query, $categoryId)
    {
        $query->whereHas('category', function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        });
    }
}
