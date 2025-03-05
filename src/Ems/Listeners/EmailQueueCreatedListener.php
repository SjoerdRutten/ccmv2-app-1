<?php

namespace Sellvation\CCMV2\Ems\Listeners;

use Sellvation\CCMV2\Ems\Events\EmailQueueCreatedEvent;
use Sellvation\CCMV2\Ems\Jobs\SendEmailJob;

class EmailQueueCreatedListener
{
    public function __construct() {}

    public function handle(EmailQueueCreatedEvent $event): void
    {
        SendEmailJob::dispatch($event->emailQueue)
            ->delay($event->emailQueue->start_sending_at);
    }
}
