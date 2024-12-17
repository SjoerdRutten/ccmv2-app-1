<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin::')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->group(function (): void {
        Route::prefix('mailservers')
            ->name('mailservers::')
            ->group(function () {
                Route::get('/', Sellvation\CCMV2\Mailservers\Livewire\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\Mailservers\Livewire\Edit::class)->name('add');
                Route::get('/{mailServer}', \Sellvation\CCMV2\Mailservers\Livewire\Edit::class)->name('edit');
            });
    });
