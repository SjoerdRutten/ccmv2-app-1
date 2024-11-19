<?php

namespace Sellvation\CCMV2\Forms\Listeners;

use Sellvation\CCMV2\Forms\Events\FormCreatingEvent;

class AddUuidToFormListener
{
    public function __construct() {}

    public function handle(FormCreatingEvent $event): void
    {
        $event->form->uuid = \Str::uuid();
    }
}
