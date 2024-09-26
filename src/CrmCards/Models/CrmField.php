<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Illuminate\Database\Eloquent\Model;

class CrmField extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'crm_field_category_id',
        'name',
        'label',
        'label_en',
        'label_de',
        'label_fr',
        'type',
        'is_shown_on_overview',
        'is_hidden',
        'is_locked',
        'position',
        'log_file',
        'overview_index',
    ];

    protected function casts()
    {
        return [
            'is_shown_on_overview' => 'boolean',
            'is_hidden' => 'boolean',
            'is_locked' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    public function crmFieldCategory()
    {
        return $this->belongsTo(CrmFieldCategory::class);
    }
}
