<?php

namespace Sellvation\CCMV2\Extensions\Contracts;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class CcmJob
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $settings,
        public CcmEvent $event
    ) {
        $this->queue = 'ccmv2';
    }

    /**
     * Returns string with name of listener
     */
    abstract public static function getName(): string;

    /**
     * Returns string with description of listener
     */
    abstract public static function getDescription(): string;

    /**
     * Return array with settings
     */
    abstract public static function getSettingsForm(): array;

    /**
     * Event handler
     */
    abstract public function handle(): void;
}
