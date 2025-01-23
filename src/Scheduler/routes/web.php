<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Edit;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Overview;

Route::prefix('admin')
    ->name('admin::')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->group(function (): void {
        Route::prefix('scheduler')
            ->name('scheduler::')
            ->group(function () {
                Route::get('/', Overview::class)->name('overview');
                Route::get('/add', Edit::class)->name('add');
                Route::get('/{schedule}', Edit::class)->name('edit');
            });
    });
