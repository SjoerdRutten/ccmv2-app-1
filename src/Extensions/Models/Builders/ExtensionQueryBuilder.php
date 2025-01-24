<?php

namespace Sellvation\CCMV2\Extensions\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ExtensionQueryBuilder extends Builder
{
    public function isActive(): self
    {
        return $this->where('is_active', true)
            ->where(
                function ($query) {
                    $query->whereNull('start_at')
                        ->orWhere('start_at', '<=', now());
                }
            )
            ->where(
                function ($query) {
                    $query->whereNull('end_at')
                        ->orWhere('end_at', '>', now());
                }
            );
    }
}
