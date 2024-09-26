<?php

use Illuminate\Support\Facades\Route;

Route::prefix('target-groups')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'web',
    ])
    ->name('target-groups::')
    ->group(function (): void {
        Route::get('/form/{targetGroup?}', \Sellvation\CCMV2\TargetGroups\Livewire\Form::class)->name('form');
        Route::get('/', \Sellvation\CCMV2\TargetGroups\Livewire\Overview::class)->name('overview');
    });
