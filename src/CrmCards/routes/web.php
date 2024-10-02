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
        Route::prefix('fields')
            ->name('fields::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Overview::class)->name('overview');
                Route::get('/{crmField}', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class)->name('edit');
            });
        Route::prefix('cards')
            ->name('cards::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Overview::class)->name('overview');
                Route::get('/{crmCard}', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class)->name('edit');
            });

    });
