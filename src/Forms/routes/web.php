<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cms/forms')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('forms::')
    ->group(function (): void {
        Route::get('/', \Sellvation\CCMV2\Forms\Livewire\Forms\Overview::class)->name('overview');
        Route::get('/{form}', \Sellvation\CCMV2\Forms\Livewire\Forms\Edit::class)->name('edit');

        Route::post('/{form:uuid}', \Sellvation\CCMV2\Forms\Controllers\CreateFormResponseController::class)->name('create-form-response');
    });
