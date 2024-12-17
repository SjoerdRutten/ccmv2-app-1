<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\MailServers\Livewire\Edit;
use Sellvation\CCMV2\MailServers\Livewire\Overview;

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
                Route::get('/', Overview::class)->name('overview');
                Route::get('/add', Edit::class)->name('add');
                Route::get('/{mailServer}', Edit::class)->name('edit');
            });
    });
