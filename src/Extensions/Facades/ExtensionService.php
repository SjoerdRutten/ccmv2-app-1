<?php

namespace Sellvation\CCMV2\Extensions\Facades;

use Sellvation\CCMV2\Extensions\Contracts\CcmEvent;
use Sellvation\CCMV2\Extensions\Contracts\CcmJob;

class ExtensionService
{
    private array $extensionJobs = [];

    private array $extensionEvents = [];

    public function registerExtensionJob(string $listener): void
    {
        if (is_subclass_of($listener, CcmJob::class)) {
            $this->extensionJobs[$listener] = $listener::getName();
        }
    }

    public function registerExtensionEvent(string $event)
    {
        if (is_subclass_of($event, CcmEvent::class)) {
            $this->extensionEvents[$event] = $event::getName();
        }
    }

    public function getExtensionJobs(): array
    {
        return $this->extensionJobs;
    }

    public function getExtensionEvents(): array
    {
        return $this->extensionEvents;
    }
}
