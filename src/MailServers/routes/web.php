<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\MailServers\Livewire\MailServers\Edit;
use Sellvation\CCMV2\MailServers\Livewire\MailServers\Overview;

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
        Route::prefix('sendrules')
            ->name('sendrules::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\MailServers\Livewire\SendRules\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\MailServers\Livewire\SendRules\Edit::class)->name('add');
                Route::get('/{sendRule}', \Sellvation\CCMV2\MailServers\Livewire\SendRules\Edit::class)->name('edit');
            });
    });
