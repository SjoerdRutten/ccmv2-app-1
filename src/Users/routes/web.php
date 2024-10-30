<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Users\Http\Controllers\LoginController;
use Sellvation\CCMV2\Users\Http\Controllers\LogoutController;

Route::middleware([
    'web',
])->group(function () {
    Route::get('/login', \Sellvation\CCMV2\Users\Livewire\LoginForm::class)->name('login-form');
    Route::get('/forgot-password', \Sellvation\CCMV2\Users\Livewire\ForgotPasswordForm::class)->name('forgot-password-form');
    Route::get('/reset-password/{token}', \Sellvation\CCMV2\Users\Livewire\ResetPasswordForm::class)->name('reset-password-form');
    Route::post('/login', LoginController::class)->name('login');

    Route::middleware([
        'auth:sanctum',
        'verified',
    ])->group(function (): void {
        Route::get('/logout', LogoutController::class)->name('logout');
    });

    Route::prefix('roles')
        ->name('roles::')
        ->group(function () {
            Route::get('/', \Sellvation\CCMV2\Users\Livewire\Roles\Overview::class)->name('overview');
            Route::get('/edit/{role?}', \Sellvation\CCMV2\Users\Livewire\Roles\Edit::class)->name('edit');
        });
});
