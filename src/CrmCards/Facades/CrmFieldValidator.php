<?php

namespace Sellvation\CCMV2\CrmCards\Facades;

use Spatie\StructureDiscoverer\Discover;

class CrmFieldValidator
{
    private array $validators = [];

    public function registerCrmFieldValidator(\Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator $crmFieldValidator)
    {
        $this->validators[$crmFieldValidator->group][] = $crmFieldValidator;
        $this->validators[$crmFieldValidator->group] = \Arr::sort($this->validators[$crmFieldValidator->group], fn ($row) => $row->name);
    }

    public function discover()
    {
        foreach (Discover::in(__DIR__.'/../FieldValidators')
            ->classes()
            ->extending(\Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator::class)
            ->get() as $corrector) {
            $x = new $corrector;

            $this->registerCrmFieldValidator($x);
        }
    }

    public function getValidators(?string $group = null)
    {
        $this->discover();

        return $group ? \Arr::get($this->validators, $group) : $this->validators;
    }
}
