<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Sellvation\CCMV2\Extensions\Contracts\CcmEvent;
use Sellvation\CCMV2\Extensions\Contracts\CcmJob;
use Spatie\StructureDiscoverer\Discover;

trait HasExtensions
{
    public function registerCcmExtensions()
    {
        $reflector = new \ReflectionClass($this);
        $dir = dirname($reflector->getFileName());

        foreach (Discover::in($dir.'/Events')
            ->classes()
            ->extending(CcmEvent::class)
            ->get() as $event) {
            \ExtensionService::registerExtensionEvent($event);
        }

        foreach (Discover::in($dir.'/Jobs')
            ->classes()
            ->extending(CcmJob::class)
            ->get() as $job) {
            \ExtensionService::registerExtensionJob($job);
        }
    }
}
