<?php

namespace Sellvation\CCMV2\CrmCards\Facades;

use Spatie\StructureDiscoverer\Discover;

class CrmFieldCorrector
{
    private array $correctors = [];

    public function registerCrmFieldCorrector(\Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector $crmFieldCorrector)
    {
        $this->correctors[$crmFieldCorrector->group][] = $crmFieldCorrector;

        $this->correctors[$crmFieldCorrector->group] = \Arr::sort($this->correctors[$crmFieldCorrector->group], fn ($row) => $row->name);
    }

    public function discover()
    {
        foreach (Discover::in(__DIR__.'/../FieldCorrectors')
            ->classes()
            ->extending(\Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector::class)
            ->get() as $corrector) {
            $x = new $corrector;

            $this->registerCrmFieldCorrector($x);
        }
    }

    public function getCorrectors(?string $group = null)
    {
        return $group ? \Arr::get($this->correctors, $group) : $this->correctors;
    }
}
