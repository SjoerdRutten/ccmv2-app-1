<?php

use Illuminate\Support\Facades\Route;

Route::prefix('target-groups')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('target-groups::')
    ->group(function (): void {
        Route::get('/form/{targetGroup?}', \Sellvation\CCMV2\TargetGroups\Livewire\Form::class)->name('form');
        Route::get('/', \Sellvation\CCMV2\TargetGroups\Livewire\Overview::class)->name('overview');
    });

Route::middleware([
    'auth:sanctum',
    'verified',
    'web',
])
    ->prefix('target-group-api')
    ->name('target-group-api::')
    ->group(function (): void {
        Route::get('/crm-field/search', [\Sellvation\CCMV2\TargetGroups\Controllers\SearchFieldsController::class, 'search'])->name('crm-fields.search');
        Route::get('/crm-field/selected', [\Sellvation\CCMV2\TargetGroups\Controllers\SearchFieldsController::class, 'selected'])->name('crm-fields.selected');
    });
