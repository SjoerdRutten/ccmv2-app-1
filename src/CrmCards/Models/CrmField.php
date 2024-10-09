<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavingEvent;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class CrmField extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'id',
        'environment_id',
        'crm_field_type_id',
        'crm_field_category_id',
        'name',
        'label',
        'label_en',
        'label_de',
        'label_fr',
        'is_shown_on_overview',
        'is_shown_on_target_group_builder',
        'is_hidden',
        'is_locked',
        'position',
        'log_file',
        'overview_index',
    ];

    protected $dispatchesEvents = [
        'saved' => CrmFieldSavedEvent::class,
        'saving' => CrmFieldSavingEvent::class,
    ];

    protected function casts()
    {
        return [
            'is_shown_on_overview' => 'boolean',
            'is_shown_on_target_group_builder' => 'boolean',
            'is_hidden' => 'boolean',
            'is_locked' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    public function crmFieldType()
    {
        return $this->belongsTo(CrmFieldType::class);
    }

    public function crmFieldCategory()
    {
        return $this->belongsTo(CrmFieldCategory::class);
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->crmFieldType->name
        );
    }
}
