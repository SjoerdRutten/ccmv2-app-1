<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'signed:relative',
])
    ->name('public::')
    ->prefix('p')
    ->group(function (): void {
        Route::get('/tl/e/{email}/{trackableLink}/{crmCard}', \Sellvation\CCMV2\Ccm\Http\Controllers\TrackableLinkController::class)->name('trackable_link');
        Route::get('/tp/{onlineVersion}/{email}/{crmCard}.jpg', \Sellvation\CCMV2\Ccm\Http\Controllers\TrackingPixelController::class)->name('tracking_pixel');
    });

Route::middleware(['web'])
    ->prefix('serverstatus')
    ->name('serverstatus::')
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->group(function (): void {
        Route::get('/', \Sellvation\CCMV2\Ccm\Http\Controllers\ServerStatusController::class)->name('serverstatus');
        Route::post('/{server}', [\Sellvation\CCMV2\Ccm\Http\Controllers\ServerStatusController::class, 'set']);
    });
