<?php

namespace Sellvation\CCMV2\Users\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Users\Models\User;

trait HasUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function bootHasUser()
    {
        static::creating(function (Model $model) {
            if (! app()->runningInConsole() && \Auth::check()) {
                $model->user_id = \Auth::id();
            }
        });
    }
}
