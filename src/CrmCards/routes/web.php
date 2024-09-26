<?php

use Illuminate\Support\Facades\Route;

Route::prefix('crm-cards')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'web',
    ])
    ->name('crm-cards::')
    ->group(function (): void {
        Route::prefix('categories')
            ->name('categories::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Overview::class)->name('overview');
            });

    });
