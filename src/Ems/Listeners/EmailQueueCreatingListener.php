<?php

namespace Sellvation\CCMV2\Ems\Listeners;

use Sellvation\CCMV2\Ems\Events\EmailQueueCreatingEvent;

class EmailQueueCreatingListener
{
    public function __construct() {}

    public function handle(EmailQueueCreatingEvent $event): void
    {
        $emailQueue = $event->emailQueue;

        $emailQueue->domain = \Arr::last(explode('@', $emailQueue->to_email));
    }
}
