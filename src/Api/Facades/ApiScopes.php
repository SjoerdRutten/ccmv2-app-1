<?php

namespace Sellvation\CCMV2\Api\Facades;

class ApiScopes
{
    private array $scopes = [];

    public function addScope($scope, $description)
    {
        $this->scopes[$scope] = $description;
    }

    public function getScopes(): array
    {
        asort($this->scopes);

        return $this->scopes;
    }
}
