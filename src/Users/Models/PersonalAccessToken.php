<?php

namespace Sellvation\CCMV2\Users\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumToken;

class PersonalAccessToken extends SanctumToken
{
    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if ($model->isDirty('last_used_at')) {

                if (($model->getOriginal('last_used_at') !== null) && $model->getOriginal('last_used_at')->isAfter(now()->subDay())) {
                    $model->last_used_at = $model->getOriginal('last_used_at');
                }
            }

            $dirty = collect($model->getDirty())->keys();
            if ($dirty->count() === 0) {
                return false; // Blokkeer de update
            }
        });
    }
}
