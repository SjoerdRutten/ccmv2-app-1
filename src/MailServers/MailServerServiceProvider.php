<?php

namespace Sellvation\CCMV2\MailServers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\MailServers\Commands\AddSshKeysToMailserversCommand;
use Sellvation\CCMV2\MailServers\Commands\CheckMailServersCommand;
use Sellvation\CCMV2\MailServers\Livewire\MailServers\Edit;
use Sellvation\CCMV2\MailServers\Livewire\MailServers\Overview;
use Sellvation\CCMV2\MailServers\Models\MailServer;

class MailServerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerEvents();
        $this->registerLivewireComponents();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'mailservers');
        $this->commands([
            CheckMailServersCommand::class,
            AddSshKeysToMailserversCommand::class,
        ]);

        try {
            foreach (Mailserver::where('is_active', 1)->get() as $mailserver) {
                Config::set('mail.mailers.'.$mailserver->keyName, [
                    'transport' => 'sendmail',
                    'path' => '/usr/sbin/sendmail -bs -i',
                ]);
            }
        } catch (\Exception $e) {
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('mailservers::overview', Overview::class);
        Livewire::component('mailservers::edit', Edit::class);
        Livewire::component('sendrules::overview', \Sellvation\CCMV2\MailServers\Livewire\SendRules\Overview::class);
        Livewire::component('sendrules::edit', \Sellvation\CCMV2\MailServers\Livewire\SendRules\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
    }
}
