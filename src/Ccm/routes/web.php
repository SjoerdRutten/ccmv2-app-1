<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::prefix('admin')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'web',
        EnsureFeaturesAreActive::using('admin'),
    ])
    ->name('admin::')
    ->group(function (): void {
        Route::get('/features', \Sellvation\CCMV2\Ccm\Livewire\admin\Features::class)->name('features');
    });
