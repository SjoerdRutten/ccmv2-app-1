<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Illuminate\Database\Eloquent\Model;

class CrmFieldCategory extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'name_en',
        'name_de',
        'name_fr',
        'is_visible',
        'position',
    ];

    protected function casts()
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public function crmFields() : HasMany
    {
        return $this->hasMany(CrmField::class);
    }
}
