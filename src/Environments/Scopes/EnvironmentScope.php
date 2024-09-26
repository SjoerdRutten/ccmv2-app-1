<?php

namespace Sellvation\CCMV2\Environments\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EnvironmentScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (\Auth::check()) {
            $builder->where('environment_id', \Auth::user()->current_environment_id);
        }
    }
}
