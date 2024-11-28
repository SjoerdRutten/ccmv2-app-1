<?php

namespace Sellvation\CCMV2\Sites\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class SiteImportQueryBuilder extends Builder
{
    public function isJs(): self
    {
        return $this->where('type', 'js');
    }

    public function isCss(): self
    {
        return $this->where('type', 'css');
    }
}
