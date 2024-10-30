<?php

namespace Sellvation\CCMV2\Users;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Users\Livewire\ForgotPasswordForm;
use Sellvation\CCMV2\Users\Livewire\ResetPasswordForm;
use Sellvation\CCMV2\Users\Livewire\Roles\Edit;
use Sellvation\CCMV2\Users\Livewire\Roles\Overview;
use Sellvation\CCMV2\Users\Models\User;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        \Config::set('auth.providers.users.model', User::class);

        $this->loadViewsFrom(__DIR__.'/views', 'user');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if (! app()->runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents()
    {
        Livewire::component('user::forgot-password-form', ForgotPasswordForm::class);
        Livewire::component('user::reset-password-form', ResetPasswordForm::class);
        Livewire::component('roles::overview', Overview::class);
        Livewire::component('roles::edit', Edit::class);
    }
}
