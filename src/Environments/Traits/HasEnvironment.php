<?php

namespace Sellvation\CCMV2\Environments\Traits;

use Sellvation\CCMV2\Environments\Models\Environment;
use Sellvation\CCMV2\Environments\Scopes\EnvironmentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasEnvironment
{
    public function initializeHasEnvironment()
    {
        if (! app()->runningInConsole()) {
            $this->fillable[] = 'environment_id';
        }
    }

    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class);
    }

    public static function bootHasEnvironment()
    {
        static::addGlobalScope(new EnvironmentScope);

        static::creating(function (Model $model) {
            if (! app()->runningInConsole() && \Auth::check()) {
                $model->environment_id = \Auth::user()->current_environment_id;
            }
        });
    }
}
