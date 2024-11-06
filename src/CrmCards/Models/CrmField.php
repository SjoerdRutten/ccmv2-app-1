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

    public function getTypesenseFields(): array
    {
        $fields = [];

        switch ($this->type) {
            case 'BOOLEAN':
            case 'CONSENT':
                $fieldType = 'bool';
                break;
            case 'DATETIME':
                $fieldType = 'int64';
                break;
            case 'DECIMAL':
                $fieldType = 'float';
                break;
            case 'INT':
                $fieldType = 'int32';
                break;
            case 'MEDIA':
                $fields[] = ['name' => '_'.$this->name.'_allowed', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_optin', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_optin_timestamp', 'type' => 'int64', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_confirmed_optin', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_confirmed_optin_timestamp', 'type' => 'int64', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_confirmed_optout', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_optout_timestamp', 'type' => 'int64', 'optional' => true];

                $fieldType = false;
                break;
            case 'EMAIL':
                $fields[] = ['name' => $this->name, 'type' => 'string', 'optional' => true];
                $fields[] = ['name' => $this->name.'_infix', 'type' => 'string[]', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_valid', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_possible', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_abuse', 'type' => 'bool', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_abuse_timestamp', 'type' => 'int64', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_bounce_reason', 'type' => 'string', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_bounce_score', 'type' => 'int32', 'optional' => true];
                $fields[] = ['name' => '_'.$this->name.'_bounce_type', 'type' => 'string', 'optional' => true, 'facet' => true];
                $fields[] = ['name' => '_'.$this->name.'_type', 'type' => 'string', 'optional' => true, 'facet' => true];

                $fieldType = false;
                break;
            case 'TEXTBIG':
            case 'TEXTMICRO':
            case 'TEXTMIDDLE':
            case 'TEXTMINI':
            case 'TEXTSMALL':
            default:
                $fields[] = ['name' => $this->name, 'type' => 'string', 'optional' => true];
                $fields[] = ['name' => $this->name.'_infix', 'type' => 'string[]', 'optional' => true];

                $fieldType = false;
        }

        if ($fieldType) {
            $fields[] = [
                'name' => $this->name,
                'type' => $fieldType,
                'optional' => true,
            ];
        }

        return $fields;
    }
}
