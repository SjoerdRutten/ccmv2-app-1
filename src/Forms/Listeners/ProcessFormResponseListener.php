<?php

namespace Sellvation\CCMV2\Forms\Listeners;

use Illuminate\Support\Facades\Bus;
use Sellvation\CCMV2\Forms\Events\FormResponseCreatedEvent;
use Sellvation\CCMV2\Forms\Jobs\AttachCrmCardToFormResponseJob;
use Sellvation\CCMV2\Forms\Jobs\ProcessFormResponseJob;

class ProcessFormResponseListener
{
    public function __construct() {}

    public function handle(FormResponseCreatedEvent $event): void
    {
        $batch = [];

        Bus::chain([
            new AttachCrmCardToFormResponseJob($event->formResponse),
            new ProcessFormResponseJob($event->formResponse),
            Bus::batch($batch),
        ])->dispatch();
    }
}
