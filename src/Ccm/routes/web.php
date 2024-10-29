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
                Route::get('/features', \Sellvation\CCMV2\Ccm\Livewire\Admin\Features::class)->name('features');
                Route::get('/customers/{customer}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Edit::class)->name('customers.edit');
                Route::get('/customers', \Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Overview::class)->name('customers');
                Route::get('/environments/{environment}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Edit::class)->name('environments.edit');
                Route::get('/environments', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Overview::class)->name('environments');
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
        Route::get('/typesense/collection/{collectionName}', \Sellvation\CCMV2\Ccm\Livewire\Typesense\Collection::class)->name('typesense.collection');
        Route::get('/typesense/collection/{collectionName}/reindex', \Sellvation\CCMV2\Ccm\Controllers\TypesenseReindexCollectionController::class)->name('typesense.reindex');
    });
