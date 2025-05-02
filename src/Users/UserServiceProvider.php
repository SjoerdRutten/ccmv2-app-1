<?php

namespace Sellvation\CCMV2\Users;

use Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Livewire\Livewire;
use Sellvation\CCMV2\Users\Livewire\ForgotPasswordForm;
use Sellvation\CCMV2\Users\Livewire\ResetPasswordForm;
use Sellvation\CCMV2\Users\Livewire\Roles\Edit;
use Sellvation\CCMV2\Users\Livewire\Roles\Overview;
use Sellvation\CCMV2\Users\Models\PersonalAccessToken;
use Sellvation\CCMV2\Users\Models\User;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        \Config::set('auth.providers.users.model', User::class);

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        $this->loadViewsFrom(__DIR__.'/views', 'user');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if (! app()->runningInConsole()) {
            $this->registerLivewireComponents();
            $this->registerBladeDirectives();
        }

    }

    private function registerLivewireComponents()
    {
        Livewire::component('user::forgot-password-form', ForgotPasswordForm::class);
        Livewire::component('user::reset-password-form', ResetPasswordForm::class);
        Livewire::component('roles::overview', Overview::class);
        Livewire::component('roles::edit', Edit::class);
        Livewire::component('users::overview', \Sellvation\CCMV2\Users\Livewire\Users\Overview::class);
        Livewire::component('users::edit', \Sellvation\CCMV2\Users\Livewire\Users\Edit::class);
    }

    private function registerBladeDirectives()
    {
        Blade::if('permission', function (string $group, string $permission) {
            return \Auth::check() && \Auth::user()->hasPermissionTo($group, $permission);
        });
        Blade::if('isadmin', function () {
            return \Auth::check() && \Auth::user()->is_admin;
        });
    }
}
