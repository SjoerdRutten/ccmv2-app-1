<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavingEvent;
use Sellvation\CCMV2\CrmCards\Models\Builders\CrmFieldQueryBuilder;
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
        'pre_processing_rules',
        'validation_rules',
        'post_processing_rules',
        'is_shown_on_overview',
        'is_shown_on_target_group_builder',
        'is_hidden',
        'is_locked',
        'position',
        'log_file',
        'overview_index',
    ];

    //    protected $dispatchesEvents = [
    //        'saved' => CrmFieldSavedEvent::class,
    //        'saving' => CrmFieldSavingEvent::class,
    //    ];

    protected function casts()
    {
        return [
            'is_shown_on_overview' => 'boolean',
            'is_shown_on_target_group_builder' => 'boolean',
            'is_hidden' => 'boolean',
            'is_locked' => 'boolean',
            'is_visible' => 'boolean',
            'pre_processing_rules' => 'json',
            'validation_rules' => 'json',
            'post_processing_rules' => 'json',
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

    public function correctAndValidate($value, $required = false): mixed
    {
        $value = $this->preCorrectValue($value);
        $this->validate($value, $required);

        return $this->postCorrectValue($value);
    }

    public function preCorrectValue($value): mixed
    {
        return $this->correctValue($value, $this->pre_processing_rules);
    }

    public function postCorrectValue($value): mixed
    {
        return $this->correctValue($value, $this->post_processing_rules);
    }

    private function correctValue($value, $rules): mixed
    {
        if (is_array($rules)) {
            foreach ($rules as $rule) {
                if ($corrector = \Arr::get($rule, 'corrector')) {
                    $corrector = new $corrector;
                    $value = $corrector->handle($value, $rule);

                    if ($value === false) {
                        return false;
                    }
                }
            }
        }

        return $value;
    }

    /**
     * @params $value
     *
     * @throws ValidationException
     */
    public function validate($value, $required = false): void
    {
        $rules = [];
        $messages = [];

        if ($required) {
            $rules[] = 'required';
            $messages[] = 'Veld '.$this->name.' is verplicht';
        }

        if (is_array($this->validation_rules)) {
            foreach ($this->validation_rules as $rule) {
                $validationRule = new ($rule['rule']);
                $rules = array_merge($rules, $validationRule->getRules($this, ...$rule));
                $messages = array_merge($messages, $validationRule->getMessages($this, ...$rule));
            }
        }

        if (count($rules)) {
            Validator::validate(
                ['value' => $value],
                ['value' => $rules],
                ['value' => $messages],
            );
        }
    }

    public function newEloquentBuilder($query)
    {
        return new CrmFieldQueryBuilder($query);
    }
}
