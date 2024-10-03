<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ems')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'web',
    ])
    ->name('ems::')
    ->group(function (): void {
        Route::prefix('emails')
            ->name('emails::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\Emails\Overview::class)->name('overview');
                Route::get('/{email}', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class)->name('edit');
                //                Route::get('/{email}', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class)->name('edit');
            });
    });
