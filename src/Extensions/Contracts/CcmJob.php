<?php

namespace Sellvation\CCMV2\Extensions\Contracts;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sellvation\CCMV2\Extensions\Traits\InteractsWithCcmpCrmCards;

abstract class CcmJob
{
    use Dispatchable;
    use InteractsWithCcmpCrmCards;
    use InteractsWithCcmpCrmCards;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public array $settings,
        public CcmEvent $event
    ) {
        $this->queue = 'ccmv2';
    }

    protected function getSetting($key)
    {
        return \Arr::get($this->settings, $key);
    }

    protected function setEnvironmentId(int $environmentId)
    {
        \Context::add('environment_id', $environmentId);
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
