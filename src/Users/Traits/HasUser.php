<?php

namespace Sellvation\CCMV2\Users\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasUser
{
    public static function bootHasUser()
    {
        static::creating(function (Model $model) {
            if (! app()->runningInConsole() && \Auth::check()) {
                $model->user_id = \Auth::id();
            }
        });
    }
}
