<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Sites\Controllers\Frontend\FaviconController;

Route::name('frontend::')
    ->middleware([
        'web',
    ])
    ->group(function (): void {
        Route::get('{site}/favicon.ico', FaviconController::class)->name('favicon');
    });
