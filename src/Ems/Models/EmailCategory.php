<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class EmailCategory extends Model
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

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }
}
