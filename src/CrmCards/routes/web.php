<?php

use Illuminate\Support\Facades\Route;

Route::prefix('crm-cards')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('crm-cards::')
    ->group(function (): void {
        Route::prefix('fields')
            ->name('fields::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class)->name('add');
                Route::get('/{crmField}', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class)->name('edit');
            });
        Route::prefix('cards')
            ->name('cards::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class)->name('add');
                Route::get('/{crmCard}', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class)->name('edit');
            });
        Route::prefix('categories')
            ->name('categories::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Overview::class)->name('overview');
                Route::get('/new', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Edit::class)->name('add');
                Route::get('/{crmCard}', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Edit::class)->name('edit');
            });
        Route::prefix('imports')
            ->name('imports::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\CrmCards\Livewire\Imports\Overview::class)->name('overview');
                Route::get('/new', \Sellvation\CCMV2\CrmCards\Livewire\Imports\Edit::class)->name('add');
                Route::get('/{crmCardImport}', \Sellvation\CCMV2\CrmCards\Livewire\Imports\Edit::class)->name('edit');
            });

    });
