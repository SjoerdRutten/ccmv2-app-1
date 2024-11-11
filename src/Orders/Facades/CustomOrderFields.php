<?php

namespace Sellvation\CCMV2\Orders\Facades;

use Sellvation\CCMV2\TargetGroups\Elements\Column;

class CustomOrderFields
{
    private array $schemaFields = [];

    private array $ruleFields = [];

    public function addSchemaField(string $tableName, array $field)
    {
        $this->schemaFields[$tableName][] = $field;
    }

    public function addRuleField(string $tableName, Column $column)
    {
        $this->ruleFields[$tableName][] = $column;
    }

    public function getSchemaFields(string $tableName): array
    {
        return $this->schemaFields[$tableName] ?? [];
    }

    public function getRuleFields(string $tableName): array
    {
        return $this->ruleFields[$tableName] ?? [];
    }
}
