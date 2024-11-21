<?php

namespace Sellvation\CCMV2\CrmCards\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldType;

class CrmFieldQueryBuilder extends Builder
{
    public function isCrmFieldType(CrmFieldType|string $crmFieldType): self
    {
        $crmFieldType = ! is_string($crmFieldType) ? $crmFieldType->name : $crmFieldType;

        $this->whereHas('crmFieldType', function (Builder $builder) use ($crmFieldType) {
            $builder->whereName($crmFieldType);
        });

        return $this;
    }

    public function isDatetimeFieldType(): self
    {
        return $this->isCrmFieldType('DATETIME');
    }

    public function isEmailFieldType(): self
    {
        return $this->isCrmFieldType('EMAIL');
    }

    public function isMediaFieldType(): self
    {
        return $this->isCrmFieldType('MEDIA');
    }
}
