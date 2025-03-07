<?php

namespace Sellvation\CCMV2\Ems;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Ems\Events\EmailDkimCreatedEvent;
use Sellvation\CCMV2\Ems\Events\EmailQueueCreatedEvent;
use Sellvation\CCMV2\Ems\Events\EmailQueueCreatingEvent;
use Sellvation\CCMV2\Ems\Events\EmailSavedEvent;
use Sellvation\CCMV2\Ems\Facades\EmailCompiler;
use Sellvation\CCMV2\Ems\Facades\EmailCompilerFacade;
use Sellvation\CCMV2\Ems\Listeners\EmailDkimCreatedListener;
use Sellvation\CCMV2\Ems\Listeners\EmailQueueCreatedListener;
use Sellvation\CCMV2\Ems\Listeners\EmailQueueCreatingListener;
use Sellvation\CCMV2\Ems\Listeners\EmailSavedListener;

class EmsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'ems');

        $this->registerFacades();
        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('ems::emails::overview', \Sellvation\CCMV2\Ems\Livewire\Emails\Overview::class);
        Livewire::component('ems::emails::edit', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class);

        Livewire::component('ems::emailcontents::overview', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Overview::class);
        Livewire::component('ems::emailcontents::edit', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Edit::class);

        Livewire::component('ems::emaildomains::overview', \Sellvation\CCMV2\Ems\Livewire\EmailDomains\Overview::class);
        Livewire::component('ems::emaildomains::edit', \Sellvation\CCMV2\Ems\Livewire\EmailDomains\Edit::class);

        Livewire::component('ems::mailings::overview', \Sellvation\CCMV2\Ems\Livewire\Mailings\Overview::class);
        Livewire::component('ems::mailings::edit', \Sellvation\CCMV2\Ems\Livewire\Mailings\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(EmailDkimCreatedEvent::class, EmailDkimCreatedListener::class);
        $events->listen(EmailSavedEvent::class, EmailSavedListener::class);
        $events->listen(EmailQueueCreatedEvent::class, EmailQueueCreatedListener::class);
        $events->listen(EmailQueueCreatingEvent::class, EmailQueueCreatingListener::class);
    }

    private function registerFacades()
    {
        $this->app->bind('email-compiler', EmailCompiler::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('EmailCompiler', EmailCompilerFacade::class);
    }
}
