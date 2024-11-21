<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Sites\Livewire\Sites\Overview;

Route::prefix('cms')
    ->name('cms::')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->group(function (): void {
        Route::prefix('sites')
            ->name('sites::')
            ->group(function () {
                Route::get('/', Overview::class)->name('overview');
            });
    });
