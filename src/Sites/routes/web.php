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
        Route::prefix('sites')
            ->name('sites::')
            ->group(function () {
                Route::get('/', Sellvation\CCMV2\Sites\Livewire\Sites\Overview::class)->name('overview');
                Route::get('/new', \Sellvation\CCMV2\Sites\Livewire\Sites\Edit::class)->name('add');
                Route::get('/{site}', \Sellvation\CCMV2\Sites\Livewire\Sites\Edit::class)->name('edit');
            });
        Route::prefix('layouts')
            ->name('layouts::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Sites\Livewire\Layouts\Overview::class)->name('overview');
                Route::get('/new', \Sellvation\CCMV2\Sites\Livewire\Layouts\Edit::class)->name('add');
                Route::get('/{siteLayout}', \Sellvation\CCMV2\Sites\Livewire\Layouts\Edit::class)->name('edit');
            });
        Route::prefix('imports')
            ->name('imports::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Sites\Livewire\Imports\Overview::class)->name('overview');
                Route::get('/new', \Sellvation\CCMV2\Sites\Livewire\Imports\Edit::class)->name('add');
                Route::get('/{siteImport}', \Sellvation\CCMV2\Sites\Livewire\Imports\Edit::class)->name('edit');
            });
    });
