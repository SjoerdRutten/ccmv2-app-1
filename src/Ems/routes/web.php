<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::prefix('ems')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
        EnsureFeaturesAreActive::using('ems'),
    ])
    ->name('ems::')
    ->group(function (): void {
        Route::prefix('emails')
            ->name('emails::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\Emails\Overview::class)->name('overview');
                Route::get('/{email}', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class)->name('edit');
            });
        Route::prefix('emailcontents')
            ->name('emailcontents::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Overview::class)->name('overview');
                Route::get('/{emailContent}', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Edit::class)->name('edit');
            });
    });
