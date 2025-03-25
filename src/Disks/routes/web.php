<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Disks\Livewire\Disks\Edit;
use Sellvation\CCMV2\Disks\Livewire\Disks\Overview;

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

Route::prefix('admin/disktypes')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('admin::disktypes::')
    ->group(function (): void {
        Route::get('/', \Sellvation\CCMV2\Disks\Livewire\DiskTypes\Overview::class)->name('overview');
        Route::get('/add', \Sellvation\CCMV2\Disks\Livewire\DiskTypes\Edit::class)->name('add');
        Route::get('/{diskType}', \Sellvation\CCMV2\Disks\Livewire\DiskTypes\Edit::class)->name('edit');
    });
