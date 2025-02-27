<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'signed:relative',
])
    ->name('public::')
    ->prefix('p')
    ->group(function (): void {
        Route::get('/tl/e/{email}/{trackableLink}/{crmCard}', \Sellvation\CCMV2\Ccm\Controllers\TrackableLinkController::class)->name('trackable_link');
        Route::get('/tp/{onlineVersion}/{email}/{crmCard}.jpg', \Sellvation\CCMV2\Ccm\Controllers\TrackingPixelController::class)->name('tracking_pixel');
    });
