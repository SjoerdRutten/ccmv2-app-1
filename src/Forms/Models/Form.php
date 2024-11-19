<?php

namespace Sellvation\CCMV2\Forms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Forms\Events\FormCreatingEvent;

class Form extends Model
{
    use HasEnvironment;
    use SoftDeletes;

    protected $fillable = [
        'environment_id',
        'uuid',
        'name',
        'description',
        'fields',
        'html_form',
    ];

    protected $casts = [
        'fields' => 'json',
    ];

    protected $dispatchesEvents = [
        'creating' => FormCreatingEvent::class,
    ];

    public function formResponses(): HasMany
    {
        return $this->hasMany(FormResponse::class);
    }
}
