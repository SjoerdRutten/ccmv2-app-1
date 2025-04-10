<?php

namespace Sellvation\CCMV2\TargetGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class TargetGroupFieldset extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
    ];

    public function crmFields(): BelongsToMany
    {
        return $this->belongsToMany(CrmField::class)->withPivot('field_name');
    }
}
