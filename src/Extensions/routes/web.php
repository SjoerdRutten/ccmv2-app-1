<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Extensions\Livewire\Edit;
use Sellvation\CCMV2\Extensions\Livewire\Overview;

Route::prefix('admin')
    ->name('admin::')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->group(function (): void {
        Route::prefix('extensions')
            ->name('extensions::')
            ->group(function () {
                Route::get('/', Overview::class)->name('overview');
                Route::get('/add', Edit::class)->name('add');
                Route::get('/{extension}', Edit::class)->name('edit');
            });
    });
