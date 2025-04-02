<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Sellvation\CCMV2\Extensions\Contracts\CcmCommand;
use Spatie\StructureDiscoverer\Discover;

trait HasSchedulableCommands
{
    public function registerCcmSchedulableCommands()
    {
        $reflector = new \ReflectionClass($this);
        $dir = dirname($reflector->getFileName());

        foreach (Discover::in($dir.'/Commands')
            ->classes()
            ->extending(CcmCommand::class)
            ->get() as $command) {
            \SchedulableCommands::registerCommand($command::class);
        }
    }
}
