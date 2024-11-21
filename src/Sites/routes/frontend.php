<?php

use Illuminate\Support\Facades\Route;

Route::prefix('frontend')
    ->name('frontend::')
    ->middleware([
        'web',
    ])
    ->group(function (): void {});
