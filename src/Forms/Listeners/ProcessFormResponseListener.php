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
        // First add all actions which have to be executes always
        foreach (\FormAction::getAlwaysExecuteFormActions() as $action) {
            $batch[] = $action->setFormResponse($event->formResponse)
                ->setForm($event->formResponse->form);
        }

        // Add the selected actions of the form, and add these to the batch
        foreach ($event->formResponse->form->async_actions as $async_action) {
            $batch[] = new ($async_action['action'])($event->formResponse->form, $event->formResponse, \Arr::get($async_action, 'params', []));
        }

        Bus::chain([
            new AttachCrmCardToFormResponseJob($event->formResponse),
            new ProcessFormResponseJob($event->formResponse),
            Bus::batch($batch),
        ])->dispatch();
    }
}
