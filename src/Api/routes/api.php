<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Sellvation\CCMV2\Api\Http\Controllers\CrmCardController;

Route::prefix('ccmapi')
    ->middleware([
        'api',
        CheckClientCredentials::class,
    ])
    ->group(function (): void {
        Route::prefix('crm-card')
            ->group(function () {
                Route::get('/{crmCard:crm_id}', [CrmCardController::class, 'show']);
            });
    });
