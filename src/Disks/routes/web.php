<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Disks\Livewire\Edit;
use Sellvation\CCMV2\Disks\Livewire\Overview;

Route::prefix('admin/disks')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('admin::disks::')
    ->group(function (): void {
        Route::get('/', Overview::class)->name('overview');
        Route::get('/add', Edit::class)->name('add');
        Route::get('/{disk}', Edit::class)->name('edit');
    });
