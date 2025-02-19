<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/data_feeds')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('df::')
    ->group(function (): void {
        Route::get('/', \Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Overview::class)->name('overview');
        Route::get('/add', \Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Edit::class)->name('add');
        Route::get('/{dataFeed}', \Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Edit::class)->name('edit');
    });
