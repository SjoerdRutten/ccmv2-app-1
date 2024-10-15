<?php

use Illuminate\Support\Facades\Route;
use Sellvation\CCMV2\Users\Http\Controllers\LoginController;
use Sellvation\CCMV2\Users\Http\Controllers\LogoutController;

Route::middleware([
    'web',
])->group(function () {
    Route::get('/login', \Sellvation\CCMV2\Users\Livewire\LoginForm::class)->name('login-form');
    Route::post('/login', LoginController::class)->name('login');

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function (): void {
        Route::get('/logout', LogoutController::class)->name('logout');
    });
});
