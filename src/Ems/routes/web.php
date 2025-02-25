<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    'signed:relative',
])
    ->group(function () {
        Route::get('/online_version/{email}/{crmCard}', \Sellvation\CCMV2\Ems\Http\Controllers\OnlineVersionController::class)->name('public.online_version');
        Route::get('/opt_out/{email}/{crmCard}', \Sellvation\CCMV2\Ems\Http\Controllers\OptOutController::class)->name('public.opt_out');
    });

Route::prefix('ems')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('ems::')
    ->group(function (): void {
        Route::prefix('emails')
            ->name('emails::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\Emails\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class)->name('add');
                Route::get('/{email}', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class)->name('edit');
                Route::get('/preview/{email}/{crmCard}', \Sellvation\CCMV2\Ems\Http\Controllers\PreviewController::class)->name('preview');
            });
        Route::prefix('emailcontents')
            ->name('emailcontents::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Overview::class)->name('overview');
                Route::get('/{emailContent}', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Edit::class)->name('edit');
            });
    });

Route::prefix('admin')
    ->middleware([
        'auth:sanctum',
        'verified',
        'web',
    ])
    ->name('admin::')
    ->group(function (): void {
        Route::prefix('email_domains')
            ->name('email_domains::')
            ->group(function () {
                Route::get('/', \Sellvation\CCMV2\Ems\Livewire\EmailDomains\Overview::class)->name('overview');
                Route::get('/add', \Sellvation\CCMV2\Ems\Livewire\EmailDomains\Edit::class)->name('add');
                Route::get('/{emailDomain}', \Sellvation\CCMV2\Ems\Livewire\EmailDomains\Edit::class)->name('edit');
            });
    });
