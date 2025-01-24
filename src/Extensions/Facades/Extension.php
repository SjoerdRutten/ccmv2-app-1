<?php

namespace Sellvation\CCMV2\Extensions\Facades;

class Extension
{
    private array $jobExtensions = [];

    public function registerJobExtension($extension)
    {
        $this->jobExtensions[$extension] = new $extension;
    }

    public function getJobExtensions(): array
    {
        return $this->jobExtensions;
    }
}
