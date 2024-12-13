<?php

namespace Sellvation\CCMV2\Ems\Listeners;

use Sellvation\CCMV2\Ems\Events\EmailDkimCreatedEvent;
use Sellvation\CCMV2\Ems\Jobs\GenerateDkimJob;

class EmailDkimCreatedListener
{
    public function __construct() {}

    public function handle(EmailDkimCreatedEvent $event): void
    {
        GenerateDkimJob::dispatch($event->emailDkim);
    }
}
