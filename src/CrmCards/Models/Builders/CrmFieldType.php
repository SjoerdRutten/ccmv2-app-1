<?php

namespace Sellvation\CCMV2\CrmCards\Models\Builders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Models\CrmField;

class CrmFieldType extends Model
{
    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    public function crmFields(): HasMany
    {
        return $this->hasMany(CrmField::class);
    }
}
