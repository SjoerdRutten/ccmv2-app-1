<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Api\Http\Controllers\CrmCardController;

Route::prefix('ccmapi')
    ->middleware([
        'api',
    ])
    ->group(function (): void {
        Route::prefix('crm-card')
            ->group(function () {
                Route::get('/{crmCard:crm_id}', [CrmCardController::class, 'show']);
            });
    });
