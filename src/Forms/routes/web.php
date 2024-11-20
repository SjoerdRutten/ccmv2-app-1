<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cms')
    ->name('cms::')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->group(function (): void {
        Route::prefix('forms')
            ->name('forms::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Forms\Livewire\Forms\Overview::class)->name('overview');
                Route::get('/{form}', \Sellvation\CCMV2\Forms\Livewire\Forms\Edit::class)->name('edit');

                Route::post('/{form:uuid}', \Sellvation\CCMV2\Forms\Controllers\CreateFormResponseController::class)->name('create-form-response');
            });
    });
