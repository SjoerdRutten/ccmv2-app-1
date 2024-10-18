<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

Route::get('/', function () {
    return redirect()->route('ccm::dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'web',
    EnsureFeaturesAreActive::using('admin'),
])
    ->group(function (): void {
        Route::prefix('admin')
            ->name('admin::')
            ->group(function (): void {
                Route::get('/features', \Sellvation\CCMV2\Ccm\Livewire\admin\Features::class)->name('features');
            });
    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'web',
])
    ->name('ccm::')
    ->group(function (): void {
        Route::get('/dashboard', \Sellvation\CCMV2\Ccm\Http\Controllers\DashboardController::class)->name('dashboard');
    });
