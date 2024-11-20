<?php

namespace Sellvation\CCMV2\Forms\Listeners;

use Sellvation\CCMV2\Forms\Events\FormResponseCreatedEvent;
use Sellvation\CCMV2\Forms\Jobs\AttachCrmCardToFormResponseJob;
use Sellvation\CCMV2\Forms\Jobs\ProcessFormResponseJob;

class ProcessFormResponseListener
{
    public function __construct() {}

    public function handle(FormResponseCreatedEvent $event): void
    {
        AttachCrmCardToFormResponseJob::dispatch($event->formResponse)
            ->chain([
                new ProcessFormResponseJob($event->formResponse),
            ]);
    }
}
