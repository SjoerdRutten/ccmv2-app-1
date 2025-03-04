<?php

namespace Sellvation\CCMV2\Ems\Listeners;

use Sellvation\CCMV2\Ems\Events\EmailSavedEvent;
use Sellvation\CCMV2\Ems\Jobs\MakeEmailTrackingLinksJob;

class EmailSavedListener
{
    public function __construct() {}

    public function handle(EmailSavedEvent $event): void
    {
        MakeEmailTrackingLinksJob::dispatch($event->email);
    }
}
