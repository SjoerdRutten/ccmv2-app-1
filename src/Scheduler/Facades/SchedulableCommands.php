<?php

namespace Sellvation\CCMV2\Scheduler\Facades;

use Illuminate\Console\Command;

class SchedulableCommands
{
    private array $schedulableCommands = [];

    public function registerCommand($command)
    {
        $this->schedulableCommands[$command] = new $command;

        $this->schedulableCommands = \Arr::sort($this->schedulableCommands, fn (Command $row) => $row->getName());
    }

    public function getCommands()
    {
        return $this->schedulableCommands;
    }
}
